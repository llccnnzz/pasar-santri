@extends('layouts.admin.main')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Seller Management</h4>
                        </div>

                        <!-- Statistics Cards -->
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="text-white">{{ $statistics['total'] }}</h5>
                                                    <p class="mb-0">Total Sellers</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <i class="ri-user-line fs-1"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="text-white">{{ $statistics['active'] }}</h5>
                                                    <p class="mb-0">Active Sellers</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <i class="ri-user-check-line fs-1"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="text-white">{{ $statistics['suspended'] }}</h5>
                                                    <p class="mb-0">Suspended Shops</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <i class="ri-user-forbid-line fs-1"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="text-white">{{ $statistics['with_shops'] }}</h5>
                                                    <p class="mb-0">With Shops</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <i class="ri-store-line fs-1"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter and Search -->
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <form method="GET" class="d-flex gap-2">
                                        <input type="text" name="search" class="form-control" placeholder="Search sellers or shops..."
                                               value="{{ request('search') }}">
                                        <select name="status" class="form-select">
                                            <option value="">All Statuses</option>
                                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                            <option value="no_shop" {{ request('status') === 'no_shop' ? 'selected' : '' }}>No Shop</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-search-line"></i> Search
                                        </button>
                                        <a href="{{ route('admin.sellers.index') }}" class="btn btn-secondary">
                                            <i class="ri-refresh-line"></i> Reset
                                        </a>
                                    </form>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.sellers.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                           class="btn btn-outline-secondary btn-sm">
                                            Sort by Name
                                            @if(request('sort') === 'name')
                                                <i class="ri-arrow-{{ request('direction') === 'asc' ? 'up' : 'down' }}-line"></i>
                                            @endif
                                        </a>
                                        <a href="{{ route('admin.sellers.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                           class="btn btn-outline-secondary btn-sm">
                                            Sort by Date
                                            @if(request('sort') === 'created_at')
                                                <i class="ri-arrow-{{ request('direction') === 'asc' ? 'up' : 'down' }}-line"></i>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Sellers Table -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Seller</th>
                                            <th>Shop</th>
                                            <th>Status</th>
                                            <th>Products</th>
                                            <th>Orders</th>
                                            <th>Joined</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sellers as $seller)
                                            @if(!$seller->shop)
                                                @php continue; @endphp
                                            @endif
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                            {{ substr($seller->name, 0, 2) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $seller->name }}</h6>
                                                        <small class="text-muted">{{ $seller->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($seller->shop)
                                                    <div>
                                                        <strong>{{ $seller->shop->name }}</strong>
                                                        @if($seller->shop->is_suspended)
                                                            <span class="badge bg-danger ms-1">Suspended</span>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted">{{ $seller->shop->slug }}</small>
                                                @else
                                                    <span class="text-muted">No shop yet</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($seller->is_active)
                                                    @if($seller->shop && $seller->shop->is_suspended)
                                                        <span class="badge bg-warning">Shop Suspended</span>
                                                    @else
                                                        <span class="badge bg-success">Active</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $seller->products_count }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $seller->orders_count }}</span>
                                            </td>
                                            <td>
                                                <small>{{ $seller->created_at->format('M d, Y') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.sellers.show', $seller) }}"
                                                       class="btn btn-sm btn-outline-primary" title="View Details">
                                                        <i class="ri-eye-line"></i>
                                                    </a>

                                                    @if($seller->shop)
                                                        <a href="{{ route('admin.sellers.shop', $seller) }}"
                                                           class="btn btn-sm btn-outline-info" title="View Shop">
                                                            <i class="ri-store-line"></i>
                                                        </a>

                                                        @if($seller->shop->is_suspended)
                                                            <button type="button"
                                                                    class="btn btn-sm btn-outline-success unsuspend-btn"
                                                                    data-seller-id="{{ $seller->id }}"
                                                                    data-seller-name="{{ $seller->name }}"
                                                                    data-shop-name="{{ $seller->shop->name }}"
                                                                    title="Unsuspend Shop">
                                                                <i class="ri-user-check-line"></i>
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                    class="btn btn-sm btn-outline-warning suspend-btn"
                                                                    data-seller-id="{{ $seller->id }}"
                                                                    data-seller-name="{{ $seller->name }}"
                                                                    data-shop-name="{{ $seller->shop->name }}"
                                                                    title="Suspend Shop">
                                                                <i class="ri-user-forbid-line"></i>
                                                            </button>
                                                        @endif
                                                    @endif

                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-{{ $seller->is_active ? 'danger' : 'success' }} toggle-status-btn"
                                                            data-seller-id="{{ $seller->id }}"
                                                            data-current-status="{{ $seller->is_active ? 'active' : 'inactive' }}"
                                                            title="{{ $seller->is_active ? 'Deactivate' : 'Activate' }} Seller">
                                                        <i class="ri-{{ $seller->is_active ? 'close' : 'check' }}-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="ri-user-line fs-1"></i>
                                                    <p class="mt-2">No sellers found</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($sellers->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $sellers->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Suspend Shop Modal -->
<div class="modal fade" id="suspendModal" tabindex="-1" aria-labelledby="suspendModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suspendModalLabel">Suspend Shop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="suspendForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="ri-alert-line"></i>
                        You are about to suspend the shop <strong id="suspendShopName"></strong> owned by <strong id="suspendSellerName"></strong>.
                    </div>

                    <div class="mb-3">
                        <label for="suspendReason" class="form-label">Suspension Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="suspendReason" name="suspended_reason" rows="4"
                                  placeholder="Please provide a detailed reason for the suspension..." required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ri-user-forbid-line"></i> Suspend Shop
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Unsuspend Shop Modal -->
<div class="modal fade" id="unsuspendModal" tabindex="-1" aria-labelledby="unsuspendModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unsuspendModalLabel">Unsuspend Shop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="ri-information-line"></i>
                    Are you sure you want to unsuspend the shop <strong id="unsuspendShopName"></strong> owned by <strong id="unsuspendSellerName"></strong>?
                </div>
                <p class="text-muted">The shop will be able to resume normal operations after unsuspension.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmUnsuspend">
                    <i class="ri-user-check-line"></i> Unsuspend Shop
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('head')
<style>
.avatar-sm {
    width: 2.5rem;
    height: 2.5rem;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let currentSellerId = null;

    // Suspend shop modal
    $('.suspend-btn').on('click', function() {
        currentSellerId = $(this).data('seller-id');
        $('#suspendSellerName').text($(this).data('seller-name'));
        $('#suspendShopName').text($(this).data('shop-name'));
        $('#suspendReason').val('');
        $('#suspendModal').modal('show');
    });

    // Unsuspend shop modal
    $('.unsuspend-btn').on('click', function() {
        currentSellerId = $(this).data('seller-id');
        $('#unsuspendSellerName').text($(this).data('seller-name'));
        $('#unsuspendShopName').text($(this).data('shop-name'));
        $('#unsuspendModal').modal('show');
    });

    // Handle suspend form submission
    $('#suspendForm').on('submit', function(e) {
        e.preventDefault();

        const reason = $('#suspendReason').val().trim();
        if (!reason) {
            $('#suspendReason').addClass('is-invalid');
            $('.invalid-feedback').text('Suspension reason is required.');
            return;
        }

        $.ajax({
            url: `/admin/sellers/${currentSellerId}/suspend-shop`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                suspended_reason: reason
            },
            beforeSend: function() {
                $('#suspendForm button[type="submit"]').prop('disabled', true);
            },
            success: function(response) {
                $('#suspendModal').modal('hide');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response.message) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while suspending the shop.'
                    });
                }
            },
            complete: function() {
                $('#suspendForm button[type="submit"]').prop('disabled', false);
            }
        });
    });

    // Handle unsuspend confirmation
    $('#confirmUnsuspend').on('click', function() {
        $.ajax({
            url: `/admin/sellers/${currentSellerId}/unsuspend-shop`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $(this).prop('disabled', true);
            },
            success: function(response) {
                $('#unsuspendModal').modal('hide');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response.message) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while unsuspending the shop.'
                    });
                }
            },
            complete: function() {
                $('#confirmUnsuspend').prop('disabled', false);
            }
        });
    });

    // Handle seller status toggle
    $('.toggle-status-btn').on('click', function() {
        const sellerId = $(this).data('seller-id');
        const currentStatus = $(this).data('current-status');
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';

        if (confirm(`Are you sure you want to ${newStatus === 'active' ? 'activate' : 'deactivate'} this seller?`)) {
            $.ajax({
                url: `/admin/sellers/${sellerId}/toggle-status`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while updating seller status.'
                    });
                }
            });
        }
    });

    // Clear validation errors when typing
    $('#suspendReason').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush
