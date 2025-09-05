<?php

namespace App\Traits;

use App\Models\GlobalVariable;
use App\Models\Product;

trait CartTrait
{
    function handleCartData($cart, $redirectBack = false) {
        $cartItems  = json_decode($cart->items, true);
        $productIds = collect($cartItems)->pluck('id')->toArray();

        // Get current product data with fresh prices and stock
        $products = Product::whereIn('id', $productIds)
            ->with(['defaultImage', 'shop'])
            ->get()
            ->keyBy('id');

        $subTotal         = 0;
        $itemCount        = 0;
        $updatedCartItems = [];

        foreach ($cartItems as $item) {
            $product = $products->get($item['id']);

            if (! $product) {
                // Product no longer exists, skip it
                if ($redirectBack) {
                    return redirect()->back()->withErrors('Some products in your cart are no longer available and have been removed.');
                } else {
                    continue;
                }
            }

            $isAvailable       = true;
            $message           = null;
            $availableQuantity = $item['quantity'];

            // Check stock availability
            if ($product->stock <= 0) {
                $isAvailable       = false;
                $message           = 'Out of Stock';
                $availableQuantity = 0;
            } elseif ($product->stock < $item['quantity']) {
                $message           = "Only {$product->stock} available";
                $availableQuantity = $product->stock;
            }

            // Use current product price (in case price changed)
            $currentPrice = $product->final_price;
            $itemTotal    = $currentPrice * $availableQuantity;

            $updatedCartItems[] = [
                'id'                 => $item['id'],
                'quantity'           => $item['quantity'],
                'available_quantity' => $availableQuantity,
                'price'              => $currentPrice,
                'original_price'     => $product->price,
                'name'               => $product->name,
                'description'        => $product->meta_description,
                'weight'             => $product->weight,
                'slug'               => $product->slug,
                'image'              => $product->defaultImage ? $product->defaultImage->getFullUrl() : null,
                'is_available'       => $isAvailable,
                'message'            => $message,
                'item_total'         => $itemTotal,
                'shop_id'            => $product->shop->id,
                'shop_name'          => $product->shop->name ?? 'Unknown Shop',
                'stock'              => $product->stock,
            ];

            if ($isAvailable) {
                $subTotal += $itemTotal;
                $itemCount += $availableQuantity;
            }
        }

        // Update cart with current data
        $cart->update(['items' => json_encode($updatedCartItems)]);

        $paymentFeeConfig = GlobalVariable::where('key','iLike', 'payment_fee%')->get()->mapWithKeys(function ($item) {;
            return [
                str_replace('payment_fee_', '', $item['key']) => ($item['type'] === 'float' ? (float) $item['value'] : $item['value'])
            ];
        })->toArray();

        // Calculate payment fee
        if ($paymentFeeConfig['type'] === 'percent') {
            $paymentFee = $subTotal * ($paymentFeeConfig['percent'] / 100);
            if ($paymentFee < $paymentFeeConfig['percent_min_value']) {
                $paymentFee = $paymentFeeConfig['percent_min_value'];
            }
        } else {
            $paymentFee = $paymentFeeConfig['fixed'];
        }

        // Calculate total
        $total = $subTotal + $paymentFee;

        // Count out of stock items
        $outOfStockItems = collect($updatedCartItems)->where('is_available', false)->count();

        return [
            'cartItems'        => $updatedCartItems,
            'subTotal'         => $subTotal,
            'paymentFee'       => $paymentFee,
            'total'            => $total,
            'itemCount'        => $itemCount,
            'outOfStockItems'  => $outOfStockItems,
            'paymentFeeConfig' => $paymentFeeConfig,
        ];
    }
}
