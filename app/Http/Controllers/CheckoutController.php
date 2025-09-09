<?php
namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Order;
use App\Models\Promotion;
use App\Traits\CartTrait;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use App\Services\BiteshipService;
use App\Models\ShopShippingMethod;
use Illuminate\Support\Facades\DB;
use App\Jobs\CreateBiteshipOrderJob;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    use CartTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $currentUser = $request->user();
        $currentUser->load('cart');
        $cart = $currentUser->cart;

        $addresses       = $currentUser->addresses ?? [];
        $shippingOptions = [];

        $cartData = $this->handleCartData($cart, true);
        $cartItems = $cartData['cartItems'];
        $paymentFeeConfig = $cartData['paymentFeeConfig'];

        return view('buyer.checkout.index', compact(
            'cart',
            'cartItems',
            'addresses',
            'shippingOptions',
            'paymentFeeConfig',
        ));
    }

    public function getShippingMethods(Request $request)
    {
        $user = auth()->user();
        $cart = $user->cart;

        $cartItems = [];
        if ($cart) {
            if (is_array($cart->items)) {
                $cartItems = $cart->items;
            } elseif (is_string($cart->items)) {
                $decoded   = json_decode($cart->items, true);
                $cartItems = is_array($decoded) ? $decoded : [];
            }
        }

        $grouped = collect($cartItems)->groupBy('shop_id');
        $result  = [];

        foreach ($grouped as $shopId => $items) {
            $shop = Shop::find($shopId);
            if (! $shop) {
                continue;
            }

            // Get shipping methods that are:
            // 1. Enabled by the seller (shop_shipping_methods.enabled = true)
            // 2. AND active by admin (shipping_methods.active = true)
            $methods = ShippingMethod::whereHas('shopShippingMethods', function ($query) use ($shopId) {
                $query->where('shop_id', $shopId)
                      ->where('enabled', true);
            })
            ->where('active', true) // Admin must have enabled it
            ->get()
            ->map(function ($method) {
                return [
                    'shipping_method_id' => $method->id,
                    'courier_code'       => $method->courier_code,
                    'service_code'       => $method->service_code,
                    'courier_name'       => $method->courier_name,
                    'service_name'       => $method->service_name,
                    'description'        => $method->description,
                    'logo_url'           => $method->logo_url,
                ];
            });

            $result[$shopId] = $methods;
        }

        return response()->json($result);
    }

    public function rates(Request $request, BiteshipService $biteship)
    {
        $user      = auth()->user();
        $addressId = $request->address_id;
        $methodId  = $request->method_id;

        $addresses = is_string($user->addresses) ? json_decode($user->addresses, true) : ($user->addresses ?? []);
        $address   = collect($addresses)->firstWhere('id', $addressId);
        if (! $address || empty($address['postal_code'])) {
            return response()->json(['error' => 'Alamat tidak ditemukan.'], 422);
        }
        $destinationPostal = $address['postal_code'];

        // Check if the shipping method exists and is active (enabled by admin)
        $method = ShippingMethod::where('id', $methodId)
            ->where('active', true)
            ->first();
        if (! $method) {
            return response()->json(['error' => 'Metode pengiriman tidak ditemukan atau tidak aktif.'], 422);
        }

        $cart      = $user->cart;
        $cartItems = is_string($cart->items) ? (json_decode($cart->items, true) ?? []) : ($cart->items ?? []);
        $grouped   = collect($cartItems)->groupBy('shop_id');

        $result = [];

        foreach ($grouped as $shopId => $items) {
            $shop = Shop::where('id', $shopId)->first();
            if (! $shop || empty($shop->postal_code)) {
                continue;
            }

            // Check if this shop has enabled this shipping method
            $shopShippingMethod = ShopShippingMethod::where('shop_id', $shopId)
                ->where('shipping_method_id', $methodId)
                ->where('enabled', true)
                ->first();

            if (! $shopShippingMethod) {
                continue; // Skip if shop hasn't enabled this method
            }

            $originPostal = $shop->postal_code;

            $biteshipItems = [];

            foreach ($items as $it) {
                $qty = (int) ($it['available_quantity'] ?? $it['quantity'] ?? 0);
                if ($qty <= 0) {
                    continue;
                }

                $biteshipItems[] = [
                    'name'     => $it['name'],
                    'value'    => (int) round($it['price'] ?? 0),
                    'weight'   => (float) ($it['weight'] ?? 0),
                    'quantity' => $qty,
                ];
            }

            if (empty($biteshipItems)) {
                continue;
            }

            $rates = $biteship->getRates($originPostal, $destinationPostal, $biteshipItems, [$method->courier_code]);

            $matchedRate = collect($rates)->firstWhere('courier_service_code', $method->service_code);

            if ($matchedRate) {
                $result[$shopId] = $matchedRate;
            }
        }

        return response()->json($result);
    }

    public function store(Request $request, BiteshipService $biteship)
    {
        $user      = auth()->user();
        $cart      = $user->cart;
        $cartData = $this->handleCartData($cart, true);

        $cartItems = $cartData['cartItems'];
        $paymentFeeConfig = $cartData['paymentFeeConfig'];
        $addresses = $user->addresses ?? [];

        $address = collect($addresses)->firstWhere('id', $request->address_id);
        if (! $address) {
            return back()->with('error', 'Alamat tidak ditemukan.');
        }

        $shippingSelections = $request->shipping ?? [];

        $shopGroups = collect($cartItems)->groupBy('shop_id');
        foreach ($shopGroups as $shopId => $items) {
            if (! isset($shippingSelections[$shopId]['method_id']) || empty($shippingSelections[$shopId]['method_id'])) {
                return back()->with('error', "Kurir belum dipilih untuk toko " . ($items[0]['shop_name'] ?? $shopId));
            }
        }

        $orders = [];

        DB::beginTransaction();
        try {
            foreach ($shopGroups as $shopId => $items) {
                $shop = Shop::find($shopId);
                if (! $shop || empty($shop->postal_code)) {
                    throw new \Exception("Shop $shopId tidak punya kode pos.");
                }

                $shopName = $items[0]['shop_name'] ?? 'Unknown Shop';
                $methodId = $shippingSelections[$shopId]['method_id'];

                $shopShipping = ShopShippingMethod::with('shippingMethod')
                    ->where('shop_id', $shopId)
                    ->where('shipping_method_id', $methodId)
                    ->where('enabled', true) // Seller must have enabled it
                    ->first();
                if (! $shopShipping) {
                    throw new \Exception("Kurir tidak valid atau tidak aktif untuk toko $shopName");
                }

                $shippingMethod = $shopShipping->shippingMethod;

                // Additional check: Admin must have enabled the shipping method
                if (! $shippingMethod || ! $shippingMethod->active) {
                    throw new \Exception("Metode pengiriman {$shippingMethod->courier_name} - {$shippingMethod->service_name} tidak tersedia");
                }

                $biteshipItems = collect($items)->map(function ($it) {
                    return [
                        'name'     => $it['name'],
                        'value'    => (int) $it['price'],
                        'weight'   => (float) round($it['weight'] ?? 0),
                        'quantity' => (int) ($it['available_quantity'] ?? $it['quantity']),
                    ];
                })->toArray();

                $rates = $biteship->getRates(
                    $shop->postal_code,
                    $address['postal_code'],
                    $biteshipItems,
                    [$shippingMethod->courier_code]
                );

                $pickedRate = collect($rates)->firstWhere('courier_service_code', $shippingMethod->service_code);

                if (! $pickedRate) {
                    throw new \Exception("Tidak ada ongkir untuk {$shippingMethod->courier_name} - {$shippingMethod->service_name}");
                }

                $shippingCost = $pickedRate['price'] ?? 0;
                $subtotal     = collect($items)->sum(fn($it) => (float) $it['item_total']);
                $paymentFee = ($paymentFeeConfig['type'] === 'fixed')
                    ? $paymentFeeConfig['fixed']
                    : max(($paymentFeeConfig['percent'] / 100) * $subtotal, $paymentFeeConfig['percent_min_value']);

                // Handle promo code discount
                $appliedPromo = session('applied_promo');
                $discountAmount = 0;
                $promoData = null;

                if ($appliedPromo && count($shopGroups) === 1) {
                    // Only apply promo if there's only one shop (single order)
                    $promotion = Promotion::find($appliedPromo['id']);
                    if ($promotion && $promotion->canBeUsed($subtotal)) {
                        $discountAmount = $promotion->calculateDiscount($subtotal);
                        $promoData = [
                            'code' => $promotion->code,
                            'name' => $promotion->name,
                            'discount_amount' => $discountAmount,
                        ];

                        // Increment usage count
                        $promotion->incrementUsage();
                    }
                }

                $totalAmount = $subtotal + $shippingCost + $paymentFee - $discountAmount;

                // Build payment details
                $paymentDetails = [
                    'subtotal'        => (int) $subtotal,
                    'shipping_cost'   => (int) $shippingCost,
                    'payment_fee'     => (int) $paymentFee,
                    'discount_amount' => (int) $discountAmount,
                    'total_amount'    => (int) $totalAmount,
                ];

                // Add promo data if applied
                if ($promoData) {
                    $paymentDetails['promo'] = $promoData;
                }

                $order = Order::create([
                    'user_id'        => $user->id,
                    'shop_id'        => $shopId,
                    'status'         => 'pending',
                    'invoice'        => Order::generateInvoiceNumber(),
                    'order_details'  => [
                        'address'  => (array) $address,
                        'items'    => $items->toArray(),
                        'shipping' => [
                            'courier_code' => $shippingMethod->courier_code,
                            'courier_name' => $shippingMethod->courier_name,
                            'service_code' => $shippingMethod->service_code,
                            'service_name' => $shippingMethod->service_name,
                            'description'  => $shippingMethod->description,
                            'price'        => $shippingCost,
                            'collection_method' => is_array($pickedRate['available_collection_method']) && in_array('pickup', $pickedRate['available_collection_method']) ? 'pickup' : 'drop_off',
                        ],
                    ],
                    'payment_detail' => $paymentDetails,
                ]);

                OrderPayment::create([
                    'order_id'          => $order->id,
                    'payment_method_id' => null,
                    'channel'           => 'emaal',
                    'reference_id'      => Order::generateReferenceId(),
                    'status'            => 'pending',
                    'value'             => (int) $totalAmount,
                    'payment_fee'       => (int) $paymentFee,
                    'expired_at'        => now()->addDay(),
                ]);

                $orders[] = $order;
            }

            $cart->update(['items' => json_encode([])]);

            // Clear applied promo after successful order
            session()->forget('applied_promo');

            DB::commit();

            return redirect('/checkout/success?order_id='.join(',', collect($orders)->pluck('id')->toArray()))
                ->with('message', 'Pesanan berhasil dibuat!');
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $orderIds = $request->query('order_id');

        $orders = $orderIds ? explode(',', $orderIds) : [];

        $payments = OrderPayment::whereIn('order_id', $orders)
            ->where('status', 'pending')
            ->where('expired_at', '>', now())
            ->orderBy('created_at', 'DESC')
            ->get()->take(1);

        if ($payments->isEmpty()) {
            return redirect('/me')->withMessage('Tidak ada pembayaran yang ditemukan atau sudah kadaluarsa.');
        }

        return view('buyer.checkout.success', compact('payments'));
    }

    /**
     * Apply promo code
     */
    public function applyPromoCode(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $promoCode = strtoupper(trim($request->promo_code));
        $subtotal = $request->subtotal;

        // Find promotion
        $promotion = Promotion::where('code', $promoCode)
            ->available()
            ->first();

        if (!$promotion) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo tidak valid atau sudah tidak aktif'
            ]);
        }

        // Check if can be used with current order amount
        if (!$promotion->canBeUsed($subtotal)) {
            $minAmount = number_format($promotion->minimum_order_amount, 0, ',', '.');
            return response()->json([
                'success' => false,
                'message' => "Minimum pembelian untuk kode promo ini adalah Rp{$minAmount}"
            ]);
        }

        // Calculate discount
        $discountAmount = $promotion->calculateDiscount($subtotal);

        // Store promo in session
        session(['applied_promo' => [
            'id' => $promotion->id,
            'code' => $promotion->code,
            'name' => $promotion->name,
            'discount_amount' => $discountAmount,
        ]]);

        return response()->json([
            'success' => true,
            'message' => 'Kode promo berhasil diterapkan!',
            'promo' => [
                'code' => $promotion->code,
                'name' => $promotion->name,
                'discount_amount' => $discountAmount,
                'discount_formatted' => number_format($discountAmount, 0, ',', '.'),
            ]
        ]);
    }

    /**
     * Remove promo code
     */
    public function removePromoCode(Request $request)
    {
        session()->forget('applied_promo');

        return response()->json([
            'success' => true,
            'message' => 'Kode promo berhasil dihapus'
        ]);
    }

    /**
     * Get current applied promo
     */
    public function getCurrentPromo(Request $request)
    {
        $appliedPromo = session('applied_promo');

        if (!$appliedPromo) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada promo yang diterapkan'
            ]);
        }

        return response()->json([
            'success' => true,
            'promo' => $appliedPromo
        ]);
    }
}
