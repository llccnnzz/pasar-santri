<?php
namespace App\Http\Controllers;

use App\Http\Requests\BuyerOrderTrackingRequest;
use App\Models\Order;
use App\Services\BiteshipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $orders = Order::with('shop')
            ->forUser(Auth::id())
            ->latest('created_at')
            ->get();

        return response()->json($orders);
    }

    public function show(Order $order)
    {
        if ($order['user_id'] !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load(['shop', 'payments']);

        $latestPayment = $order->payments()->latest()->first();

        return response()->json([
            'id'             => $order['id'],
            'invoice'        => $order['invoice'],
            'status'         => $order['status_label'],
            'status_badge'   => $order['status_badge'],
            'created_at'     => $order['created_at']->format('d M Y H:i'),
            'shop'           => $order->shop ? [
                'id'   => $order->shop['id'],
                'name' => $order->shop['name'],
            ] : null,
            'address'        => $order['order_details']['address'] ?? null,
            'items'          => $order['order_items'],
            'shipping'       => $order['order_details']['shipping'] ?? null,
            'payment'        => $order['payment_detail'],
            'latest_payment' => $latestPayment ? [
                'channel'      => $latestPayment['channel_label'],
                'status'       => $latestPayment['status_label'],
                'total_amount' => (float) $latestPayment['value'],
                'paid_at'      => $latestPayment['paid_at'] ? $latestPayment['paid_at']->format('d M Y H:i') : null,
            ] : null,
        ]);
    }

    public function track(BuyerOrderTrackingRequest $request, BiteshipService $biteship)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('tracking_details->waybill_id', $request->waybill_id)
            ->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found for this Waybill ID',
            ], 404);
        }

        $trackingId = $order->tracking_details['tracking_id'] ?? null;

        if (! $trackingId) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking ID not available for this order',
            ], 400);
        }

        $tracking = $biteship->trackOrder($request->waybill_id, $trackingId);

        if (! $tracking) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve tracking info',
            ], 400);
        }

        return response()->json([
            'success'  => true,
            'tracking' => array_merge($tracking, [
                'order_id' => $order->id,
            ]),
        ]);
    }

    public function finish(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $order->update([
            'status' => 'finished',
        ]);

        return redirect()->back()->with('success', 'Order has been marked as finished.');
    }
}
