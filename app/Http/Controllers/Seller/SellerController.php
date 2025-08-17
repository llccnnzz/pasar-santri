<?php
namespace App\Http\Controllers\Seller;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Models\KycApplication;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ShopSetupStoreRequest;
use App\Http\Requests\ShopSettingsUpdateRequest;

class SellerController extends Controller
{
    public function dashboard(Request $request)
    {
        $seller = Auth::user();
        $shop   = $seller->shop;

        // Dashboard statistics
        $stats = [
            'total_products' => $shop ? $shop->products()->count() : 0,
            'total_orders'   => 0,
            'pending_orders' => 0,
            'total_earnings' => 0,
        ];

        return view('seller.dashboard', compact('stats'));
    }

    // Shipping Method Setup
    public function shippingList(Request $request)
    {
        $shop            = Auth::user()->shop;
        $shippingMethods = $shop ? $shop->shippingMethods()->get() : collect();
        return view('seller.shipping.index', compact('shippingMethods'));
    }

    public function shippingCreate()
    {
        return view('seller.shipping.create');
    }

    public function shippingStore(Request $request)
    {
        // Implementation for shipping method creation
        return redirect()->route('seller.shipping.index')->with('success', 'Shipping method created successfully');
    }

    public function shippingEdit($shipping)
    {
        return view('seller.shipping.edit', compact('shipping'));
    }

    public function shippingUpdate(Request $request, $shipping)
    {
        // Implementation for shipping method update
        return redirect()->route('seller.shipping.index')->with('success', 'Shipping method updated successfully');
    }

    public function shippingDestroy($shipping)
    {
        // Implementation for shipping method deletion
        return redirect()->route('seller.shipping.index')->with('success', 'Shipping method deleted successfully');
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
        $approvedKyc = KycApplication::where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();

        if (! $approvedKyc) {
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
        $approvedKyc = KycApplication::where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();

        if (! $approvedKyc) {
            return redirect()->route('kyc.index')
                ->with('error', 'You must complete and get your KYC verification approved before setting up your shop.');
        }

        // Get the validated data directly from $request
        $validated            = $request->validated();
        $validated['user_id'] = $user->id;
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

        // Get the validated data directly from the request
        $validated = $request->validated();

        // Handle social links
        $socialLinks = [];
        if ($request->filled('social_links')) {
            foreach ($request->social_links as $platform => $url) {
                if (! empty($url)) {
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
        $shop   = Auth::user()->shop;
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
