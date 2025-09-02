<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingToggleRequest;
use App\Http\Requests\ShopSettingsUpdateRequest;
use App\Http\Requests\ShopSetupStoreRequest;
use App\Models\KycApplication;
use App\Models\ShippingMethod;
use App\Models\Shop;
use App\Models\ShopShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function dashboard(Request $request)
    {
        $seller = Auth::user();
        $shop = $seller->shop;

        // Dashboard statistics
        $stats = [
            'total_products' => $shop ? $shop->products()->count() : 0,
            'total_orders' => 0,
            'pending_orders' => 0,
            'total_earnings' => 0,
        ];

        return view('seller.dashboard', compact('stats'));
    }

    // Shipping Method Setup
    public function shippingList(Request $request)
    {
        $shop = $request->user()->shop;

        $allMethods = ShippingMethod::where('active', true)->get();

        $shopMethods = ShopShippingMethod::where('shop_id', $shop->id)
            ->with('shippingMethod')
            ->get();

        $enabledMethods = $shopMethods->where('enabled', true)->pluck('shipping_method_id')->toArray();
        $disabledMethods = $shopMethods->where('enabled', false)->pluck('shipping_method_id')->toArray();

        $inactiveGlobal = $allMethods->whereNotIn('id', $shopMethods->pluck('shipping_method_id'));

        return view('seller.shipping.index', [
            'enabledMethods' => $allMethods->whereIn('id', $enabledMethods),
            'disabledMethods' => $allMethods->whereIn('id', $disabledMethods),
            'inactiveGlobal' => $inactiveGlobal,
        ]);
    }

    public function shippingToggle(ShippingToggleRequest $request)
    {
        $shop = $request->user()->shop;
        $methodId = $request->input('shipping_method_id');
        $enabled = $request->input('enabled');

        $record = ShopShippingMethod::firstOrCreate(
            [
                'shop_id' => $shop->id,
                'shipping_method_id' => $methodId,
            ],
            [
                'enabled' => $enabled,
            ]
        );

        if ($record->exists) {
            $record->update(['enabled' => $enabled]);
        }

        return response()->json([
            'success' => true,
            'message' => $enabled ? 'Shipping method enabled' : 'Shipping method disabled',
        ]);
    }

    public function shippingDestroy(Request $request, $shipping)
    {
        $shop = $request->user()->shop;

        ShopShippingMethod::where('shop_id', $shop->id)
            ->where('shipping_method_id', $shipping)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Shipping method removed from your list',
        ]);
    }

    // Shop Setup
    public function shopSetup()
    {
        $user = Auth::user();

        // If user already has a shop, redirect to settings
        if ($user->shop) {
            return redirect()->route('seller.shop.settings');
        }

        // Check if user has approved KYC
        $approvedKyc = KycApplication::where('user_id', $user['id'])
            ->where('status', 'approved')
            ->exists();

        if (!$approvedKyc) {
            return redirect()->route('kyc.index')
                ->with('error', 'You must complete and get your KYC verification approved before setting up your shop.');
        }

        return view('seller.shop.setup');
    }

    public function shopSetupStore(ShopSetupStoreRequest $request)
    {
        $user = Auth::user();

        // If user already has a shop, redirect to settings
        if ($user->shop) {
            return redirect()->route('seller.shop.settings');
        }

        // Check if user has approved KYC
        $approvedKyc = KycApplication::where('user_id', $user['id'])
            ->where('status', 'approved')
            ->exists();

        if (!$approvedKyc) {
            return redirect()->route('kyc.index')
                ->with('error', 'You must complete and get your KYC verification approved before setting up your shop.');
        }

        $validated = $request->validated();
        $validated['user_id'] = $user['id'];
        $validated['is_open'] = true;

        // Create the shop
        $shop = Shop::create($validated);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $shop->addMediaFromRequest('logo')
                ->toMediaCollection('logo');
        }

        return redirect()->route('seller.shop.settings')->with('success', 'Your shop has been created successfully! You can now configure additional settings.');
    }

    // Shop Settings
    public function shopSettings()
    {
        $shop = Auth::user()->shop;

        return view('seller.shop.settings', compact('shop'));
    }

    public function shopSettingsUpdate(ShopSettingsUpdateRequest $request)
    {
        $shop = Auth::user()->shop;

        $validated = $request->validated();

        // Handle social links
        $socialLinks = [];
        if ($request->filled('social_links')) {
            foreach ($request['social_links'] as $platform => $url) {
                if (!empty($url)) {
                    $socialLinks[] = [
                        'name' => ucfirst($platform),
                        'url' => $url,
                        'logo' => '/assets/imgs/theme/icons/social-'.$platform.'.svg'
                    ];
                    $socialLinks[$platform] = $url;
                }
            }
        }

        $validated['social_links'] = $socialLinks;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            $shop->clearMediaCollection('logo');

            // Add new logo
            $shop->addMediaFromRequest('logo')
                ->toMediaCollection('logo');
        }

        // Update shop data
        $shop->update($validated);

        return redirect()->route('seller.shop.settings')->with('success', 'Shop settings updated successfully');
    }

    // Orders Management
    public function ordersList(Request $request)
    {
        $shop = Auth::user()->shop;
        $orders = $shop ? $shop->orders()->with('user', 'items.product')->latest()->paginate(15) : collect();
        return view('seller.orders.index', compact('orders'));
    }

    public function ordersShow(Order $order)
    {
        return view('seller.orders.show', compact('order'));
    }

    public function ordersUpdateStatus(Request $request, Order $order)
    {
        // Implementation for order status update
        return redirect()->route('seller.orders.show', $order)->with('success', 'Order status updated successfully');
    }
}
