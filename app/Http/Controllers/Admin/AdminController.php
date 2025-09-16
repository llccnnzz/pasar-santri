<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycApplication;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function dashboard()
    {
        // --- Statistics ---
        $statistics = [
            'total_users'     => User::count(),
            'total_admins'   => User::role('admin')->count(),
            'total_sellers'   => User::role('seller')->count(),
            'total_customers' => User::role('customer')->count(),
            'total_shops'     => Shop::count(),
            'total_products'  => Product::count(),
            'total_orders'    => Order::count(),
        ];

        // KYC counts in one query
        $kycCounts = KycApplication::selectRaw("
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
        ")
            ->first();

        $statistics['kyc_pending']  = $kycCounts->pending;
        $statistics['kyc_approved'] = $kycCounts->approved;
        $statistics['kyc_rejected'] = $kycCounts->rejected;

        // --- Revenue (using proper database queries for better performance) ---
        $revenueData = Order::selectRaw("
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as total_revenue,
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                        AND created_at >= ?
                        AND created_at <= ?
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as monthly_revenue,
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                        AND created_at >= ?
                        AND created_at <= ?
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as weekly_revenue,
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                        AND created_at >= ?
                        AND created_at <= ?
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as daily_revenue
            ", [
                now()->startOfMonth(), now()->endOfMonth(), // monthly
                now()->startOfWeek(), now()->endOfWeek(),   // weekly
                now()->startOfDay(), now()->endOfDay()      // daily
            ])
            ->whereNull('deleted_at')
            ->first();

        $revenue = [
            'total_revenue'   => $revenueData->total_revenue ?? 0,
            'monthly_revenue' => $revenueData->monthly_revenue ?? 0,
            'weekly_revenue'  => $revenueData->weekly_revenue ?? 0,
            'daily_revenue'   => $revenueData->daily_revenue ?? 0,
        ];

                // --- Monthly revenue (last 6 months) - using database aggregation ---
        $monthlyRevenue = Order::selectRaw("
                DATE_TRUNC('month', created_at) as month,
                COALESCE(SUM(CASE
                    WHEN status IN ('completed', 'shipped', 'delivered', 'finished')
                    THEN CAST(payment_detail->>'total_amount' AS DECIMAL(15,2))
                    ELSE 0
                END), 0) as total
            ")
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->whereNull('deleted_at')
            ->groupBy(DB::raw("DATE_TRUNC('month', created_at)"))
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Fill in missing months with 0
        $monthlyAnalytics = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->startOfMonth()->format('Y-m-01 00:00:00');
            $monthlyAnalytics[] = $monthlyRevenue[$month] ?? 0;
        }

        // --- Recent Activity ---
        $recentActivity = [
            'users'    => User::latest()->limit(5)->get(),
            'orders'   => Order::with('user')->latest()->limit(5)->get(),
            'kyc'      => KycApplication::with('user')->latest()->limit(5)->get(),
            'products' => Product::with(['shop','defaultImage'])->latest()->limit(5)->get(),
        ];

        // Pending KYC count for layout
        $pendingKycCount = $statistics['kyc_pending'];

        return view('admin.dashboard', compact(
            'statistics',
            'revenue',
            'monthlyAnalytics',
            'recentActivity',
            'pendingKycCount'
        ));
    }

    private function getMonthlyStats()
    {
        $months = [];
        $userGrowth = [];
        $orderGrowth = [];
        $revenueGrowth = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            // Users registered this month
            $usersCount = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $userGrowth[] = $usersCount;

            // Orders this month
            $ordersCount = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $orderGrowth[] = $ordersCount;

            // Revenue this month (simplified - you'll need to implement proper revenue calculation)
            $revenue = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->whereIn('status', ['delivered', 'completed'])
                ->count() * 1000; // Placeholder calculation
            $revenueGrowth[] = $revenue;
        }

        return [
            'months' => $months,
            'userGrowth' => $userGrowth,
            'orderGrowth' => $orderGrowth,
            'revenueGrowth' => $revenueGrowth,
        ];
    }

    private function getRevenueStats()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        return [
            'today_orders' => Order::whereDate('created_at', $today)->count(),
            'this_month_orders' => Order::where('created_at', '>=', $thisMonth)->count(),
            'last_month_orders' => Order::whereBetween('created_at', [
                $lastMonth,
                $lastMonth->copy()->endOfMonth()
            ])->count(),
            'total_revenue' => Order::whereIn('status', ['delivered', 'completed'])->count() * 1000, // Placeholder
        ];
    }

    public function analyticsDashboard()
    {
        // Detailed analytics view
        return view('admin.analytics.dashboard');
    }

    public function salesAnalytics()
    {
        // Sales analytics view
        return view('admin.analytics.sales');
    }

    public function userAnalytics()
    {
        // User analytics view
        return view('admin.analytics.users');
    }

    public function revenueAnalytics()
    {
        // Revenue analytics view
        return view('admin.analytics.revenue');
    }

    public function settings()
    {
        // System settings view
        return view('admin.settings.index');
    }

    public function updateSettings(Request $request)
    {
        // Update system settings
        return back()->with('success', 'Settings updated successfully');
    }

    public function clearCache()
    {
        // Clear application cache
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('view:clear');
        \Artisan::call('route:clear');

        return back()->with('success', 'Cache cleared successfully');
    }
}
