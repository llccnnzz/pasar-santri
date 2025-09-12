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

        // --- Revenue (fetch once, compute in PHP) ---
        $deliveredOrders = Order::delivered()
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->get();

        $revenue = [
            'total_revenue'   => $deliveredOrders->sum('total_amount'),
            'monthly_revenue' => $deliveredOrders->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->sum('total_amount'),
            'weekly_revenue'  => $deliveredOrders->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('total_amount'),
            'daily_revenue'   => $deliveredOrders->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
                ->sum('total_amount'),
        ];

        // --- Monthly Analytics (users, orders, revenue in 6 months) ---
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i));

        // Preload users and orders once
        $users = User::where('created_at', '>=', now()->subMonths(5)->startOfMonth())->get();
        $orders = Order::where('created_at', '>=', now()->subMonths(5)->startOfMonth())->get();

        $monthlyAnalytics = $months->map(function ($month) use ($users, $orders, $deliveredOrders) {
            return [
                'month'   => $month->format('M Y'),
                'users'   => $users->whereBetween('created_at', [$month->startOfMonth(), $month->endOfMonth()])->count(),
                'orders'  => $orders->whereBetween('created_at', [$month->startOfMonth(), $month->endOfMonth()])->count(),
                'revenue' => $deliveredOrders->whereBetween('created_at', [$month->startOfMonth(), $month->endOfMonth()])
                    ->sum('total_amount'),
            ];
        });

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
