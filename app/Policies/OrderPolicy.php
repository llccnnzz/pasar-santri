<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any orders.
     */
    public function viewAny(User $user): bool
    {
        return $user->shop !== null;
    }

    /**
     * Determine whether the user can view the order.
     */
    public function view(User $user, Order $order): bool
    {
        // User can view order if it belongs to their shop or if they are the customer
        return $user->shop && $user->shop->id === $order->shop_id || $user->id === $order->user_id;
    }

    /**
     * Determine whether the user can create orders.
     */
    public function create(User $user): bool
    {
        // Usually customers create orders, not sellers
        return true;
    }

    /**
     * Determine whether the user can update the order.
     */
    public function update(User $user, Order $order): bool
    {
        // Only the shop owner can update their orders
        return $user->shop && $user->shop->id === $order->shop_id;
    }

    /**
     * Determine whether the user can delete the order.
     */
    public function delete(User $user, Order $order): bool
    {
        // Only shop owner can delete their orders, and only if order is pending or cancelled
        return $user->shop && 
               $user->shop->id === $order->shop_id && 
               in_array($order->status, ['pending', 'cancelled']);
    }

    /**
     * Determine whether the user can restore the order.
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->shop && $user->shop->id === $order->shop_id;
    }

    /**
     * Determine whether the user can permanently delete the order.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $user->shop && $user->shop->id === $order->shop_id;
    }

    /**
     * Determine whether the user can update order status.
     */
    public function updateStatus(User $user, Order $order): bool
    {
        return $user->shop && $user->shop->id === $order->shop_id;
    }

    /**
     * Determine whether the user can manage order payments.
     */
    public function managePayments(User $user, Order $order): bool
    {
        return $user->shop && $user->shop->id === $order->shop_id;
    }

    /**
     * Determine whether the user can mark order as settled.
     */
    public function markSettled(User $user, Order $order): bool
    {
        return $user->shop && 
               $user->shop->id === $order->shop_id && 
               $order->status === 'delivered';
    }

    /**
     * Determine whether the user can export orders.
     */
    public function export(User $user): bool
    {
        return $user->shop !== null;
    }
}
