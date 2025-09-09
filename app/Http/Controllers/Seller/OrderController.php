<?php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderUpdateStatusRequest;
use App\Jobs\CreateBiteshipOrderJob;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

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

        $view = $views[$currentStatus] ?? 'seller.orders.show';

        return view($view, compact('order', 'currentStatus'));
    }

    public function createOrderBiteship(OrderUpdateStatusRequest $request, Order $order)
    {
        $this->authorize('update', $order);
        $oldStatus = $order['status'];
        $newStatus = $request['status'];

        if (! $this->isValidStatusTransition($oldStatus, $newStatus)) {
            return back()->withErrors(['status' => 'Invalid status transition from ' . $oldStatus . ' to ' . $newStatus]);
        }

        $order['status'] = $newStatus;

        $order->save();

        CreateBiteshipOrderJob::dispatch($order);

        $this->logStatusChange($order, $oldStatus, $newStatus);

        return back()->with('success', 'Order status updated successfully to ' . ucfirst($newStatus));
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

        if ($newStatus === 'shipped' && $request->filled('tracking_details')) {
            $order['tracking_details'] = $request['tracking_details'];
        }

        $order->save();

        $this->logStatusChange($order, $oldStatus, $newStatus);

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
}
