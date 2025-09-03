<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Shop;
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
            $methods = DB::table('shop_shipping_methods as ssm')
                ->join('shipping_methods as sm', 'sm.id', '=', 'ssm.shipping_method_id')
                ->where('ssm.shop_id', $shopId)
                ->where('ssm.enabled', true)
                ->select(
                    'ssm.id as shop_shipping_method_id',
                    'sm.id as shipping_method_id',
                    'sm.courier_code',
                    'sm.service_code',
                    'sm.courier_name',
                    'sm.service_name',
                    'sm.description'
                )
                ->get();

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

        $method = DB::table('shipping_methods')->where('id', $methodId)->first();
        if (! $method) {
            return response()->json(['error' => 'Metode pengiriman tidak ditemukan.'], 422);
        }

        $cart      = $user->cart;
        $cartItems = is_string($cart->items) ? (json_decode($cart->items, true) ?? []) : ($cart->items ?? []);
        $grouped   = collect($cartItems)->groupBy('shop_id');

        $result = [];

        foreach ($grouped as $shopId => $items) {
            $shop = DB::table('shops')->where('id', $shopId)->first();
            if (! $shop || empty($shop->postal)) {
                continue;
            }

            $originPostal = $shop->postal;

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

            $result[$shopId] = $rates;
        }

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $user      = Auth::user();
        $cart      = $user->cart;
        $cartItems = $cart->items ?? [];
        $addresses = $user->addresses ?? [];

        $address = $addresses[$request->address_id] ?? null;
        if (! $address) {
            return back()->with('error', 'Alamat tidak ditemukan.');
        }

        $shippingSelections = $request->shipping ?? [];

        $shopGroups = collect($cartItems)->groupBy('shop_id');
        foreach ($shopGroups as $shopId => $items) {
            if (! isset($shippingSelections[$shopId]['courier']) || empty($shippingSelections[$shopId]['courier'])) {
                return back()->with('error', "Kurir belum dipilih untuk toko " . ($items[0]['shop_name'] ?? $shopId));
            }
        }

        $orders = [];

        DB::beginTransaction();
        try {
            // Group items by shop
            foreach (collect($cartItems)->groupBy('shop_id') as $shopId => $items) {
                $shopName = $items[0]['shop_name'] ?? 'Unknown Shop';

                // Ambil pilihan kurir user untuk shop ini
                $shippingChoice = $shippingSelections[$shopId]['courier'] ?? null;
                if (! $shippingChoice) {
                    throw new \Exception("Kurir belum dipilih untuk toko $shopName");
                }

                $shippingData = json_decode($shippingChoice, true);

                // Hitung subtotal
                $subtotal     = collect($items)->sum(fn($it) => (float) $it['item_total']);
                $shippingCost = $shippingData['price'] ?? 0;
                $totalAmount  = $subtotal + $shippingCost;

                // Buat Order
                $order = Order::create([
                    'user_id'        => $user->id,
                    'shop_id'        => $shopId,
                    'status'         => 'paid', // langsung auto-paid
                    'invoice_number' => Order::generateInvoiceNumber(),
                    'order_details'  => [
                        'address'  => $address,
                        'items'    => $items->toArray(),
                        'shipping' => $shippingData,
                    ],
                    'payment_detail' => [
                        'subtotal'        => $subtotal,
                        'shipping_cost'   => $shippingCost,
                        'tax_amount'      => 0,
                        'discount_amount' => 0,
                        'total_amount'    => $totalAmount,
                    ],
                ]);

                // Buat Payment record auto-paid
                OrderPayment::create([
                    'order_id'     => $order->id,
                    'reference_id' => 'AUTO-PAID-' . uniqid(),
                    'channel'      => 'manual',
                    'status'       => 'success',
                    'value'        => $totalAmount,
                ]);

                $orders[] = $order;
            }

            // Kosongkan cart
            $cart->update(['items' => []]);

            DB::commit();

            // Redirect ke success page, bisa kirim id order pertama
            return redirect()->route('checkout.success')->with('message', 'Pesanan berhasil dibuat!');
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function success()
    {
        return view('buyer.checkout.success');
    }

    public function debugRates(Request $request, BiteshipService $biteship)
    {
        $user      = Auth::user();
        $addressId = $request->query('address_id'); // ambil dari query string
        $methodId  = $request->query('method_id');

        // ambil address user
        $addresses = is_string($user->addresses) ? json_decode($user->addresses, true) : ($user->addresses ?? []);
        $address   = collect($addresses)->firstWhere('id', $addressId);

        if (! $address || empty($address['postal_code'])) {
            return response()->json(['error' => 'Alamat tidak ditemukan / postal_code kosong'], 422);
        }

        $destinationPostal = $address['postal_code'];

        // ambil shipping method
        $method = DB::table('shipping_methods')->where('id', $methodId)->first();
        if (! $method) {
            return response()->json(['error' => 'Metode pengiriman tidak ditemukan'], 422);
        }

        // ambil cart
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

            // langsung panggil biteship
            $rates = $biteship->getRates($originPostal, $destinationPostal, $biteshipItems, [$method->courier_code]);

            // dd($method->courier_code);
            $result[$shopId] = $rates; // balikin mentah
        }

        return response()->json($result);
    }

}
