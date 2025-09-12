<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Notifications\BuyerNotification;
use App\Notifications\SellerNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('search')) {
            $query->where('invoice', 'LIKE', '%' . $request->search . '%');
        }

        $orders = $query->orderByDesc('created_at')->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function bypassPayment($orderId, $status)
    {
        DB::beginTransaction();

        try {
            $order  = Order::findOrFail($orderId);
            $user   = $order['user'];
            $seller = $order['shop']['user'];

            if ($order->status !== 'pending') {
                return back()->with('error', 'Hanya order dengan status pending yang dapat bayar');
            }

            if (! in_array($status, ['paid'])) {
                return back()->with('error', 'Status tidak valid');
            }

            $order->update(['status' => $status]);

            $user->notify(new BuyerNotification('order_paid', $order));
            $seller->notify(new SellerNotification('order_new', $order));

            OrderPayment::where('order_id', $order->id)
                ->update([
                    'status'     => 'success',
                    'updated_at' => now(),
                    'paid_at'    => now(),
                ]);

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', "Order {$order->invoice} berhasil dibypass ke {$status}");
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function bulkBypassPayments()
    {
        DB::beginTransaction();

        try {
            $pendingOrders = Order::where('status', 'pending')->get();

            foreach ($pendingOrders as $order) {
                $order->update(['status' => 'paid']);

                $user   = $order['user'];
                $seller = $order['shop']['user'];

                $user->notify(new BuyerNotification('order_paid', $order));
                $seller->notify(new SellerNotification('order_new', $order));

                OrderPayment::where('order_id', $order->id)
                    ->update([
                        'status'     => 'success',
                        'updated_at' => now(),
                    ]);
            }

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', count($pendingOrders) . ' pending orders berhasil diubah ke paid');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
