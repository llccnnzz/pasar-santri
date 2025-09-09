@extends('layouts.seller.main')

@section('title', 'Order ' . $order->invoice . ' - Order Details')

@section('content')
    <div class="container-fluid">
        <!--=== Start Section Title Area ===-->
        <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
            <h4 class="text-dark mb-0">Order Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                    <li class="breadcrumb-item fs-14">
                        <a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Seller Dashboard</a>
                    </li>
                    <li class="breadcrumb-item fs-14">
                        <a class="text-decoration-none" href="{{ route('seller.orders.index') }}">Shipped</a>
                    </li>
                    <li class="breadcrumb-item fs-14 text-primary" aria-current="page">#{{ $order->invoice }}</li>
                </ol>
            </nav>
        </div>
        <!--=== End Section Title Area ===-->

        <!--=== Start Order Details Card ===-->
        <div class="card rounded-3 border-0 order-details-card mb-24">
            <div class="card-body p-25 d-flex flex-column" style="min-height: 70vh;">
                <div
                    class="card-title d-flex justify-content-between align-items-center mb-20 pb-20 border-bottom border-color">
                    <h4 class="mb-0">Invoice #{{ $order->invoice }}</h4>
                    <span class="badge bg-{{ $order->status_badge }} fs-14 py-2 px-3">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="row">
                    <!-- Customer Info -->
                    <div class="col-md-6 mb-4">
                        <h5 class="mb-3">Customer Information</h5>
                        <p><strong>Name:</strong> {{ $order->user->name }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                        <p><strong>Phone:</strong> {{ $order->order_details['address']['phone'] ?? '-' }}</p>
                        <p><strong>Address:</strong><br>
                            {{ $order->order_details['address']['address_line_1'] ?? '' }},
                            {{ $order->order_details['address']['subdistrict'] ?? '' }},
                            {{ $order->order_details['address']['city'] ?? '' }},
                            {{ $order->order_details['address']['province'] ?? '' }},
                            {{ $order->order_details['address']['postal_code'] ?? '' }}
                        </p>
                    </div>

                    <!-- Shipping Info -->
                    <div class="col-md-6 mb-4">
                        <h5 class="mb-3">Shipping Information</h5>
                        @php $shipping = $order->order_details['shipping'] ?? null; @endphp
                        @if ($shipping)
                            <p><strong>Courier:</strong> {{ $shipping['courier_name'] ?? '-' }}</p>
                            <p><strong>Service:</strong> {{ $shipping['service_name'] ?? '-' }}</p>
                            <p><strong>Cost:</strong> Rp {{ number_format($shipping['price'] ?? 0) }}</p>
                        @else
                            <p class="text-muted">No shipping details available</p>
                        @endif
                    </div>
                </div>

                <!-- Tracking Info -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h5 class="mb-3">Tracking Information</h5>
                        <p><strong>Tracking ID:</strong> {{ $order->tracking_details['tracking_id'] ?? '-' }}</p>
                        <p><strong>Waybill ID:</strong> {{ $order->tracking_details['waybill_id'] ?? '-' }}</p>
                        <p><strong>Courier Company:</strong> {{ $order->tracking_details['company'] ?? '-' }}</p>
                        <p><strong>Courier Type:</strong> {{ $order->tracking_details['type'] ?? '-' }}</p>
                        <p>
                            <strong>Tracking Link:</strong>
                            @if (!empty($order->tracking_details['link']))
                                <a href="{{ $order->tracking_details['link'] ?? '' }}" target="_blank"
                                    class="btn icon border-0 rounded-circle text-center bg-success-transparent"
                                    title="Track">
                                    <i data-feather="truck"></i>
                                </a>
                            @endif
                        </p>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <!-- Payment Summary (1/4) -->
                    <div class="col-md-3 mb-4">
                        <h5 class="mb-3">Payment Summary</h5>
                        @php $payment = $order->payment_detail ?? []; @endphp
                        <p><strong>Subtotal:</strong> Rp {{ number_format($payment['subtotal'] ?? 0) }}</p>
                        <p><strong>Shipping:</strong> Rp {{ number_format($payment['shipping_cost'] ?? 0) }}</p>
                        <p><strong>Payment Fee:</strong> Rp {{ number_format($payment['payment_fee'] ?? 0) }}</p>
                        <p><strong>Total:</strong>
                            <span class="fw-bold text-primary">Rp {{ number_format($payment['total_amount'] ?? 0) }}</span>
                        </p>
                    </div>
                    <!-- Order Items (3/4) -->
                    <div class="col-md-9 mb-4">
                        <h5 class="mb-3">Order Items</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->order_details['items'] as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item['image'] ?? '' }}" alt="{{ $item['name'] }}"
                                                        class="rounded me-2" width="40" height="40"
                                                        style="object-fit: cover;">
                                                    <span>{{ $item['name'] }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>Rp {{ number_format($item['price']) }}</td>
                                            <td>Rp {{ number_format($item['item_total']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=== End Order Details Card ===-->
    </div>
@endsection
