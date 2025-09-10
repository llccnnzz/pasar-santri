@extends('layouts.admin.main')

@section('title', 'Orders Management')

@section('content')
    <div class="card border-0 rounded-3 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Orders Management</h2>
        </div>
    </div>

    <div class="card border-0 rounded-3">
        <div class="card-body text-body p-25">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i data-feather="check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i data-feather="alert-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div
                class="card-title d-sm-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color">
                <h4 class="mb-2 mb-sm-0">Order List</h4>
                <div class="d-flex gap-2">
                    {{-- Search form --}}
                    <form action="{{ route('admin.orders.index') }}" method="GET"
                        class="src-form position-relative z-1 me-sm-3 mb-2 mb-sm-0" style="width: 280px;">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control h-40 pe-5"
                            placeholder="Search invoice">
                        <button type="submit"
                            class="bg-transparent position-absolute top-50 end-0 translate-middle-y border-0 pe-2">
                            <i data-feather="search" style="width: 18px;" class="text-body"></i>
                        </button>
                    </form>

                    {{-- Bulk Paid Bypass --}}
                    <form action="{{ route('admin.orders.bulk-bypass-payment') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm">
                            <i data-feather="check-circle"></i> Mark All Pending as Paid
                        </button>
                    </form>
                </div>
            </div>

            <div class="table-wrapper">
                <div class="global-table-area">
                    <div class="table-responsive overflow-auto">
                        <table class="table align-middle table-bordered">
                            <thead class="text-dark">
                                <tr>
                                    <th scope="col">User ID</th>
                                    <th scope="col">Shop ID</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="text-body o-sortable">
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>
                                            <b>{{ $order['order_details']['address']['name'] ?? '-' }}</b>
                                            <br>
                                            <small>
                                                {{ $order['order_details']['address']['subdistrict'] ?? '-' }} -
                                                {{ $order['order_details']['address']['city'] ?? '-' }} -
                                                {{ $order['order_details']['address']['province'] ?? '-' }}
                                            </small>
                                        </td>

                                        <td>
                                            <b>{{ $order['shop']['name'] ?? '-' }}</b>
                                            <br>
                                            <small>
                                                {{ $order['shop']['subdistrict'] ?? '-' }} -
                                                {{ $order['shop']['city'] ?? '-' }} -
                                                {{ $order['shop']['province'] ?? '-' }}
                                            </small>
                                        </td>
                                        <td>
                                            #{{ $order->invoice }}
                                            <br>
                                            <b>Total: Rp. {{ number_format($order['payment_detail']['total_amount'], 0, ',', '.') }}</b>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $order->status === 'pending' ? 'warning' : 'success' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{-- Accept form: change status to paid --}}
                                            <form
                                                action="{{ route('admin.orders.bypass-payment', ['order' => $order->id, 'status' => 'paid']) }}"
                                                method="POST" class="d-inline accept-form me-1">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="icon border-0 rounded-circle text-center bg-success-transparent"
                                                    data-bs-toggle="tooltip" title="Mark as Paid">
                                                    <i data-feather="check"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-muted">
                                                <i data-feather="inbox" class="mb-2"></i>
                                                <p>No orders found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-sm-flex align-items-center justify-content-between mt-25 text-center">
                        <span class="fs-15 fw-medium text-dark mb-10 mb-sm-0 d-block">Items Per Page Show 10</span>
                        {{ $orders->withQueryString()->links('layouts.seller.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
