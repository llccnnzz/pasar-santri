@extends('layouts.seller.main')

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
                                <i data-feather="shopping-bag"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="d-block mb-1">Total Sales</span>
                            <h3 class="fs-25">{{ number_format($stats['total_sales']) }}</h3>
                            <p class="fw-medium fs-13">
                                @if($stats['growth_percentage'] >= 0)
                                    Increase by <span class="badge bg-success-transparent text-success mx-1">
                                        <i data-feather="trending-up" class="me-1"></i> {{ $stats['growth_percentage'] }}%
                                    </span> this {{ $dateRange }}
                                @else
                                    Decrease by <span class="badge bg-danger-transparent text-danger mx-1">
                                        <i data-feather="trending-down" class="me-1"></i> {{ abs($stats['growth_percentage']) }}%
                                    </span> this {{ $dateRange }}
                                @endif
                            </p>
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
                                <i data-feather="dollar-sign"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="d-block mb-1">Total Revenue</span>
                            <h3 class="fs-25">Rp{{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                            <p class="fw-medium fs-13">From {{ number_format($stats['total_orders']) }} orders this {{ $dateRange }}</p>
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
                            <h3 class="fs-25">{{ number_format($stats['total_products']) }}</h3>
                            <p class="fw-medium fs-13">
                                <span class="badge bg-success-transparent text-success mx-1">{{ $stats['active_products'] }} Active</span>
                                @if($stats['out_of_stock'] > 0)
                                    <span class="badge bg-warning-transparent text-warning mx-1">{{ $stats['out_of_stock'] }} Out of Stock</span>
                                @endif
                            </p>
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
                            <span class="d-block mb-1">Pending Orders</span>
                            <h3 class="fs-25">{{ number_format($stats['pending_orders']) }}</h3>
                            <p class="fw-medium fs-13">
                                @if($stats['pending_orders'] > 0)
                                    <span class="badge bg-warning-transparent text-warning mx-1">
                                        <i data-feather="clock" class="me-1"></i> Needs attention
                                    </span>
                                @else
                                    <span class="badge bg-success-transparent text-success mx-1">
                                        <i data-feather="check" class="me-1"></i> All caught up
                                    </span>
                                @endif
                            </p>
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
                        <h4 class="mb-0">Sales Overview</h4>

                        <select class="form-select form-control" aria-label="Date range filter" onchange="changeRange(this.value)">
                            <option value="today" {{ $dateRange == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="week" {{ $dateRange == 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ $dateRange == 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="year" {{ $dateRange == 'year' ? 'selected' : '' }}>This Year</option>
                        </select>
                    </div>

                    <div id="sales_overview"></div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card rounded-3 border-0 revenue-status-card mb-24">
                        <div class="card-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Revenue Status</h4>

                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>

                            <div id="revenue_status"></div>
                        </div>
                    </div>

                    <div class="card rounded-3 border-0 total-summary-card mb-24">
                        <div class="card-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Total Summary</h4>

                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>

                            <ul class="total-summary ps-0 mb-0 list-unstyled o-sortable">
                                <li class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon">
                                            <i data-feather="trending-up"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="fw-medium mb-2 d-block">Income</span>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="fs-12">Rp{{ number_format($revenueBreakdown['income'], 0, ',', '.') }}</span>
                                        </div>
                                        <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Income progress" aria-valuenow="{{ $revenueBreakdown['income_percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar rounded-1 bg-success" style="width: {{ $revenueBreakdown['income_percentage'] }}%">
                                                <span class="count position-absolute fw-semibold">{{ $revenueBreakdown['income_percentage'] }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon bg-2">
                                            <i data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="fw-medium mb-2 d-block">Profit</span>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="fs-12">Rp{{ number_format($revenueBreakdown['profit'], 0, ',', '.') }}</span>
                                        </div>
                                        <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Profit progress" aria-valuenow="{{ $revenueBreakdown['profit_percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar rounded-1 bg-primary" style="width: {{ $revenueBreakdown['profit_percentage'] }}%">
                                                <span class="count position-absolute fw-semibold">{{ $revenueBreakdown['profit_percentage'] }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon bg-3">
                                            <i data-feather="minus-circle"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="fw-medium mb-2 d-block">Expenses</span>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="fs-12">Rp{{ number_format($revenueBreakdown['expenses'], 0, ',', '.') }}</span>
                                        </div>
                                        <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="Expenses progress" aria-valuenow="{{ $revenueBreakdown['expenses_percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar rounded-1 bg-warning" style="width: {{ $revenueBreakdown['expenses_percentage'] }}%">
                                                <span class="count position-absolute fw-semibold">{{ $revenueBreakdown['expenses_percentage'] }}%</span>
                                            </div>
                                        </div>
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
                                <h4 class="mb-0">Activity</h4>

                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>

                            <ul class="list-unstyled ps-0 mb-0 activity-list h-550" data-simplebar>
                                @forelse($recentActivity as $activity)
                                <li class="mb-20">
                                    <a href="#" class="d-flex text-decoration-none text-body">
                                        <div class="flex-shrink-0">
                                            <div class="icon">
                                                <i data-feather="{{ $activity['icon'] }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="fw-semibold text-dark d-block mb-1 fs-15">{{ $activity['title'] }}</span>
                                            <p>{{ $activity['description'] }}</p>
                                            <span class="fs-12">{{ $activity['time'] }}</span>
                                        </div>
                                    </a>
                                </li>
                                @empty
                                <li class="text-center py-4">
                                    <div class="icon mb-3">
                                        <i data-feather="inbox" class="text-muted"></i>
                                    </div>
                                    <p class="text-muted">No recent activity</p>
                                </li>
                                @endforelse
                            </ul>
                                            <p>Was added to the group, group name is <span class="text-dark">Overtake</span></p>
                                            <span class="fs-12">14 Hours ago</span>
                                        </div>
                                    </a>
                                </li>
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
                        <h4 class="mb-0">Sales by Locations</h4>

                        <select class="form-select form-control" aria-label="Default select example">
                            <option selected>Today</option>
                            <option value="1">This Week</option>
                            <option value="2">This Month</option>
                            <option value="3">This Year</option>
                        </select>
                    </div>

                    <div id="sales_by_locations" class="mb-15"></div>

                    <ul class="country-progress ps-0 mb-0 list-unstyled o-sortable">
                        @forelse($productsByLocation as $location)
                        <li>
                            <span class="fw-medium mb-2 d-block">{{ $location['city'] }}</span>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fs-12">{{ number_format($location['count']) }} products</span>
                            </div>
                            <div class="progress position-relative overflow-visible rounded-1 cursor-move bg-white1" role="progressbar" aria-label="{{ $location['city'] }} sales" aria-valuenow="{{ $location['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar rounded-1 bg-primary" style="width: {{ $location['percentage'] }}%">
                                    <span class="count position-absolute fw-medium">{{ $location['percentage'] }}%</span>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="text-center py-4">
                            <div class="icon mb-3">
                                <i data-feather="map-pin" class="text-muted"></i>
                            </div>
                            <p class="text-muted">No location data available</p>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="card rounded-3 border-0 website-overview-card mb-24">
                <div class="card-body text-body p-25">
                    <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                        <h4 class="mb-0">Weekly Website Overview</h4>

                        <select class="form-select form-control" aria-label="Default select example">
                            <option selected>Today</option>
                            <option value="1">This Week</option>
                            <option value="2">This Month</option>
                            <option value="3">This Year</option>
                        </select>
                    </div>

                    <div id="website_overview"></div>
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

            <select class="form-select form-control" aria-label="Default select example">
                <option selected>Today</option>
                <option value="1">This Week</option>
                <option value="2">This Month</option>
                <option value="3">This Year</option>
            </select>
        </div>

        <div class="table-wrapper">
            <div class="member">
                <div class="delete">
                    <div class="overplay"></div>
                    <div class="choice-delete">
                        <i class="fas fa-times"></i>
                        <h1>Do you delete?</h1>
                        <button type="button" name="cancel-delete" class="btn">Cancel</button>
                        <button type="button" name="yes-delete" class="btn">Delete</button>
                    </div>
                </div>

                <div class="global-table-area">
                    <div class="table-responsive overflow-auto h-540" data-simplebar> 
                        <table class="table align-middle table-bordered" >
                            <thead class="text-dark">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Items</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Payment</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-body">
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="fw-medium">#{{ $order->invoice }}</td>
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                    <td>{{ count($order->order_details['items'] ?? []) }} item(s)</td>
                                    <td>Rp{{ number_format($order->payment_detail['total_amount'] ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->payments->isNotEmpty())
                                            {{ ucfirst($order->payments->first()->channel) }}
                                        @else
                                            Pending
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-warning-transparent text-warning',
                                                'confirmed' => 'bg-info-transparent text-info',
                                                'processing' => 'bg-primary-transparent text-primary',
                                                'shipped' => 'bg-info-transparent text-info',
                                                'delivered' => 'bg-success-transparent text-success',
                                                'completed' => 'bg-success-transparent text-success',
                                                'cancelled' => 'bg-danger-transparent text-danger',
                                                'refunded' => 'bg-secondary-transparent text-secondary'
                                            ];
                                        @endphp
                                        <span class="badge {{ $statusClasses[$order->status] ?? 'bg-secondary-transparent text-secondary' }} fw-normal py-1 px-2 fs-12 rounded-1">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('seller.orders.show', $order->id) }}" class="icon border-0 rounded-circle text-center bg-primary-transparent">
                                            <i data-feather="eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i data-feather="inbox" class="mb-2"></i>
                                        <p>No orders found</p>
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
<!--=== End Recent Orders Area ===-->

<!--=== Start Orders Area ===-->
<div class="order-area">
    <div class="row js-grid">
        <div class="col-xxl-7">
            <div class="row">
                <div class="col-lg-7">
                    <div class="card rounded-3 border-0 recent-orders-card mb-24 table-edit-area">
                        <div class="card-body text-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Top Selling Products</h4>
    
                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>
    
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-452" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            @forelse($topProducts as $product)
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        @if($product->getFirstMediaUrl('images'))
                                                            <img class="rounded-3 wh-50" src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}">
                                                        @else
                                                            <div class="rounded-3 wh-50 bg-light d-flex align-items-center justify-content-center">
                                                                <i data-feather="package" class="text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <span class="fw-medium fs-15 ms-3">{{ Str::limit($product->name, 30) }}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($product->stock > 0)
                                                        <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1">{{ $product->stock }} In Stock</span>
                                                    @else
                                                        <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1">Out Of Stock</span>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($product->total_sold) }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted">
                                                    <i data-feather="package" class="mb-2"></i>
                                                    <p>No top selling products yet</p>
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

                <div class="col-lg-5">
                    <div class="card rounded-3 border-0 recent-orders-card mb-24 table-edit-area">
                        <div class="card-body text-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Top Customers</h4>
    
                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>
    
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-452" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Purchase</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            @forelse($topCustomers as $customer)
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <div class="rounded-circle wh-50 bg-primary-transparent text-primary d-flex align-items-center justify-content-center">
                                                            <i data-feather="user"></i>
                                                        </div>
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">{{ $customer->name }}</span>
                                                            <span class="text-body fs-12">{{ $customer->order_count }} Order{{ $customer->order_count > 1 ? 's' : '' }}</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Rp{{ number_format($customer->total_spent, 0, ',', '.') }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-4 text-muted">
                                                    <i data-feather="users" class="mb-2"></i>
                                                    <p>No top customers yet</p>
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
    </div>
</div>
<!--=== End Orders Area ===-->
@endsection
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="active-tab-pane" role="tabpanel" aria-labelledby="active-tab" tabindex="0">
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-458" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Delivery Date</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Details</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="completed-tab-pane" role="tabpanel" aria-labelledby="completed-tab" tabindex="0">
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-458" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Delivery Date</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Details</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="cancelled-tab-pane" role="tabpanel" aria-labelledby="cancelled-tab" tabindex="0">
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-458" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Delivery Date</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Details</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <span class="fw-medium fs-15 ms-3">Alex Smith</span>
                                                    </a>
                                                </td>
                                                <td>$199.99</td>
                                                <td>25 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-1.jpg" alt="product-1">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <span class="fw-medium fs-15 ms-3">Luke Ivory</span>
                                                    </a>
                                                </td>
                                                <td>$299.99</td>
                                                <td>26 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-2.jpg" alt="product-2">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <span class="fw-medium fs-15 ms-3">Andy King</span>
                                                    </a>
                                                </td>
                                                <td>$399.99</td>
                                                <td>27 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-3.jpg" alt="product-3">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <span class="fw-medium fs-15 ms-3">Laurie Fox</span>
                                                    </a>
                                                </td>
                                                <td>$400.99</td>
                                                <td>28 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-4.jpg" alt="product-4">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <span class="fw-medium fs-15 ms-3">Ryan Collins</span>
                                                    </a>
                                                </td>
                                                <td>$999.99</td>
                                                <td>29 June 2023</td>
                                                <td class="text-center">
                                                    <img class="rounded-3 wh-50" src="/admin-assets/assets/images/products/product-5.jpg" alt="product-5">
                                                </td>
                                                <td class="text-center">
                                                    <a href="#">
                                                        <i data-feather="chevron-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-7">
            <div class="row">
                <div class="col-lg-7">
                    <div class="card rounded-3 border-0 recent-orders-card mb-24 table-edit-area">
                        <div class="card-body text-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Top Selling Products</h4>
    
                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>
    
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-452" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            @forelse($topProducts as $product)
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        @if($product->getFirstMediaUrl('images'))
                                                            <img class="rounded-3 wh-50" src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}">
                                                        @else
                                                            <div class="rounded-3 wh-50 bg-light d-flex align-items-center justify-content-center">
                                                                <i data-feather="package" class="text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <span class="fw-medium fs-15 ms-3">{{ Str::limit($product->name, 30) }}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($product->stock > 0)
                                                        <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1">{{ $product->stock }} In Stock</span>
                                                    @else
                                                        <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1">Out Of Stock</span>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($product->total_sold) }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted">
                                                    <i data-feather="package" class="mb-2"></i>
                                                    <p>No top selling products yet</p>
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

                <div class="col-lg-5">
                    <div class="card rounded-3 border-0 recent-orders-card mb-24 table-edit-area">
                        <div class="card-body text-body p-25">
                            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
                                <h4 class="mb-0">Top Customers</h4>
    
                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>Today</option>
                                    <option value="1">This Week</option>
                                    <option value="2">This Month</option>
                                    <option value="3">This Year</option>
                                </select>
                            </div>
    
                            <div class="global-table-area">
                                <div class="table-responsive overflow-auto h-452" data-simplebar>
                                    <table class="table align-middle table-bordered" >
                                        <thead class="text-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Purchase</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-body o-sortable">
                                            @forelse($topCustomers as $customer)
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <div class="rounded-circle wh-50 bg-primary-transparent text-primary d-flex align-items-center justify-content-center">
                                                            <i data-feather="user"></i>
                                                        </div>
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">{{ $customer->name }}</span>
                                                            <span class="text-body fs-12">{{ $customer->order_count }} Order{{ $customer->order_count > 1 ? 's' : '' }}</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>Rp{{ number_format($customer->total_spent, 0, ',', '.') }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-4 text-muted">
                                                    <i data-feather="users" class="mb-2"></i>
                                                    <p>No top customers yet</p>
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
    </div>
</div>
<!--=== End Orders Area ===-->
@endsection
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Andy King</span>
                                                            <span class="text-body fs-12">30 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$75,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Laurie Fox</span>
                                                            <span class="text-body fs-12">45 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$85,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Ryan Collins</span>
                                                            <span class="text-body fs-12">60 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$99,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-1.jpg" alt="user-1">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Alex Smith</span>
                                                            <span class="text-body fs-12">35 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$55,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-2.jpg" alt="user-2">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Luke Ivory</span>
                                                            <span class="text-body fs-12">20 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$70,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-3.jpg" alt="user-3">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Andy King</span>
                                                            <span class="text-body fs-12">30 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$75,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-4.jpg" alt="user-4">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Laurie Fox</span>
                                                            <span class="text-body fs-12">45 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$85,093</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center text-decoration-none">
                                                        <img class="rounded-circle wh-50" src="/admin-assets/assets/images/user/user-5.jpg" alt="user-5">
                                                        <div class="ms-3">
                                                            <span class="fw-medium fs-15 text-dark d-block">Ryan Collins</span>
                                                            <span class="text-body fs-12">60 Purchases <i class="fa-solid fa-badge-check text-primary"></i></span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>$99,093</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Orders Area ===-->
@endsection