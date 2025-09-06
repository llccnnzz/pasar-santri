@extends('layouts.admin.main')

@section('title', 'Admin Dashboard')

@section('content')
<!--=== Start Status Area ===-->
<div class="status-area">
    <div class="row justify-content-center js-grid">
        <div class="col-xxl-3 col-sm-6">
            <div class="card status-card border-0 rounded-3 mb-24 cursor-move">
                <div class="card-body p-25 text-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon rounded-3">
                                <i data-feather="users"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="d-block mb-1">Total Users</span>
                            <h3 class="fs-25">{{ number_format($statistics['total_users']) }}</h3>
                            <p class="fw-medium fs-13">Total registered users</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card status-card border-0 rounded-3 mb-24 cursor-move">
                <div class="card-body p-25 text-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon rounded-3">
                                <i data-feather="shopping-bag"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="d-block mb-1">Total Shops</span>
                            <h3 class="fs-25">{{ number_format($statistics['total_shops']) }}</h3>
                            <p class="fw-medium fs-13">Active marketplace shops</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card status-card border-0 rounded-3 mb-24 cursor-move">
                <div class="card-body p-25 text-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon rounded-3">
                                <i data-feather="package"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="d-block mb-1">Total Products</span>
                            <h3 class="fs-25">{{ number_format($statistics['total_products']) }}</h3>
                            <p class="fw-medium fs-13">Listed products</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card status-card border-0 rounded-3 mb-24 cursor-move">
                <div class="card-body p-25 text-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon rounded-3">
                                <i data-feather="shopping-cart"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="d-block mb-1">Total Orders</span>
                            <h3 class="fs-25">{{ number_format($statistics['total_orders']) }}</h3>
                            <p class="fw-medium fs-13">All time orders</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Status Area ===-->

<!--=== Start Sales Overview Area ===-->
<div class="sales-overview-area">
    <div class="row justify-content-center">
        <div class="col-xxl-8 js-grid">
            <div class="card rounded-3 border-0 mb-24">
                <div class="card-body p-25">
                    <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                        <h4 class="mb-0">Revenue Overview</h4>

                        <select class="form-select form-control" aria-label="Default select example">
                            <option selected>This Month</option>
                            <option value="1">This Week</option>
                            <option value="2">This Year</option>
                            <option value="3">All Time</option>
                        </select>
                    </div>

                    <div id="revenue_overview"></div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card rounded-3 border-0 revenue-status-card mb-24">
                        <div class="card-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Monthly Analytics</h4>

                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Last 6 Months</option>
                                    <option value="1">This Year</option>
                                    <option value="2">Last Year</option>
                                </select>
                            </div>

                            <div id="monthly_analytics"></div>
                        </div>
                    </div>

                    <div class="card rounded-3 border-0 total-summary-card mb-24">
                        <div class="card-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Revenue Summary</h4>

                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>This Month</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Year</option>
                                </select>
                            </div>

                            <ul class="total-summary ps-0 mb-0 list-unstyled o-sortable">
                                <li class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon">
                                            <i data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="fw-medium mb-2 d-block">Total Revenue</span>
                                        <h5 class="text-dark mb-1">${{ number_format($revenue['total_revenue'], 2) }}</h5>
                                        <span class="fs-12 text-body">All time earnings</span>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon bg-2">
                                            <i data-feather="trending-up"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="fw-medium mb-2 d-block">Monthly Revenue</span>
                                        <h5 class="text-dark mb-1">${{ number_format($revenue['monthly_revenue'], 2) }}</h5>
                                        <span class="fs-12 text-body">This month earnings</span>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon bg-3">
                                            <i data-feather="calendar"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="fw-medium mb-2 d-block">Daily Revenue</span>
                                        <h5 class="text-dark mb-1">${{ number_format($revenue['daily_revenue'], 2) }}</h5>
                                        <span class="fs-12 text-body">Today's earnings</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card rounded-3 border-0 activity-status-card mb-24">
                        <div class="card-body text-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">KYC Status</h4>

                                <a href="{{ route('admin.kyc.index') }}" class="btn btn-primary btn-sm">View All</a>
                            </div>

                            <ul class="list-unstyled ps-0 mb-0 activity-list h-550" data-simplebar>
                                <li class="mb-20">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <i data-feather="clock"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Pending Applications</span>
                                            <h4 class="text-warning mb-1">{{ number_format($statistics['kyc_pending']) }}</h4>
                                            <span class="fs-12">Awaiting review</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-20">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <i data-feather="check-circle"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Approved Applications</span>
                                            <h4 class="text-success mb-1">{{ number_format($statistics['kyc_approved']) }}</h4>
                                            <span class="fs-12">Successfully verified</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-20">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <i data-feather="x-circle"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">Rejected Applications</span>
                                            <h4 class="text-danger mb-1">{{ number_format($statistics['kyc_rejected']) }}</h4>
                                            <span class="fs-12">Verification failed</span>
                                        </div>
                                    </div>
                                </li>
                                @forelse($recentActivity['kyc'] as $kyc)
                                <li class="mb-20">
                                    <a href="{{ route('admin.kyc.show', $kyc->id) }}" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <i data-feather="user"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">{{ $kyc->user->name ?? 'N/A' }}</span>
                                            <p>{{ ucfirst($kyc->application_type) }} KYC Application - {{ ucfirst($kyc->status) }}</p>
                                            <span class="fs-12">{{ $kyc->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                </li>
                                @empty
                                <li class="mb-20">
                                    <div class="text-center text-muted">
                                        <p>No recent KYC applications</p>
                                    </div>
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 js-grid">
            <div class="card rounded-3 border-0 sales-by-locations-card mb-24">
                <div class="card-body text-body p-25">
                    <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                        <h4 class="mb-0">User Types</h4>

                        <select class="form-select form-control" aria-label="Default select example">
                            <option selected>All Users</option>
                            <option value="1">Active Users</option>
                            <option value="2">New Users</option>
                        </select>
                    </div>

                    <div id="user_types_chart" class="mb-15"></div>

                    <ul class="country-progress ps-0 mb-0 list-unstyled o-sortable">
                        <li>
                            <span class="fw-medium mb-2 d-block">Total Users</span>
                            <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Total Users" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar rounded-1 bg-primary" style="width: 100%">
                                    <span class="count position-absolute fw-medium">{{ number_format($statistics['total_users']) }}</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="fw-medium mb-2 d-block">Admins</span>
                            @php
                                $adminPercentage = $statistics['total_users'] > 0 ? round(($statistics['total_admins'] / $statistics['total_users']) * 100) : 0;
                            @endphp
                            <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Customers" aria-valuenow="{{ $adminPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar rounded-1 bg-warning" style="width: {{ $adminPercentage }}%">
                                    <span class="count position-absolute fw-medium">{{ number_format($statistics['total_admins']) }}</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="fw-medium mb-2 d-block">Sellers</span>
                            @php
                                $sellerPercentage = $statistics['total_users'] > 0 ? round(($statistics['total_sellers'] / $statistics['total_users']) * 100) : 0;
                            @endphp
                            <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Sellers" aria-valuenow="{{ $sellerPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar rounded-1 bg-success" style="width: {{ $sellerPercentage }}%">
                                    <span class="count position-absolute fw-medium">{{ number_format($statistics['total_sellers']) }}</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="fw-medium mb-2 d-block">Customers</span>
                            @php
                                $customerPercentage = $statistics['total_users'] > 0 ? round(($statistics['total_customers'] / $statistics['total_users']) * 100) : 0;
                            @endphp
                            <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Customers" aria-valuenow="{{ $customerPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar rounded-1 bg-warning" style="width: {{ $customerPercentage }}%">
                                    <span class="count position-absolute fw-medium">{{ number_format($statistics['total_customers']) }}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card rounded-3 border-0 website-overview-card mb-24">
                <div class="card-body text-body p-25">
                    <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                        <h4 class="mb-0">Growth Overview</h4>

                        <select class="form-select form-control" aria-label="Default select example">
                            <option selected>Last 6 Months</option>
                            <option value="1">This Year</option>
                            <option value="2">All Time</option>
                        </select>
                    </div>

                    <div id="growth_overview"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Sales Overview Area ===-->

<!--=== Start Recent Orders Area ===-->
<div class="card rounded-3 border-0 recent-orders-card mb-24 table-edit-area">
    <div class="card-body text-body p-25">
        <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
            <h4 class="mb-0">Recent Orders</h4>

            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm">View All Orders</a>
        </div>

        <div class="table-wrapper">
            <div class="global-table-area">
                <div class="table-responsive overflow-auto h-540" data-simplebar>
                    <table class="table align-middle table-bordered" >
                        <thead class="text-dark">
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Shop</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-body">
                            @forelse($recentActivity['orders'] as $order)
                            <tr>
                                <td class="fw-medium">#{{ Str::limit($order->id, 8) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle wh-40" src="/admin-assets/assets/images/user/user-1.jpg" alt="user">
                                        <span class="fw-medium fs-15 ms-3">{{ $order->user->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>{{ $order->shop->name ?? 'N/A' }}</td>
                                <td class="fw-medium">${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge
                                        @if($order->status === 'delivered') bg-success-transparent text-success
                                        @elseif($order->status === 'pending') bg-warning-transparent text-warning
                                        @elseif($order->status === 'confirmed') bg-info-transparent text-info
                                        @elseif($order->status === 'processing') bg-primary-transparent text-primary
                                        @elseif($order->status === 'shipped') bg-secondary-transparent text-secondary
                                        @elseif($order->status === 'cancelled') bg-danger-transparent text-danger
                                        @elseif($order->status === 'refunded') bg-dark-transparent text-dark
                                        @else bg-light-transparent text-muted
                                        @endif
                                        fw-normal py-1 px-2 fs-12 rounded-1">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="icon border-0 rounded-circle text-center bg-primary-transparent">
                                        <i data-feather="eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i data-feather="inbox" class="mb-2"></i>
                                        <p>No recent orders found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Recent Orders Area ===-->

<!--=== Start Orders Area ===-->
<div class="order-area">
    <div class="row js-grid">
        <div class="col-xxl-6">
            <div class="card rounded-3 border-0 recent-orders-card mb-24">
                <div class="card-body text-body p-25">
                    <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                        <h4 class="mb-0">Recent Users</h4>
                        <a href="{{ route('admin.sellers.index') }}" class="btn btn-primary btn-sm">View All</a>
                    </div>

                    <div class="global-table-area">
                        <div class="table-responsive overflow-auto h-458" data-simplebar>
                            <table class="table align-middle">
                                <thead class="text-dark">
                                    <tr>
                                        <th scope="col">User</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Joined</th>
                                    </tr>
                                </thead>
                                <tbody class="text-body">
                                    @forelse($recentActivity['users'] as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user">
                                                <div class="ms-3">
                                                    <span class="fw-medium fs-15 text-dark d-block">{{ $user->name }}</span>
                                                    <span class="text-body fs-12">{{ $user->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge
                                                @if($user->hasRole('seller')) bg-primary-transparent text-primary
                                                @elseif($user->hasRole('admin')) bg-danger-transparent text-danger
                                                @else bg-success-transparent text-success
                                                @endif
                                                fw-normal py-1 px-2 fs-12 rounded-1">
                                                {{ $user->roles->first()->name ?? 'Customer' }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <div class="text-muted">
                                                <i data-feather="users" class="mb-2"></i>
                                                <p>No recent users found</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6">
            <div class="card rounded-3 border-0 recent-orders-card mb-24">
                <div class="card-body text-body p-25">
                    <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                        <h4 class="mb-0">Recent Products</h4>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm">View All</a>
                    </div>

                    <div class="global-table-area">
                        <div class="table-responsive overflow-auto h-458" data-simplebar>
                            <table class="table align-middle">
                                <thead class="text-dark">
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-body">
                                    @forelse($recentActivity['products'] as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img class="rounded-3 wh-50" src="{{ $product->defaultImage->getFullUrl() }}" alt="product">
                                                <div class="ms-3">
                                                    <span class="fw-medium fs-15 text-dark d-block">{{ Str::limit($product->name, 25) }}</span>
                                                    <span class="text-body fs-12">{{ $product->shop->name ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-medium">${{ number_format($product->price, 2) }}</td>
                                        <td>
                                            <span class="badge
                                                @if($product->status === 'active') bg-success-transparent text-success
                                                @elseif($product->status === 'inactive') bg-danger-transparent text-danger
                                                @elseif($product->status === 'pending') bg-warning-transparent text-warning
                                                @else bg-secondary-transparent text-secondary
                                                @endif
                                                fw-normal py-1 px-2 fs-12 rounded-1">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <div class="text-muted">
                                                <i data-feather="package" class="mb-2"></i>
                                                <p>No recent products found</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Orders Area ===-->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather Icons
    feather.replace();

    const monthlyData = @json($monthlyAnalytics);

    // Revenue Overview Chart
    const revenueOptions = {
        series: [{
            name: 'Revenue',
            data: monthlyData.map(item => item.revenue)
        }],
        chart: {
            type: 'area',
            height: 350
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            categories: monthlyData.map(item => item.month)
        },
        colors: ['#7c3aed'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 90, 100]
            }
        }
    };

    if (document.querySelector("#revenue_overview")) {
        const revenueChart = new ApexCharts(document.querySelector("#revenue_overview"), revenueOptions);
        revenueChart.render();
    }

    // Monthly Analytics Chart
    const monthlyOptions = {
        series: [{
            name: 'Orders',
            type: 'column',
            data: monthlyData.map(item => item.orders)
        }, {
            name: 'Users',
            type: 'line',
            data: monthlyData.map(item => item.users)
        }],
        chart: {
            height: 350,
            type: 'line'
        },
        stroke: {
            width: [0, 4]
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [1]
        },
        xaxis: {
            categories: monthlyData.map(item => item.month)
        },
        colors: ['#3b82f6', '#ef4444']
    };

    if (document.querySelector("#monthly_analytics")) {
        const monthlyChart = new ApexCharts(document.querySelector("#monthly_analytics"), monthlyOptions);
        monthlyChart.render();
    }

    // User Types Chart
    const userTypesOptions = {
        series: [{{ $statistics['total_sellers'] }}, {{ $statistics['total_customers'] }}],
        chart: {
            type: 'donut',
            height: 250
        },
        labels: ['Sellers', 'Customers'],
        colors: ['#10b981', '#f59e0b'],
        legend: {
            position: 'bottom'
        }
    };

    if (document.querySelector("#user_types_chart")) {
        const userTypesChart = new ApexCharts(document.querySelector("#user_types_chart"), userTypesOptions);
        userTypesChart.render();
    }

    // Growth Overview Chart
    const growthOptions = {
        series: [{
            name: 'Growth',
            data: monthlyData.map(item => item.users)
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: monthlyData.map(item => item.month)
        },
        colors: ['#8b5cf6']
    };

    if (document.querySelector("#growth_overview")) {
        const growthChart = new ApexCharts(document.querySelector("#growth_overview"), growthOptions);
        growthChart.render();
    }
});
</script>
@endpush
