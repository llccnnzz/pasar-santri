@extends('layouts.admin.main')

@section('title', 'Seller Management')

@section('content')
<!--=== Start Seller Management Area ===-->
<div class="card border-0 rounded-3 mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Seller Management</h2>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
        <div class="card status-card border-0 rounded-3 mb-3">
            <div class="card-body p-20">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="icon rounded-3">
                            <i data-feather="users" class="text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Total Sellers</span>
                        <h4 class="fs-20 mb-0">{{ number_format($statistics['total']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
        <div class="card status-card border-0 rounded-3 mb-3">
            <div class="card-body p-20">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="icon rounded-3">
                            <i data-feather="user-check" class="text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Active Sellers</span>
                        <h4 class="fs-20 mb-0">{{ number_format($statistics['active']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
        <div class="card status-card border-0 rounded-3 mb-3">
            <div class="card-body p-20">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="icon rounded-3">
                            <i data-feather="user-x" class="text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Suspended</span>
                        <h4 class="fs-20 mb-0">{{ number_format($statistics['suspended']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
        <div class="card status-card border-0 rounded-3 mb-3">
            <div class="card-body p-20">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="icon rounded-3">
                            <i data-feather="shopping-bag" class="text-info"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">With Shops</span>
                        <h4 class="fs-20 mb-0">{{ number_format($statistics['with_shops']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 rounded-3 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.sellers.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status Filter</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    <option value="no_shop" {{ request('status') === 'no_shop' ? 'selected' : '' }}>No Shop</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Sort By</label>
                <select name="sort" class="form-select">
                    <option value="">Default</option>
                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                    <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Join Date</option>
                    <option value="products_count" {{ request('sort') === 'products_count' ? 'selected' : '' }}>Products</option>
                    <option value="orders_count" {{ request('sort') === 'orders_count' ? 'selected' : '' }}>Orders</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by name, email, shop name..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i data-feather="search"></i> Filter
                </button>
                <a href="{{ route('admin.sellers.index') }}" class="btn btn-outline-secondary">
                    <i data-feather="refresh-cw"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Sellers Table -->
<div class="card border-0 rounded-3">
    <div class="card-body">
        @if($sellers->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>Seller</th>
                            <th>Shop</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th>Orders</th>
                            <th>Joined Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sellers as $seller)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input seller-checkbox" type="checkbox" value="{{ $seller->id }}">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            @if($seller->avatar)
                                                <img src="{{ $seller->avatar }}" alt="{{ $seller->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <i data-feather="user" class="text-white" style="width: 18px; height: 18px;"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $seller->name }}</h6>
                                        <small class="text-muted">{{ $seller->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($seller->shop)
                                    <div>
                                        <h6 class="mb-0">{{ $seller->shop->name }}</h6>
                                        <small class="text-muted">{{ $seller->shop->slug }}</small>
                                        @if($seller->shop->is_suspended)
                                            <div>
                                                <span class="badge bg-danger mt-1">Suspended</span>
                                            </div>
                                        @endif
                                    </div>
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
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $seller->products_count ?? 0 }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $seller->orders_count ?? 0 }}</span>
                            </td>
                            <td>{{ $seller->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.sellers.show', $seller) }}">
                                                <i data-feather="eye" class="me-2" style="width: 14px; height: 14px;"></i>
                                                View Details
                                            </a>
                                        </li>
                                        @if($seller->shop)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.sellers.shop', $seller) }}">
                                                <i data-feather="shopping-bag" class="me-2" style="width: 14px; height: 14px;"></i>
                                                View Shop
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        @if($seller->shop->is_suspended)
                                        <li>
                                            <button class="dropdown-item text-success" onclick="unsuspendShop('{{ $seller->id }}', '{{ $seller->name }}', '{{ $seller->shop->name }}')">
                                                <i data-feather="user-check" class="me-2" style="width: 14px; height: 14px;"></i>
                                                Unsuspend Shop
                                            </button>
                                        </li>
                                        @else
                                        <li>
                                            <button class="dropdown-item text-warning" onclick="suspendShop('{{ $seller->id }}', '{{ $seller->name }}', '{{ $seller->shop->name }}')">
                                                <i data-feather="user-x" class="me-2" style="width: 14px; height: 14px;"></i>
                                                Suspend Shop
                                            </button>
                                        </li>
                                        @endif
                                        @endif
                                        <li>
                                            <button class="dropdown-item text-{{ $seller->is_active ? 'danger' : 'success' }}" onclick="toggleSellerStatus('{{ $seller->id }}', {{ $seller->is_active ? 'false' : 'true' }}, '{{ $seller->name }}')">
                                                <i data-feather="{{ $seller->is_active ? 'user-x' : 'user-check' }}" class="me-2" style="width: 14px; height: 14px;"></i>
                                                {{ $seller->is_active ? 'Deactivate' : 'Activate' }} Seller
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i data-feather="users" class="mb-3" style="width: 48px; height: 48px;" stroke="1.5"></i>
                                <h5>No Sellers Found</h5>
                                <p class="text-muted">
                                    @if(request()->hasAny(['status', 'search', 'sort']))
                                        No sellers match your current filters.
                                    @else
                                        No sellers have registered yet.
                                    @endif
                                </p>
                                @if(request()->hasAny(['status', 'search', 'sort']))
                                    <a href="{{ route('admin.sellers.index') }}" class="btn btn-outline-primary">Clear Filters</a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($sellers->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted mb-0">
                            Showing {{ $sellers->firstItem() }} to {{ $sellers->lastItem() }} of {{ $sellers->total() }} results
                        </p>
                    </div>
                    <div>
                        {{ $sellers->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i data-feather="users" class="mb-3" style="width: 48px; height: 48px;" stroke="1.5"></i>
                <h5>No Sellers Found</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['status', 'search', 'sort']))
                        No sellers match your current filters.
                    @else
                        No sellers have registered yet.
                    @endif
                </p>
                @if(request()->hasAny(['status', 'search', 'sort']))
                    <a href="{{ route('admin.sellers.index') }}" class="btn btn-outline-primary">Clear Filters</a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Suspend Shop Modal -->
<div class="modal fade" id="suspendModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suspend Shop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="suspendForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i data-feather="alert-triangle" class="me-2"></i>
                        You are about to suspend the shop <strong id="suspendShopName"></strong> owned by <strong id="suspendSellerName"></strong>.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Suspension Reason <span class="text-danger">*</span></label>
                        <textarea name="suspended_reason" class="form-control" rows="3" placeholder="Please provide a detailed reason for the suspension..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="2" placeholder="Any additional notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i data-feather="user-x"></i> Suspend Shop
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Unsuspend Shop Modal -->
<div class="modal fade" id="unsuspendModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unsuspend Shop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="unsuspendForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-success">
                        <i data-feather="check-circle" class="me-2"></i>
                        You are about to unsuspend the shop <strong id="unsuspendShopName"></strong> owned by <strong id="unsuspendSellerName"></strong>.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Any notes about this unsuspension..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i data-feather="user-check"></i> Unsuspend Shop
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toggle Seller Status Modal -->
<div class="modal fade" id="toggleStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="toggleStatusTitle">Toggle Seller Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="toggleStatusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert" id="toggleStatusAlert">
                        <i data-feather="info" class="me-2"></i>
                        You are about to change the status of <strong id="toggleStatusSellerName"></strong>.
                    </div>
                    <input type="hidden" name="is_active" id="toggleStatusValue">
                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Any notes about this status change..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" id="toggleStatusSubmitBtn">
                        <i data-feather="check" id="toggleStatusIcon"></i> <span id="toggleStatusText">Update Status</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--=== End Seller Management Area ===-->
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Feather Icons
    feather.replace();

    // Select All Functionality
    $('#selectAll').change(function() {
        $('.seller-checkbox').prop('checked', this.checked);
        updateSelectedCount();
    });

    $('.seller-checkbox').change(function() {
        updateSelectedCount();

        // Update select all checkbox
        const totalCheckboxes = $('.seller-checkbox').length;
        const checkedCheckboxes = $('.seller-checkbox:checked').length;
        $('#selectAll').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        $('#selectAll').prop('checked', checkedCheckboxes === totalCheckboxes);
    });
});

function updateSelectedCount() {
    const count = $('.seller-checkbox:checked').length;
    $('#selectedCount').text(count);
}

function getSelectedIds() {
    return $('.seller-checkbox:checked').map(function() {
        return $(this).val();
    }).get();
}

function suspendShop(sellerId, sellerName, shopName) {
    $('#suspendSellerName').text(sellerName);
    $('#suspendShopName').text(shopName);
    $('#suspendForm').attr('action', `/admin/sellers/${sellerId}/suspend-shop`);
    feather.replace();
    $('#suspendModal').modal('show');
}

function unsuspendShop(sellerId, sellerName, shopName) {
    $('#unsuspendSellerName').text(sellerName);
    $('#unsuspendShopName').text(shopName);
    $('#unsuspendForm').attr('action', `/admin/sellers/${sellerId}/unsuspend-shop`);
    feather.replace();
    $('#unsuspendModal').modal('show');
}

function toggleSellerStatus(sellerId, status, sellerName) {
    $('#toggleStatusSellerName').text(sellerName);
    $('#toggleStatusValue').val(status);

    const action = status === 'true' ? 'activate' : 'deactivate';
    const alertClass = status === 'true' ? 'alert-success' : 'alert-warning';
    const btnClass = status === 'true' ? 'btn-success' : 'btn-warning';
    const iconName = status === 'true' ? 'user-check' : 'user-x';

    $('#toggleStatusTitle').text(`${status === 'true' ? 'Activate' : 'Deactivate'} Seller`);
    $('#toggleStatusAlert').removeClass('alert-success alert-warning').addClass(alertClass);
    $('#toggleStatusSubmitBtn').removeClass('btn-success btn-warning').addClass(btnClass);
    $('#toggleStatusIcon').attr('data-feather', iconName);
    $('#toggleStatusText').text(status === 'true' ? 'Activate Seller' : 'Deactivate Seller');
    $('#toggleStatusForm').attr('action', `/admin/sellers/${sellerId}/toggle-status`);

    feather.replace();
    $('#toggleStatusModal').modal('show');
}

$(document).ready(function() {
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
