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
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Confirmed</li>
            </ol>
        </nav>
    </div>

    <div class="card rounded-3 border-0 products-card mb-24 table-edit-area">
        <div class="card-body text-body p-25">
            <div
                class="card-title d-sm-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color">
                <h4 class="mb-2 mb-sm-0">Order List (Status: {{ request('status', 'confirmed') }})</h4>

                <div class="d-sm-flex align-items-center">
                    <form action="{{ route('seller.orders.index') }}" method="GET"
                        class="src-form position-relative z-1 me-sm-3 mb-2 mb-sm-0" style="width: 280px;">
                        <input type="hidden" name="status" value="{{ request('status', 'confirmed') }}">
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
                                    <th scope="col">Courier</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Items</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="text-body o-sortable">
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('seller.orders.show', $order) }}"
                                                class="text-decoration-none fw-medium text-primary">
                                                #{{ $order->invoice }}<br>
                                                {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}
                                            </a>
                                        </td>

                                        <td class="text-muted">
                                            <div>
                                                <div>
                                                    <b>{{ $order['order_details']['shipping']['courier_name'] }}</b>
                                                    ({{ $order['order_details']['shipping']['description'] }})
                                                    <br>
                                                    Rp.
                                                    {{ number_format($order['order_details']['shipping']['price'], 0, '.', ',') }}
                                                </div>

                                                <a href="{{ route('seller.orders.show', $order) }}" class="text-primary"
                                                    data-bs-toggle="tooltip" title="Change">
                                                    Ubah Kurir
                                                </a>
                                            </div>
                                        </td>

                                        <td>{{ $order->user->name ?? '-' }}
                                        </td>

                                        <td>
                                            @php $firstItem = $order->order_items[0] ?? null; @endphp
                                            <div class="d-flex align-items-center">
                                                @if ($firstItem && isset($firstItem['image']))
                                                    <img class="rounded me-2" src="{{ $firstItem['image'] }}"
                                                        alt="item" style="width:40px;height:40px;object-fit:cover;">
                                                @endif
                                                <span>{{ $order->order_items_count }}
                                                    item{{ $order->order_items_count > 1 ? 's' : '' }}</span>
                                            </div>
                                        </td>

                                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>

                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                                        </td>

                                        @php
                                            $collectionMethod = data_get(
                                                $order->order_details,
                                                'shipping.collection_method',
                                            );
                                            $methods = is_array($collectionMethod)
                                                ? $collectionMethod
                                                : [$collectionMethod];
                                        @endphp

                                        <td class="text-center">
                                            {{-- Drop Off --}}
                                            @if (in_array('drop_off', $methods))
                                                <form action="{{ route('seller.orders.create-order', $order) }}"
                                                    method="POST" class="d-inline accept-form me-1">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="processing">
                                                    <input type="hidden" name="collection_method" value="drop_off">
                                                    <button type="submit"
                                                        class="icon border-0 rounded-circle text-center bg-success-transparent"
                                                        data-bs-toggle="tooltip" title="Drop Off">
                                                        <i data-feather="layers"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Pick Up --}}
                                            @if (in_array('pickup', $methods))
                                                <form action="{{ route('seller.orders.create-order', $order) }}"
                                                    method="POST" class="d-inline accept-form me-1">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="processing">
                                                    <input type="hidden" name="collection_method" value="pickup">
                                                    <button type="submit"
                                                        class="icon border-0 rounded-circle text-center bg-success-transparent"
                                                        data-bs-toggle="tooltip" title="Pick Up">
                                                        <i data-feather="archive"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Reject button (open modal) --}}
                                            <button type="button"
                                                class="icon border-0 rounded-circle text-center bg-danger-transparent"
                                                data-bs-toggle="modal" data-bs-target="#rejectModal" title="Reject">
                                                <i data-feather="x"></i>
                                            </button>

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal" tabindex="-1"
                                                aria-labelledby="rejectModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('seller.orders.update-status', $order) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="cancelled">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="rejectModalLabel">Reject Order
                                                                    #{{ $order->invoice }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="cancellation_reason"
                                                                        class="form-label">Reason for Rejection</label>
                                                                    <textarea name="cancellation_reason" id="cancellation_reason" class="form-control w-100" rows="4"
                                                                        placeholder="Enter reason (optional)"></textarea>
                                                                    <small class="text-muted">If left empty, the default
                                                                        reason will be "Cancelled by seller".</small>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i data-feather="x"></i> Reject Order
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
