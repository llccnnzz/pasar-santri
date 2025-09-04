<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\ShippingMethod;
use App\Models\Shop;
use App\Models\ShopShippingMethod;
use App\Services\BiteshipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
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

        $addresses       = $user->addresses ?? [];
        $shippingOptions = [];

        return view('buyer.checkout.index', compact('cart', 'cartItems', 'addresses', 'shippingOptions'));
    }

    public function getShippingMethods(Request $request)
    {
        $user = Auth::user();
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
            $shop = Shop::with('shippingMethodsEnabled')->find($shopId);
            if (! $shop) {
                continue;
            }

            $methods = $shop->shippingMethodsEnabled->map(function ($method) {
                return [
                    'shipping_method_id' => $method->id,
                    'courier_code'       => $method->courier_code,
                    'service_code'       => $method->service_code,
                    'courier_name'       => $method->courier_name,
                    'service_name'       => $method->service_name,
                    'description'        => $method->description,
                ];
            });

            $result[$shopId] = $methods;
        }

        return response()->json($result);
    }

    public function rates(Request $request, BiteshipService $biteship)
    {
        $user      = Auth::user();
        $addressId = $request->address_id;
        $methodId  = $request->method_id;

        $addresses = is_string($user->addresses) ? json_decode($user->addresses, true) : ($user->addresses ?? []);
        $address   = collect($addresses)->firstWhere('id', $addressId);
        if (! $address || empty($address['postal_code'])) {
            return response()->json(['error' => 'Alamat tidak ditemukan.'], 422);
        }
        $destinationPostal = $address['postal_code'];

        $method = ShippingMethod::where('id', $methodId)->first();
        if (! $method) {
            return response()->json(['error' => 'Metode pengiriman tidak ditemukan.'], 422);
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

            $originPostal = $shop->postal_code;

            $biteshipItems = [];
            foreach ($items as $it) {
                $weightGram      = (int) round(($it['weight'] ?? 0) * 1000);
                $biteshipItems[] = [
                    'name'     => $it['name'],
                    'value'    => (int) $it['price'],
                    'weight'   => $weightGram,
                    'quantity' => (int) $it['quantity'],
                ];
            }

            $rates = $biteship->getRates($originPostal, $destinationPostal, $biteshipItems, [$method->courier_code]);

            // ✅ Filter sesuai service_code yang dipilih user
            $matchedRate = collect($rates)->firstWhere('courier_service_code', $method->service_code);

            if ($matchedRate) {
                $result[$shopId] = $matchedRate;
            }
        }

        return response()->json($result);
    }

    public function store(Request $request, BiteshipService $biteship)
    {
        $user      = Auth::user();
        $cart      = $user->cart;
        $cartItems = is_string($cart->items) ? json_decode($cart->items, true) : ($cart->items ?? []);
        $addresses = $user->addresses ?? [];

        // Pastikan alamat valid
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
                    ->first();
                if (! $shopShipping) {
                    throw new \Exception("Kurir tidak valid untuk toko $shopName");
                }

                $shippingMethod = $shopShipping->shippingMethod;

                $biteshipItems = collect($items)->map(function ($it) {
                    return [
                        'name'     => $it['name'],
                        'value'    => (int) $it['price'],
                        'weight'   => (int) round(($it['weight'] ?? 0) * 1000),
                        'quantity' => (int) $it['quantity'],
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
                $totalAmount  = $subtotal + $shippingCost;

                $order = Order::create([
                    'user_id'        => $user->id,
                    'shop_id'        => $shopId,
                    'status'         => 'confirmed',
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
                        ],
                    ],
                    'payment_detail' => [
                        'subtotal'        => (float) $subtotal,
                        'shipping_cost'   => (float) $shippingCost,
                        'tax_amount'      => 0,
                        'discount_amount' => 0,
                        'total_amount'    => (float) $totalAmount,
                    ],
                ]);

                OrderPayment::create([
                    'order_id'          => $order->id,
                    'payment_method_id' => null,
                    'channel'           => 'manual',
                    'reference_id'      => 'AUTO-PAID-' . uniqid(),
                    'status'            => 'success',
                    'value'             => $totalAmount,
                ]);

                $orders[] = $order;
            }
            
            $cart->update(['items' => json_encode([])]);
            
            DB::commit();

            return redirect()->route('checkout.success')
                ->with('message', 'Pesanan berhasil dibuat!')
                ->with('orders', collect($orders)->pluck('id'));
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function success()
    {
        $orders = session('orders', []);
        return view('buyer.checkout.success', compact('orders'));
    }
}
