<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of orders for the authenticated seller's shop.
     */
    public function index(Request $request)
    {
        $shop = auth()->user()->shop;

        $query = Order::with(['user', 'payments'])
            ->where('shop_id', $shop->id);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range if provided
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search by invoice or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(15);

        // Get statistics for the shop
        $stats = [
            'total' => Order::where('shop_id', $shop->id)->count(),
            'pending' => Order::where('shop_id', $shop->id)->pending()->count(),
            'confirmed' => Order::where('shop_id', $shop->id)->confirmed()->count(),
            'processing' => Order::where('shop_id', $shop->id)->processing()->count(),
            'shipped' => Order::where('shop_id', $shop->id)->shipped()->count(),
            'delivered' => Order::where('shop_id', $shop->id)->delivered()->count(),
            'cancelled' => Order::where('shop_id', $shop->id)->cancelled()->count(),
            'refunded' => Order::where('shop_id', $shop->id)->refunded()->count(),
        ];

        return view('seller.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure the order belongs to the authenticated seller's shop
        $this->authorize('view', $order);

        $order->load(['user', 'shop', 'payments']);

        return view('seller.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $request->validate([
            'status' => [
                'required',
                Rule::in(['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'])
            ],
            'cancellation_reason' => 'required_if:status,cancelled|nullable|string|max:1000',
            'tracking_details' => 'nullable|array',
            'tracking_details.courier' => 'nullable|string|max:255',
            'tracking_details.tracking_number' => 'nullable|string|max:255',
            'tracking_details.notes' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Business logic for status transitions
        if (!$this->isValidStatusTransition($oldStatus, $newStatus)) {
            return back()->withErrors(['status' => 'Invalid status transition from ' . $oldStatus . ' to ' . $newStatus]);
        }

        // Update order status
        $order->status = $newStatus;

        // Handle cancellation
        if ($newStatus === 'cancelled') {
            $order->cancellation_reason = $request->cancellation_reason;
        }

        // Handle shipping details
        if ($newStatus === 'shipped' && $request->filled('tracking_details')) {
            $order->tracking_details = $request->tracking_details;
        }

        $order->save();

        // Log status change
        $this->logStatusChange($order, $oldStatus, $newStatus);

        return back()->with('success', 'Order status updated successfully to ' . ucfirst($newStatus));
    }

    /**
     * Update shipment tracking information.
     */
    public function updateTracking(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $request->validate([
            'shipment_ref_id' => 'nullable|string|max:255',
            'tracking_details' => 'required|array',
            'tracking_details.courier' => 'required|string|max:255',
            'tracking_details.tracking_number' => 'required|string|max:255',
            'tracking_details.notes' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'shipment_ref_id' => $request->shipment_ref_id,
            'tracking_details' => $request->tracking_details,
        ]);

        return back()->with('success', 'Tracking information updated successfully');
    }

    /**
     * Mark order as settled for payout.
     */
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

    /**
     * Export orders to CSV.
     */
    public function export(Request $request)
    {
        $shop = auth()->user()->shop;

        $query = Order::with(['user', 'payments'])
            ->where('shop_id', $shop->id);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->latest()->get();

        $filename = 'orders_' . $shop->slug . '_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($orders) {
            $file = fopen('php://output', 'w');

            // CSV header
            fputcsv($file, [
                'Invoice',
                'Customer Name',
                'Customer Email',
                'Status',
                'Order Total',
                'Payment Status',
                'Created Date',
                'Updated Date'
            ]);

            // CSV data
            foreach ($orders as $order) {
                $orderDetails = $order->order_details;
                $paymentDetail = $order->payment_detail;
                $successfulPayment = $order->payments()->success()->first();

                fputcsv($file, [
                    $order->invoice,
                    $order->user->name,
                    $order->user->email,
                    ucfirst($order->status),
                    $paymentDetail['total_amount'] ?? 'N/A',
                    $successfulPayment ? 'Paid' : 'Unpaid',
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    /**
     * Check if status transition is valid.
     */
    private function isValidStatusTransition(string $oldStatus, string $newStatus): bool
    {
        // Define allowed transitions
        $allowedTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped' => ['delivered', 'cancelled'],
            'delivered' => ['refunded'], // Can only refund delivered orders
            'cancelled' => [], // Cannot transition from cancelled
            'refunded' => [], // Cannot transition from refunded
        ];

        return in_array($newStatus, $allowedTransitions[$oldStatus] ?? []);
    }

    /**
     * Log status change for audit trail.
     */
    private function logStatusChange(Order $order, string $oldStatus, string $newStatus): void
    {
        // You can implement logging to a separate table or use Laravel's built-in logging
        \Log::info('Order status changed', [
            'order_id' => $order->id,
            'invoice' => $order->invoice,
            'shop_id' => $order->shop_id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => Auth::id(),
            'timestamp' => now(),
        ]);
    }
}
