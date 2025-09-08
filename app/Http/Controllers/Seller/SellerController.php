<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingToggleRequest;
use App\Http\Requests\ShopSettingsUpdateRequest;
use App\Http\Requests\ShopSetupStoreRequest;
use App\Models\KycApplication;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\Shop;
use App\Models\ShopShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboard(Request $request)
    {
        $seller = auth()->user();
        $shop = $seller->shop;

        if (!$shop) {
            return redirect()->route('seller.setup')->with('error', 'Please complete your shop setup first.');
        }

        // Get date range for filtering
        $dateRange = $request->get('range', 'month'); // today, week, month, year
        $startDate = $this->getStartDate($dateRange);
        $endDate = now();

        // Dashboard statistics
        $stats = [
            'total_sales' => $this->getTotalSales($shop, $startDate, $endDate),
            'total_orders' => $this->getTotalOrders($shop, $startDate, $endDate),
            'pending_orders' => $this->getPendingOrders($shop),
            'total_products' => $shop->products()->count(),
            'active_products' => $shop->products()->where('status', 'active')->count(),
            'out_of_stock' => $shop->products()->where('stock', '<=', 0)->count(),
            'total_revenue' => $this->getTotalRevenue($shop, $startDate, $endDate),
            'growth_percentage' => $this->getGrowthPercentage($shop, $dateRange),
        ];

        // Recent orders for the table
        $recentOrders = $shop->orders()
            ->with(['user', 'payments'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Orders by status for charts
        $ordersByStatus = $shop->orders()
            ->selectRaw('status, COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Monthly sales data for charts
        $monthlySales = $this->getMonthlySalesData($shop);

        // Top selling products
        $topProducts = $this->getTopSellingProducts($shop, $startDate, $endDate);

        // Revenue by week for current month
        $weeklyRevenue = $this->getWeeklyRevenueData($shop);

        return view('seller.dashboard', compact(
            'stats', 
            'recentOrders', 
            'ordersByStatus', 
            'monthlySales',
            'topProducts',
            'weeklyRevenue',
            'dateRange'
        ));
    }

    private function getStartDate($range)
    {
        switch ($range) {
            case 'today':
                return now()->startOfDay();
            case 'week':
                return now()->startOfWeek();
            case 'year':
                return now()->startOfYear();
            default: // month
                return now()->startOfMonth();
        }
    }

    private function getTotalSales($shop, $startDate, $endDate)
    {
        return $shop->orders()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completed', 'shipped', 'delivered'])
            ->count();
    }

    private function getTotalOrders($shop, $startDate, $endDate)
    {
        return $shop->orders()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

    private function getPendingOrders($shop)
    {
        return $shop->orders()
            ->whereIn('status', ['pending', 'confirmed', 'processing'])
            ->count();
    }

    private function getTotalRevenue($shop, $startDate, $endDate)
    {
        return $shop->orders()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['completed', 'shipped', 'delivered'])
            ->get()
            ->sum(function ($order) {
                return $order->payment_detail['total_amount'] ?? 0;
            });
    }

    private function getGrowthPercentage($shop, $range)
    {
        $currentStart = $this->getStartDate($range);
        $currentEnd = now();
        
        // Calculate previous period
        $periodLength = $currentEnd->diffInDays($currentStart);
        $previousStart = $currentStart->copy()->subDays($periodLength);
        $previousEnd = $currentStart->copy();

        $currentRevenue = $this->getTotalRevenue($shop, $currentStart, $currentEnd);
        $previousRevenue = $this->getTotalRevenue($shop, $previousStart, $previousEnd);

        if ($previousRevenue == 0) {
            return $currentRevenue > 0 ? 100 : 0;
        }

        return round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100, 1);
    }

    private function getMonthlySalesData($shop)
    {
        $months = [];
        $sales = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            
            $months[] = $date->format('M Y');
            $sales[] = $shop->orders()
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->whereIn('status', ['completed', 'shipped', 'delivered'])
                ->get()
                ->sum(function ($order) {
                    return $order->payment_detail['total_amount'] ?? 0;
                });
        }

        return [
            'months' => $months,
            'sales' => $sales
        ];
    }

    private function getTopSellingProducts($shop, $startDate, $endDate, $limit = 5)
    {
        // This would require analyzing order details to get product sales
        // For now, return the most recent products
        return $shop->products()
            ->with(['defaultImage'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getWeeklyRevenueData($shop)
    {
        $weeks = [];
        $revenue = [];
        
        $startOfMonth = now()->startOfMonth();
        $currentWeek = $startOfMonth->copy();
        
        while ($currentWeek->month == now()->month) {
            $weekEnd = $currentWeek->copy()->endOfWeek();
            if ($weekEnd->month != now()->month) {
                $weekEnd = now()->endOfMonth();
            }
            
            $weeks[] = 'Week ' . (count($weeks) + 1);
            $revenue[] = $shop->orders()
                ->whereBetween('created_at', [$currentWeek, $weekEnd])
                ->whereIn('status', ['completed', 'shipped', 'delivered'])
                ->get()
                ->sum(function ($order) {
                    return $order->payment_detail['total_amount'] ?? 0;
                });
                
            $currentWeek = $weekEnd->copy()->addDay()->startOfWeek();
        }

        return [
            'weeks' => $weeks,
            'revenue' => $revenue
        ];
    }

    // Shipping Method Setup
    public function shippingList(Request $request)
    {
        $shop = $request->user()->shop;

        $shopMethods = ShopShippingMethod::where('shop_id', $shop->id)
            ->with('shippingMethod')
            ->get();

        $activeShopMethodsIds = $shopMethods->where('enabled', true)->pluck('shipping_method_id')->toArray();
        $inactiveShopMethodsIds = $shopMethods->where('enabled', false)->pluck('shipping_method_id')->toArray();

        $query = ShippingMethod::where('active', true)->orderBy('courier_name')
            ->orderBy('service_name');

        if ($request->has('status') && $request->status !== '') {
            $active = $request->status === 'active';
            $query->where('active', $active);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('courier_name', 'like', "%{$search}%")
                    ->orWhere('service_name', 'like', "%{$search}%")
                    ->orWhere('courier_code', 'like', "%{$search}%")
                    ->orWhere('service_code', 'like', "%{$search}%");
            });
        }

        $allMethods = $query->get();

        // Add pivot information to each method
        $allMethods->each(function ($method) use ($shopMethods) {
            $shopMethod = $shopMethods->firstWhere('shipping_method_id', $method->id);
            $method->pivot = $shopMethod ? [
                'enabled' => $shopMethod->enabled,
                'id' => $shopMethod->id
            ] : null;
        });

        // Group by courier_code
        $groupedMethods = $allMethods->groupBy('courier_code')->map(function ($methods, $courierCode) use ($activeShopMethodsIds) {
            $firstMethod = $methods->first();
            $enabledCount = $methods->whereIn('id', $activeShopMethodsIds)->count();
            $disabledCount = $methods->where(function($method) use ($activeShopMethodsIds) {
                return $method->pivot && !in_array($method->id, $activeShopMethodsIds);
            })->count();
            $notUsedCount = $methods->where('pivot', null)->count();
            
            return [
                'courier_code' => $courierCode,
                'courier_name' => $firstMethod->courier_name,
                'logo_url' => $firstMethod->logo_url,
                'total_services' => $methods->count(),
                'enabled_services' => $enabledCount,
                'disabled_services' => $disabledCount,
                'not_used_services' => $notUsedCount,
                'all_enabled' => $enabledCount > 0 && $notUsedCount == 0 && $disabledCount == 0,
                'all_inactive' => $enabledCount == 0,
                'methods' => $methods->values() // Ensure it's a proper array for JSON
            ];
        });

        $enabledMethods = $shopMethods->where('enabled', true)->pluck('shipping_method_id')->toArray();
        $disabledMethods = $shopMethods->where('enabled', false)->pluck('shipping_method_id')->toArray();
        $inactiveGlobal = $allMethods->whereNotIn('id', $shopMethods->pluck('shipping_method_id'));

        return view('seller.shipping.index', [
            'enabledMethods' => $allMethods->whereIn('id', $enabledMethods),
            'disabledMethods' => $allMethods->whereIn('id', $disabledMethods),
            'inactiveGlobal' => $inactiveGlobal,
            'groupedMethods' => $groupedMethods,
            'activeShopMethodsIds' => $activeShopMethodsIds,
            'inactiveShopMethodsIds' => $inactiveShopMethodsIds,
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

    public function shippingBulkToggle(Request $request)
    {
        $shop = $request->user()->shop;
        $courierCode = $request->input('courier_code');
        $enabled = $request->input('enabled');

        // Get all shipping methods for this courier
        $shippingMethods = ShippingMethod::where('courier_code', $courierCode)
            ->where('active', true)
            ->get();

        $updatedCount = 0;
        $createdCount = 0;

        foreach ($shippingMethods as $method) {
            $record = ShopShippingMethod::firstOrCreate(
                [
                    'shop_id' => $shop->id,
                    'shipping_method_id' => $method->id,
                ],
                [
                    'enabled' => $enabled,
                ]
            );

            if ($record->wasRecentlyCreated) {
                $createdCount++;
            } else {
                $record->update(['enabled' => $enabled]);
                $updatedCount++;
            }
        }

        $message = $enabled 
            ? "All {$shippingMethods->first()->courier_name} shipping methods enabled" 
            : "All {$shippingMethods->first()->courier_name} shipping methods disabled";

        return response()->json([
            'success' => true,
            'message' => $message,
            'updated_count' => $updatedCount,
            'created_count' => $createdCount,
        ]);
    }

    public function shippingDestroy(Request $request, $shippingId)
    {
        $shop = $request->user()->shop;
        
        $record = ShopShippingMethod::where('shop_id', $shop->id)
            ->where('shipping_method_id', $shippingId)
            ->first();

        if ($record) {
            $record->delete();
            return response()->json([
                'success' => true,
                'message' => 'Shipping method removed from your shop',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Shipping method not found',
        ], 404);
    }

    // Shop Setup
    public function shopSetup()
    {
        $user = auth()->user();

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
        $user = auth()->user();

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

        $user->assignRole('seller');

        return redirect()->route('seller.shop.settings')->with('success', 'Your shop has been created successfully! You can now configure additional settings.');
    }

    // Shop Settings
    public function shopSettings()
    {
        $shop = auth()->user()->shop;

        return view('seller.shop.settings', compact('shop'));
    }

    public function shopSettingsUpdate(ShopSettingsUpdateRequest $request)
    {
        $shop = auth()->user()->shop;

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
                }
            }
        }

        $validated['social_links'] = json_encode($socialLinks);

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
        $shop = auth()->user()->shop;
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
