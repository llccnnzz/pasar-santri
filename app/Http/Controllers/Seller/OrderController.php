<?php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderUpdateStatusRequest;
use App\Models\Order;
use App\Notifications\BuyerNotification;
use App\Notifications\SellerNotification;
use App\Services\BiteshipService;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Milon\Barcode\DNS1D;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $shop = auth()->user()->shop;

        $query = Order::with(['user', 'payments'])
            ->where('shop_id', $shop['id']);

        $currentStatus = $request->get('status', 'paid');
        $query->where('status', $currentStatus);

        if ($request->filled('search')) {
            $search = $request['search'];
            $query->where(function ($q) use ($search) {
                $q->where('invoice', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        $views = [
            'paid'       => 'seller.orders.paid.index',
            'confirmed'  => 'seller.orders.confirmed.index',
            'processing' => 'seller.orders.processing.index',
            'shipped'    => 'seller.orders.shipped.index',
            'delivered'  => 'seller.orders.delivered.index',
            'finished'   => 'seller.orders.finished.index',
            'cancelled'  => 'seller.orders.cancelled.index',
        ];

        $view = $views[$currentStatus] ?? 'seller.orders.index';

        return view($view, compact('orders', 'currentStatus'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['user', 'shop', 'payments']);

        $currentStatus = $order->status;

        $views = [
            'paid'       => 'seller.orders.paid.show',
            'confirmed'  => 'seller.orders.confirmed.show',
            'processing' => 'seller.orders.processing.show',
            'shipped'    => 'seller.orders.shipped.show',
            'delivered'  => 'seller.orders.delivered.show',
            'finished'   => 'seller.orders.finished.show',
            'cancelled'  => 'seller.orders.cancelled.show',
        ];

        $view = $views[$currentStatus] ?? null;

        if (! $view) {
            return redirect()->back()->withErrors("Can't show order with status: " . $currentStatus);
        }

        return view($view, compact('order', 'currentStatus'));
    }

    public function updateCourier(Request $request, Order $order, BiteshipService $biteship)
    {
        if ($order->status !== 'confirmed') {
            return back()->withErrors(['status' => 'Courier can only be updated if order is still confirmed.']);
        }

        $shop           = auth()->user()->shop;
        $shippingMethod = $shop->shippingMethods()->findOrFail($request->shipping_method_id);

        $orderDetails = $order->order_details;
        $address      = $orderDetails['address'] ?? null;
        $items        = $orderDetails['items'] ?? [];

        if (! $address) {
            return back()->withErrors(['address' => 'Order has no shipping address.']);
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
            return back()->withErrors(['shipping' => 'No valid rate found for selected courier/service.']);
        }

        $previous = $orderDetails['shipping'] ?? null;
        if ($previous) {
            $orderDetails['previous_shippings'][] = $previous;
        } else {
            $orderDetails['previous_shippings'] = $orderDetails['previous_shippings'] ?? [];
        }

        $orderDetails['shipping'] = [
            'courier_code'      => $shippingMethod->courier_code,
            'courier_name'      => $shippingMethod->courier_name,
            'service_code'      => $shippingMethod->service_code,
            'service_name'      => $shippingMethod->service_name,
            'description'       => $shippingMethod->description,
            'logo_url'          => $shippingMethod->logo_url,
            'price'             => $pickedRate['price'] ?? 0,
            'collection_method' => is_array($pickedRate['available_collection_method']) && in_array('pickup', $pickedRate['available_collection_method']) ? 'pickup' : 'drop_off',
        ];

        $order->update([
            'order_details' => $orderDetails,
        ]);

        return back()->with('success', 'Courier updated successfully.');
    }

    public function createOrderBiteship(OrderUpdateStatusRequest $request, Order $order, BiteshipService $biteship)
    {
        $this->authorize('update', $order);

        $order->load(['shop', 'user']);
        $oldStatus = $order['status'];
        $newStatus = $request['status'];

        if (! $this->isValidStatusTransition($oldStatus, $newStatus)) {
            return back()->withErrors(['status' => 'Invalid status transition from ' . $oldStatus . ' to ' . $newStatus]);
        }

        if ($order['status'] === 'confirmed' && $newStatus === 'processing') {
            if (($request['collection_method'] !== null && ! in_array($request['collection_method'], ['drop_off', 'pickup']))) {
                $byteshipOrder = $this->handleCreateByteship($order, $biteship, $request['collection_method'] ?? null);

                if ($byteshipOrder['success'] === true) {
                    $order['status'] = $newStatus;
                    $order->save();
                } else {
                    return redirect()->back()->withErrors($byteshipOrder['error']);
                }
            } else {
                $order['shipment_ref_id'] = $request['collection_method'];
                $order['status']          = $newStatus;
                $order->save();
            }
        }

        $this->logStatusChange($order, $oldStatus, $newStatus);

        return redirect()->route('seller.orders.label', $order)
            ->with('success', 'Order created in Biteship. Shipping label ready.');
    }

    private function handleCreateByteship($order, BiteshipService $biteship, $collectionMethod): ?array
    {
        $payload = $this->generateByteshipPayload($order, $collectionMethod);
        $result  = $biteship->createOrder($payload);

        if ($result['success'] === true) {
            $order->update([
                'shipment_ref_id'  => $result['id'] ?? null,
                'tracking_details' => $result['courier'] ?? [],
                'biteship_order'   => $result,
            ]);

        }
        return $result;
    }

    private function generateByteshipPayload($order, $collectionMethod = null): array
    {
        $shop     = $order->shop;
        $address  = $order->order_details['address'];
        $shipping = $order->order_details['shipping'];

        $payload = [
            "shipper_contact_name"      => $shop->name,
            "shipper_contact_phone"     => $shop->phone,
            "shipper_contact_email"     => $shop->user->email ?? null,
            "origin_contact_name"       => $shop->user->name,
            "origin_contact_phone"      => $shop->user->phone,
            "origin_contact_email"      => $shop->user->email,
            "origin_postal_code"        => $shop->postal_code,
            "origin_address"            => $shop->address,

            "destination_contact_name"  => $address['name'],
            "destination_contact_phone" => $address['phone'],
            "destination_contact_email" => $order->user->email ?? null,
            "destination_postal_code"   => $address['postal_code'],
            "destination_address"       => $address['address_line_1'],

            "courier"                   => $shipping['courier_code'],
            "courier_company"           => $shipping['courier_name'],
            "courier_service_code"      => $shipping['service_code'],
            "courier_type"              => $shipping['service_code'],
            "origin_collection_method"  => $collectionMethod === null ? $shipping['collection_method'] : $collectionMethod,

            "delivery_type"             => "now",

            "items"                     => collect($order->order_details['items'])->map(function ($it) {
                return [
                    "name"     => $it['name'],
                    "value"    => (int) $it['price'],
                    "quantity" => (int) $it['quantity'],
                    "weight"   => (int) $it['weight'],
                ];
            })->toArray(),
        ];

        return $payload;
    }

    public function updateStatus(OrderUpdateStatusRequest $request, Order $order)
    {
        $this->authorize('update', $order);
        $oldStatus = $order['status'];
        $newStatus = $request['status'];

        if (! $this->isValidStatusTransition($oldStatus, $newStatus)) {
            return back()->withErrors(['status' => 'Invalid status transition from ' . $oldStatus . ' to ' . $newStatus]);
        }

        $order['status'] = $newStatus;

        if ($newStatus === 'cancelled') {
            $order['cancellation_reason'] = $request['cancellation_reason'] ?? 'Cancelled by seller';
        }

        $order->save();

        $this->logStatusChange($order, $oldStatus, $newStatus);

        $buyer = $order['user'];

        if ($newStatus === 'confirmed' && $buyer) {
            $buyer->notify(new BuyerNotification('order_confirmed', $order));
        } else if ($newStatus === 'processing' && $buyer) {
            $buyer->notify(new BuyerNotification('order_processing', $order));
        } else if ($newStatus === 'cancelled' && $buyer) {
            $buyer->notify(new BuyerNotification('order_cancelled', $order));
        }

        $seller = auth()->user();

        if ($newStatus === 'cancelled' && $buyer) {
            $buyer->notify(new SellerNotification('order_cancelled', $order));
        }

        return back()->with('success', "Receipt has been generated and the order has been processed in Biteship. Current status: " . ucfirst($newStatus));
    }

    public function updateTracking(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $request->validate([
            'shipment_ref_id'                  => 'nullable|string|max:255',
            'tracking_details'                 => 'required|array',
            'tracking_details.courier'         => 'required|string|max:255',
            'tracking_details.tracking_number' => 'required|string|max:255',
            'tracking_details.notes'           => 'nullable|string|max:1000',
        ]);

        $order->update([
            'shipment_ref_id'  => $request->shipment_ref_id,
            'tracking_details' => $request->tracking_details,
        ]);

        return back()->with('success', 'Tracking information updated successfully');
    }

    public function markSettled(Order $order)
    {
        $this->authorize('update', $order);

        if ($order->status !== 'delivered') {
            return back()->withErrors(['settlement' => 'Only delivered orders can be marked as settled']);
        }

        if ($order->has_settlement) {
            return back()->withErrors(['settlement' => 'Order is already marked as settled']);
        }

        $order->update(['has_settlement' => true]);

        return back()->with('success', 'Order marked as settled for payout');
    }

    private function isValidStatusTransition(string $oldStatus, string $newStatus): bool
    {
        $allowedTransitions = [
            'paid'       => ['confirmed', 'cancelled'],
            'confirmed'  => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped'    => ['delivered', 'cancelled'],
            'delivered'  => ['finished', 'refunded'],
            'finished'   => ['refunded'],
            'cancelled'  => [],
            'refunded'   => [],
        ];

        return in_array($newStatus, $allowedTransitions[$oldStatus] ?? []);
    }

    private function logStatusChange(Order $order, string $oldStatus, string $newStatus): void
    {
        Log::info('Order status changed', [
            'order_id'   => $order['id'],
            'invoice'    => $order['invoice'],
            'shop_id'    => $order['shop_id'],
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => Auth::id(),
            'timestamp'  => now(),
        ]);
    }

    public function labelPreview(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['shop', 'user']);
        $currentStatus = $order['status'];

        return view('seller.orders.processing.shipping-label.index', compact('order', 'currentStatus'));
    }

    public function labelPdf(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['shop', 'user']);

        $pages = $this->buildLabelPages($order);

        $d = new DNS1D();
        foreach ($pages as &$page) {
            $pngBase64            = $d->getBarcodePNG($page['airwaybill'], 'C128', 1, 55);
            $page['barcodeImage'] = 'data:image/png;base64,' . $pngBase64;
        }
        unset($page);

        $pdf = SnappyPdf::loadView('seller.orders.processing.shipping-label.shipping-label-a5', compact('pages'))
            ->setPaper('a5')
            ->setOrientation('portrait')
            ->setOption('enable-local-file-access', true);

        $invoice = preg_replace('/[\/\\\\]/', '-', $order['invoice']);

        return $pdf->inline('Shipping-Label-' . $invoice . '.pdf');
    }

    private function buildLabelPages(Order $order): array
    {
        $shopId   = $order['shop_id'];
        $details  = $order['order_details'] ?? [];
        $shipping = $details['shipping'] ?? [];
        $address  = $details['address'] ?? [];
        $tracking = $order['tracking_details'] ?? [];
        $biteship = $order['biteship_order'] ?? [];

        $totalWeight = collect($details['items'] ?? [])->sum(function ($i) {
            return (float) $i['weight'] * (int) $i['quantity'];
        });

        return [[
            'mainLogo'           => config('app.url') . '/assets/imgs/theme/logo.png',
            'invoice'            => $order['invoice'],
            'airwaybill'         => $tracking['waybill_id'] ?? '',
            'courierLogo'        => $shipping['logo_url'] ? config('app.url') . $shipping['logo_url'] : '',
            'courierCompany'     => $shipping['courier_name'] ?? '',
            'courierServiceName' => $shipping['service_name'] ?? '',
            'totalWeight'        => $totalWeight,
            'shippingFee'        => 'Rp.' . number_format($shipping['price'] ?? 0),
            'buyerName'          => $address['name'] ?? $order['user']['name'],
            'buyerAddress'       => $address['address_line_1'] ?? '',
            'buyerPhone'         => $address['phone'] ?? '',
            'buyerAddressDetail' => $address['address_line_2'] ?? '',
            'orderNotes'         => $details['notes'] ?? '',
            'shopName'           => $order['shop']['name'],
            'shopPhone'          => $order['shop']['phone'],
            'items'              => collect($details['items'] ?? [])->map(function ($i) {
                return [
                    'name' => $i['name'],
                    'qty'  => $i['quantity'],
                ];
            })->toArray(),
        ]];
    }
}
