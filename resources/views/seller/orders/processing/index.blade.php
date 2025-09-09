@extends('layouts.seller.main')

@section('title', 'Orders - Seller Dashboard')

@section('content')
    <!-- Section title -->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">Orders</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="/seller/dashboard">Seller Dashboard</a>
                </li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Processing</li>
            </ol>
        </nav>
    </div>

    <div class="card rounded-3 border-0 products-card mb-24 table-edit-area">
        <div class="card-body text-body p-25">
            <div
                class="card-title d-sm-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color">
                <h4 class="mb-2 mb-sm-0">Order List (Status: {{ request('status', 'processing') }})</h4>

                <div class="d-sm-flex align-items-center">
                    <form action="{{ route('seller.orders.index') }}" method="GET"
                        class="src-form position-relative z-1 me-sm-3 mb-2 mb-sm-0" style="width: 280px;">
                        <input type="hidden" name="status" value="{{ request('status', 'processing') }}">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control h-40 pe-5"
                            {{-- pe-5 = padding end biar ada ruang untuk icon --}} placeholder="Search invoice or customer">
                        <button type="submit"
                            class="bg-transparent position-absolute top-50 end-0 translate-middle-y border-0 pe-2">
                            <i data-feather="search" style="width: 18px;" class="text-body"></i>
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
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Items</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>

                            <tbody class="text-body o-sortable">
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('seller.orders.show', $order) }}"
                                                class="text-decoration-none fw-medium">#{{ $order->invoice }}</a>
                                        </td>

                                        <td class="text-muted">
                                            {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}</td>

                                        <td>{{ $order->user->name ?? ($order->order_details['address']['name'] ?? '-') }}
                                        </td>

                                        <td>
                                            @php $firstItem = $order->order_items[0] ?? null; @endphp
                                            <div class="d-flex align-items-center">
                                                @if ($firstItem && isset($firstItem['image']))
                                                    <img class="rounded me-2" src="{{ $firstItem['image'] }}" alt="item"
                                                        style="width:40px;height:40px;object-fit:cover;">
                                                @endif
                                                <span>{{ $order->order_items_count }}
                                                    item{{ $order->order_items_count > 1 ? 's' : '' }}</span>
                                            </div>
                                        </td>

                                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>

                                        <td>
                                            <span
                                                class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="bx bx-cart" style="font-size: 48px; color: #ccc;"></i>
                                                <h6 class="mt-2 text-muted">No orders</h6>
                                                <p class="text-muted">No orders match your filters.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mt-25 text-center">
                        <span class="fs-15 fw-medium text-dark mb-10 mb-sm-0 d-block">Showing
                            {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} of
                            {{ $orders->total() }}</span>
                        {{ $orders->withQueryString()->links('layouts.seller.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // init feather icons
            if (window.feather) {
                feather.replace();
            }

            // init bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function(el) {
                return new bootstrap.Tooltip(el)
            })

            // confirm accept
            document.querySelectorAll('.accept-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Accept this order and change status to Processing?')) {
                        e.preventDefault();
                    }
                });
            });

            // reject: prompt for cancellation reason then submit
            document.querySelectorAll('.btn-reject').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var form = this.closest('form');
                    var reason = prompt('Please provide a reason for rejection (optional):');
                    if (reason === null) {
                        // user cancelled prompt
                        return;
                    }
                    form.querySelector('input[name="cancellation_reason"]').value = reason;
                    if (confirm('Are you sure you want to reject this order?')) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
