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
                                                        @if($product->defaultImage)
                                                            <img class="rounded-3 wh-50" src="{{ $product->defaultImage->getFullUrl() }}" alt="{{ $product->name }}">
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
