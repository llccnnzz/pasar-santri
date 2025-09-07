<?php
namespace App\Http\Controllers;

use App\Models\Order;
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
            ] : null,
        ]);
    }
}
