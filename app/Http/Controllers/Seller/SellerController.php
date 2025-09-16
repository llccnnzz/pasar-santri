<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingToggleRequest;
use App\Http\Requests\ShopSettingsUpdateRequest;
use App\Http\Requests\ShopSetupStoreRequest;
use App\Models\KycApplication;
use App\Models\Order;
use App\Models\ShippingMethod;
use App\Models\Shop;
use App\Models\ShopShippingMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

        // Cache key for dashboard data
        $cacheKey = "seller_dashboard_{$shop->id}_{$dateRange}_" . $startDate->format('Y-m-d') . "_" . $endDate->format('Y-m-d');
        $cacheDuration = now()->addMinutes($dateRange === 'today' ? 5 : 30); // 5 min for today, 30 min for others

        // Try to get cached data first
        $dashboardData = Cache::remember($cacheKey, $cacheDuration, function() use ($shop, $startDate, $endDate, $dateRange) {
            $data = [];
            
            try {
                $data['stats'] = $this->getOptimizedStats($shop, $startDate, $endDate, $dateRange);
            } catch (\Exception $e) {
                \Log::warning("Failed to get stats for shop {$shop->id}: " . $e->getMessage());
                $data['stats'] = ['total_sales' => 0, 'total_orders' => 0, 'pending_orders' => 0, 'total_products' => 0, 'active_products' => 0, 'out_of_stock' => 0, 'total_revenue' => 0, 'growth_percentage' => 0];
            }
            
            try {
                $data['ordersByStatus'] = $this->getOrdersByStatus($shop, $startDate);
            } catch (\Exception $e) {
                \Log::warning("Failed to get orders by status for shop {$shop->id}: " . $e->getMessage());
                $data['ordersByStatus'] = [];
            }
            
            try {
                $data['monthlySales'] = $this->getOptimizedMonthlySalesData($shop);
            } catch (\Exception $e) {
                \Log::warning("Failed to get monthly sales for shop {$shop->id}: " . $e->getMessage());
                $data['monthlySales'] = ['months' => [], 'sales' => []];
            }
            
            try {
                $data['weeklyRevenue'] = $this->getOptimizedWeeklyRevenueData($shop);
            } catch (\Exception $e) {
                \Log::warning("Failed to get weekly revenue for shop {$shop->id}: " . $e->getMessage());
                $data['weeklyRevenue'] = ['weeks' => [], 'revenue' => []];
            }
            
            try {
                $data['revenueBreakdown'] = $this->getRevenueBreakdown($shop, $startDate, $endDate);
            } catch (\Exception $e) {
                \Log::warning("Failed to get revenue breakdown for shop {$shop->id}: " . $e->getMessage());
                $data['revenueBreakdown'] = ['income' => 0, 'profit' => 0, 'expenses' => 0, 'income_percentage' => 0, 'profit_percentage' => 0, 'expenses_percentage' => 0];
            }
            
            try {
                $data['topCustomers'] = $this->getTopCustomers($shop, $startDate, $endDate);
            } catch (\Exception $e) {
                \Log::warning("Failed to get top customers for shop {$shop->id}: " . $e->getMessage());
                $data['topCustomers'] = collect([]);
            }
            
            try {
                $data['recentActivity'] = $this->getRecentActivity($shop);
            } catch (\Exception $e) {
                \Log::warning("Failed to get recent activity for shop {$shop->id}: " . $e->getMessage());
                $data['recentActivity'] = collect([]);
            }
            
            return $data;
        });

        // Always get fresh recent orders (not cached as they change frequently)
        try {
            $recentOrders = $shop->orders()
                ->with(['user:id,name,email'])
                ->select(['id', 'user_id', 'invoice', 'status', 'payment_detail', 'order_details', 'created_at'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            \Log::warning("Failed to get recent orders for shop {$shop->id}: " . $e->getMessage());
            $recentOrders = collect([]);
        }

        // Always get fresh top products (not heavily cached)
        try {
            $topProducts = $this->getOptimizedTopSellingProducts($shop, $startDate, $endDate);
        } catch (\Exception $e) {
            \Log::warning("Failed to get top products for shop {$shop->id}: " . $e->getMessage());
            $topProducts = collect([]);
        }

        return view('seller.dashboard', array_merge($dashboardData, [
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
            'dateRange' => $dateRange
        ]));
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

    private function getOptimizedStats($shop, $startDate, $endDate, $range)
    {
        // Use DB facade for more control over the query - PostgreSQL compatible
        $orderStats = DB::table('orders')
            ->selectRaw("
                COUNT(*) as total_orders,
                COUNT(CASE WHEN status IN ('completed', 'shipped', 'delivered', 'finished') THEN 1 END) as total_sales,
                COUNT(CASE WHEN status IN ('pending', 'confirmed', 'processing') THEN 1 END) as pending_orders,
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                        AND created_at BETWEEN ? AND ?
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as total_revenue
            ", [$startDate, $endDate])
            ->where('shop_id', $shop->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNull('deleted_at')
            ->first();

        // Separate optimized query for product statistics
        $productStats = DB::table('products')
            ->selectRaw("
                COUNT(*) as total_products,
                COUNT(CASE WHEN status = 'active' THEN 1 END) as active_products,
                COUNT(CASE WHEN stock <= 0 THEN 1 END) as out_of_stock
            ")
            ->where('shop_id', $shop->id)
            ->whereNull('deleted_at')
            ->first();

        // Get growth percentage with optimized query
        $growthPercentage = $this->getOptimizedGrowthPercentage($shop, $range, $startDate, $endDate);

        return [
            'total_sales' => $orderStats->total_sales ?? 0,
            'total_orders' => $orderStats->total_orders ?? 0,
            'pending_orders' => $orderStats->pending_orders ?? 0,
            'total_products' => $productStats->total_products ?? 0,
            'active_products' => $productStats->active_products ?? 0,
            'out_of_stock' => $productStats->out_of_stock ?? 0,
            'total_revenue' => $orderStats->total_revenue ?? 0,
            'growth_percentage' => $growthPercentage,
        ];
    }

    private function getOrdersByStatus($shop, $startDate)
    {
        return DB::table('orders')
            ->selectRaw('status, COUNT(*) as count')
            ->where('shop_id', $shop->id)
            ->where('created_at', '>=', $startDate)
            ->whereNull('deleted_at')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    private function getOptimizedGrowthPercentage($shop, $range, $currentStart, $currentEnd)
    {
        // Calculate previous period
        $periodLength = $currentEnd->diffInDays($currentStart);
        $previousStart = $currentStart->copy()->subDays($periodLength);
        $previousEnd = $currentStart->copy();

        $revenues = DB::table('orders')
            ->selectRaw("
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                        AND created_at BETWEEN ? AND ?
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as current_revenue,
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                        AND created_at BETWEEN ? AND ?
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as previous_revenue
            ", [$currentStart, $currentEnd, $previousStart, $previousEnd])
            ->where('shop_id', $shop->id)
            ->whereNull('deleted_at')
            ->first();

        $currentRevenue = $revenues->current_revenue ?? 0;
        $previousRevenue = $revenues->previous_revenue ?? 0;

        if ($previousRevenue == 0) {
            return $currentRevenue > 0 ? 100 : 0;
        }

        return round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100, 1);
    }

    private function getOptimizedMonthlySalesData($shop)
    {
        // Single query to get 12 months of data using DB facade for better performance - PostgreSQL compatible
        $startDate = now()->subMonths(11)->startOfMonth();
        $endDate = now()->endOfMonth();

        $monthlyData = DB::table('orders')
            ->selectRaw("
                TO_CHAR(created_at, 'YYYY-MM') as month,
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as revenue
            ")
            ->where('shop_id', $shop->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNull('deleted_at')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        $months = [];
        $sales = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m');

            $months[] = $date->format('M Y');
            $sales[] = (float) ($monthlyData[$monthKey] ?? 0);
        }

        return [
            'months' => $months,
            'sales' => $sales
        ];
    }

    private function getOptimizedTopSellingProducts($shop, $startDate, $endDate, $limit = 5)
    {
        // Get products that exist in completed orders from the JSON order_details column
        // This is a complex query for PostgreSQL JSON operations with proper casting
        try {
            $productSales = DB::select("
                SELECT
                    p.id,
                    p.name,
                    p.slug,
                    p.price,
                    p.stock,
                    p.status,
                    COALESCE(SUM(
                        CASE
                            WHEN o.status IN ('completed', 'shipped', 'delivered', 'finished')
                                AND o.order_details IS NOT NULL 
                            THEN (item->>'quantity')::integer
                            ELSE 0
                        END
                    ), 0) as total_sold
                FROM products p
                LEFT JOIN orders o ON o.shop_id = p.shop_id
                LEFT JOIN LATERAL jsonb_array_elements(o.order_details::jsonb->'items') AS item ON (item->>'id') = p.id::text
                WHERE p.shop_id = ?
                    AND p.deleted_at IS NULL
                    AND (o.created_at BETWEEN ? AND ? OR o.created_at IS NULL)
                    AND (o.deleted_at IS NULL OR o.deleted_at IS NULL)
                GROUP BY p.id, p.name, p.slug, p.price, p.stock, p.status
                ORDER BY total_sold DESC, p.stock DESC
                LIMIT ?
            ", [$shop->id, $startDate, $endDate, $limit]);
        } catch (\Exception $e) {
            // Fallback: get products without sales data if JSON query fails
            \Log::warning("Failed to get top selling products for shop {$shop->id}: " . $e->getMessage());
            $productSales = DB::select("
                SELECT
                    p.id,
                    p.name,
                    p.slug,
                    p.price,
                    p.stock,
                    p.status,
                    0 as total_sold
                FROM products p
                WHERE p.shop_id = ?
                    AND p.deleted_at IS NULL
                    AND p.status = 'active'
                ORDER BY p.stock DESC
                LIMIT ?
            ", [$shop->id, $limit]);
        }

        // Convert to Product models to get media relationships
        return collect($productSales)->map(function($productData) {
            $product = \App\Models\Product::find($productData->id);
            if ($product) {
                $product->total_sold = $productData->total_sold;
                return $product;
            }
            return null;
        })->filter();
    }

    private function getOptimizedWeeklyRevenueData($shop)
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Single optimized query to get weekly data for current month - PostgreSQL compatible
        $weeklyData = DB::table('orders')
            ->selectRaw("
                EXTRACT(WEEK FROM created_at) as week_number,
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as revenue
            ")
            ->where('shop_id', $shop->id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereNull('deleted_at')
            ->groupBy('week_number')
            ->pluck('revenue', 'week_number')
            ->toArray();

        $weeks = [];
        $revenue = [];

        $currentWeek = $startOfMonth->copy();
        $weekCounter = 1;

        while ($currentWeek->month == now()->month && $weekCounter <= 5) { // Limit to max 5 weeks
            $weekEnd = $currentWeek->copy()->endOfWeek();
            if ($weekEnd->month != now()->month) {
                $weekEnd = now()->endOfMonth();
            }

            $weekNumber = $currentWeek->week();
            $weeks[] = 'Week ' . $weekCounter;
            $revenue[] = (float) ($weeklyData[$weekNumber] ?? 0);

            $currentWeek = $weekEnd->copy()->addDay();
            if ($currentWeek->month != now()->month) break;
            $currentWeek = $currentWeek->startOfWeek();
            $weekCounter++;
        }

        return [
            'weeks' => $weeks,
            'revenue' => $revenue
        ];
    }

    /**
     * Clear dashboard cache for the shop
     */
    private function clearDashboardCache($shop)
    {
        $cachePatterns = [
            "seller_dashboard_{$shop->id}_today_*",
            "seller_dashboard_{$shop->id}_week_*",
            "seller_dashboard_{$shop->id}_month_*",
            "seller_dashboard_{$shop->id}_year_*",
        ];

        foreach ($cachePatterns as $pattern) {
            // In a production environment, you might want to use Redis SCAN
            // For now, we'll clear specific keys we know might exist
            $ranges = ['today', 'week', 'month', 'year'];
            foreach ($ranges as $range) {
                $startDate = $this->getStartDate($range);
                $endDate = now();
                $cacheKey = "seller_dashboard_{$shop->id}_{$range}_" . $startDate->format('Y-m-d') . "_" . $endDate->format('Y-m-d');
            }
        }
    }

    /**
     * AJAX endpoint for dashboard data refresh
     */
    public function dashboardData(Request $request)
    {
        $seller = auth()->user();
        $shop = $seller->shop;

        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        $dateRange = $request->get('range', 'month');
        $startDate = $this->getStartDate($dateRange);
        $endDate = now();

        // Get fresh data (bypass cache for AJAX requests to ensure real-time data)
        $stats = $this->getOptimizedStats($shop, $startDate, $endDate, $dateRange);
        $ordersByStatus = $this->getOrdersByStatus($shop, $startDate);

        return response()->json([
            'stats' => $stats,
            'ordersByStatus' => $ordersByStatus,
            'dateRange' => $dateRange
        ]);
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

    private function getRevenueBreakdown($shop, $startDate, $endDate)
    {
        // Get revenue breakdown for different periods with proper JSON casting
        $result = DB::table('orders')
            ->selectRaw("
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as income,
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2)) * 0.85
                    ELSE 0
                END), 0) as profit,
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2)) * 0.15
                    ELSE 0
                END), 0) as expenses
            ")
            ->where('shop_id', $shop->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNull('deleted_at')
            ->first();

        $income = $result->income ?? 0;
        $maxValue = $income ?: 1; // Prevent division by zero

        return [
            'income' => $income,
            'profit' => $result->profit ?? 0,
            'expenses' => $result->expenses ?? 0,
            'income_percentage' => $income > 0 ? round(($income / $maxValue) * 100, 1) : 0,
            'profit_percentage' => $income > 0 ? round((($result->profit ?? 0) / $maxValue) * 100, 1) : 0,
            'expenses_percentage' => $income > 0 ? round((($result->expenses ?? 0) / $maxValue) * 100, 1) : 0,
        ];
    }

    private function getTopCustomers($shop, $startDate, $endDate, $limit = 5)
    {
        return DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->selectRaw("
                users.id,
                users.name,
                users.email,
                COUNT(orders.id) as order_count,
                COALESCE(SUM(CASE
                    WHEN orders.status IN ('completed', 'shipped', 'delivered', 'finished')
                    THEN CAST(orders.payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as total_spent
            ")
            ->where('orders.shop_id', $shop->id)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereNull('orders.deleted_at')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_spent')
            ->limit($limit)
            ->get();
    }

    private function getRecentActivity($shop, $limit = 10)
    {
        // Get recent activities from orders and product updates
        $orderActivities = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select([
                'orders.id',
                'orders.status',
                'orders.created_at',
                'orders.updated_at',
                'orders.invoice',
                'users.name as customer_name',
                DB::raw("'order' as activity_type")
            ])
            ->where('orders.shop_id', $shop->id)
            ->whereNull('orders.deleted_at')
            ->orderBy('orders.updated_at', 'desc')
            ->limit($limit)
            ->get();

        return $orderActivities->map(function ($activity) {
            $timeAgo = Carbon::parse($activity->updated_at)->diffForHumans();

            return [
                'type' => 'order',
                'icon' => 'shopping-cart',
                'title' => $activity->customer_name,
                'description' => "Updated order #{$activity->invoice} status to " . ucfirst($activity->status),
                'time' => $timeAgo,
            ];
        });
    }
}
