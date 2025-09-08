@extends('layouts.admin.main')

@section('title', 'Product Ads Management')

@section('content')
<!--=== Start Product Ads Area ===-->
<div class="card border-0 rounded-3 mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Product Ads Management</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.ads.create', ['category' => $activeTab]) }}" class="btn btn-primary btn-sm">
                <i data-feather="plus"></i> Add New Ad
            </a>
            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#bulkActionModal">
                <i data-feather="layers"></i> Bulk Actions
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    @foreach(App\Models\ProductAd::CATEGORIES as $key => $name)
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
        <div class="card status-card border-0 rounded-3 mb-3">
            <div class="card-body p-20">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="icon rounded-3">
                            @switch($key)
                                @case('flash_sale')
                                    <i data-feather="zap" class="text-danger"></i>
                                    @break
                                @case('hot_promo')
                                    <i data-feather="trending-up" class="text-warning"></i>
                                    @break
                                @case('big_discount')
                                    <i data-feather="percent" class="text-success"></i>
                                    @break
                                @case('new_product')
                                    <i data-feather="star" class="text-info"></i>
                                    @break
                                @case('less_than_10k')
                                    <i data-feather="tag" class="text-secondary"></i>
                                    @break
                            @endswitch
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">{{ $name }}</span>
                        <h4 class="fs-20 mb-0">{{ $statistics[$key]['active'] ?? 0 }}/{{ $statistics[$key]['total'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Category Filter Tabs -->
<div class="card border-0 rounded-3 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.ads.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Category Filter</label>
                <select name="tab" class="form-select" onchange="this.form.submit()">
                    @foreach(App\Models\ProductAd::CATEGORIES as $key => $name)
                        <option value="{{ $key }}" {{ $activeTab === $key ? 'selected' : '' }}>
                            {{ $name }} ({{ $statistics[$key]['total'] ?? 0 }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status Filter</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by product name, SKU..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i data-feather="search"></i> Filter
                </button>
                <a href="{{ route('admin.ads.index', ['tab' => $activeTab]) }}" class="btn btn-outline-secondary">
                    <i data-feather="refresh-cw"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Product Ads Table -->
<div class="card border-0 rounded-3">
    <div class="card-body">
        @if($ads->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            @if($activeTab === 'hot_promo')
                            <th>Sort Order</th>
                            @endif
                            @if($activeTab === 'flash_sale')
                            <th>Valid Until</th>
                            @endif
                            <th>Status</th>
                            <th>Type</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ads as $ad)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input ad-checkbox" type="checkbox" value="{{ $ad->id }}">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        @if($ad->product->media->isNotEmpty())
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <img src="{{ $ad->product->media->first()->getUrl() }}"
                                                     alt="{{ $ad->product->name }}"
                                                     class="rounded-circle"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            </div>
                                        @else
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i data-feather="package" class="text-primary" style="width: 18px; height: 18px;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ Str::limit($ad->product->name, 30) }}</h6>
                                        <small class="text-muted">{{ $ad->product->sku }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $ad->category_name }}</span>
                            </td>
                            <td>
                                @if($ad->product->variants->isNotEmpty())
                                    @php
                                        $variant = $ad->product->variants->first();
                                        $finalPrice = $variant->final_price ?? $variant->price;
                                        $originalPrice = $variant->price;
                                    @endphp
                                    <div>
                                        <strong class="text-primary">Rp{{ number_format($finalPrice, 0, ',', '.') }}</strong>
                                        @if($finalPrice < $originalPrice)
                                            <div>
                                                <small class="text-muted text-decoration-line-through">
                                                    Rp{{ number_format($originalPrice, 0, ',', '.') }}
                                                </small>
                                                <small class="text-success ms-1">
                                                    -{{ round((($originalPrice - $finalPrice) / $originalPrice) * 100) }}%
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">No variants</span>
                                @endif
                            </td>
                            @if($activeTab === 'hot_promo')
                            <td>
                                <span class="badge bg-secondary">{{ $ad->sort_order ?? 0 }}</span>
                            </td>
                            @endif
                            @if($activeTab === 'flash_sale')
                            <td>
                                @if($ad->valid_until)
                                    <span class="badge bg-{{ $ad->is_expired ? 'danger' : 'success' }}">
                                        {{ $ad->valid_until->format('M d, Y H:i') }}
                                    </span>
                                    <div>
                                        <small class="text-muted">
                                            {{ $ad->is_expired ? 'Expired' : $ad->valid_until->diffForHumans() }}
                                        </small>
                                    </div>
                                @else
                                    <span class="text-muted">No expiration</span>
                                @endif
                            </td>
                            @endif
                            <td>
                                <span class="badge bg-{{ $ad->is_active ? 'success' : 'secondary' }}">
                                    {{ $ad->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $ad->submission_type === 'manual' ? 'primary' : 'info' }}">
                                    {{ ucfirst($ad->submission_type) }}
                                </span>
                            </td>
                            <td>{{ $ad->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.ads.show', $ad) }}">
                                                <i data-feather="eye" class="me-2" style="width: 14px; height: 14px;"></i>
                                                View Details
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.ads.edit', $ad) }}">
                                                <i data-feather="edit" class="me-2" style="width: 14px; height: 14px;"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        @if($ad->is_active)
                                        <li>
                                            <button class="dropdown-item text-warning" onclick="toggleAdStatus('{{ $ad->id }}', '{{ $ad->product_id }}', false, '{{ $ad->product->name }}')">
                                                <i data-feather="pause" class="me-2" style="width: 14px; height: 14px;"></i>
                                                Deactivate
                                            </button>
                                        </li>
                                        @else
                                        <li>
                                            <button class="dropdown-item text-success" onclick="toggleAdStatus('{{ $ad->id }}', '{{ $ad->product_id }}', true, '{{ $ad->product->name }}')">
                                                <i data-feather="play" class="me-2" style="width: 14px; height: 14px;"></i>
                                                Activate
                                            </button>
                                        </li>
                                        @endif
                                        <li>
                                            <button class="dropdown-item text-danger" onclick="deleteAd('{{ $ad->id }}', '{{ $ad->product->name }}')">
                                                <i data-feather="trash-2" class="me-2" style="width: 14px; height: 14px;"></i>
                                                Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($ads->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted mb-0">
                            Showing {{ $ads->firstItem() }} to {{ $ads->lastItem() }} of {{ $ads->total() }} results
                        </p>
                    </div>
                    <div>
                        {{ $ads->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i data-feather="inbox" class="mb-3" style="width: 48px; height: 48px;" stroke="1.5"></i>
                <h5>No Product Ads Found</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['status', 'search']))
                        No ads match your current filters.
                    @else
                        No ads found for {{ App\Models\ProductAd::CATEGORIES[$activeTab] }} category.
                    @endif
                </p>
                @if(request()->hasAny(['status', 'search']))
                    <a href="{{ route('admin.ads.index', ['tab' => $activeTab]) }}" class="btn btn-outline-primary">Clear Filters</a>
                @else
                    <a href="{{ route('admin.ads.create', ['category' => $activeTab]) }}" class="btn btn-primary">
                        <i data-feather="plus"></i> Add First Ad
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Auto-suggest section for applicable categories -->
@if(!empty($autoSuggestProducts) && $autoSuggestProducts->isNotEmpty())
<div class="card border-0 rounded-3 mt-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i data-feather="lightbulb" class="text-warning me-2"></i>
            Auto-suggested Products for {{ App\Models\ProductAd::CATEGORIES[$activeTab] }}
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($autoSuggestProducts as $product)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex">
                            @if($product->media->isNotEmpty())
                                <div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                    <img src="{{ $product->media->first()->getUrl() }}"
                                         alt="{{ $product->name }}"
                                         class="rounded"
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                </div>
                            @else
                                <div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                    <i data-feather="package" class="text-primary"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-1">{{ Str::limit($product->name, 40) }}</h6>
                                <small class="text-muted">{{ $product->sku }}</small>
                                @if($product->variants->isNotEmpty())
                                    @php
                                        $variant = $product->variants->first();
                                        $finalPrice = $variant->final_price ?? $variant->price;
                                        $originalPrice = $variant->price;
                                    @endphp
                                    <div class="mt-1">
                                        <strong class="text-primary">Rp{{ number_format($finalPrice, 0, ',', '.') }}</strong>
                                        @if($finalPrice < $originalPrice)
                                            <small class="text-success ms-1">
                                                -{{ round((($originalPrice - $finalPrice) / $originalPrice) * 100) }}%
                                            </small>
                                        @endif
                                    </div>
                                @endif
                                <div class="mt-2">
                                    <a href="{{ route('admin.ads.create', ['category' => $activeTab, 'product_id' => $product->id]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i data-feather="plus"></i> Add to Ads
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bulkActionForm" method="POST" action="{{ route('admin.ads.bulk-action') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Action</label>
                        <select name="action" id="bulkAction" class="form-select" required>
                            <option value="">Choose action...</option>
                            <option value="activate">Activate Selected</option>
                            <option value="deactivate">Deactivate Selected</option>
                            <option value="delete">Delete Selected</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="2" placeholder="Any additional notes..."></textarea>
                    </div>

                    <div class="selected-count">
                        <p class="text-muted mb-0">Selected: <span id="selectedCount">0</span> ads</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="bulkActionSubmit" disabled>Execute Action</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toggle Status Modal -->
<div class="modal fade" id="toggleStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="toggleStatusTitle">Toggle Ad Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="toggleStatusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert" id="toggleStatusAlert">
                        <i data-feather="info" class="me-2"></i>
                        You are about to change the status of <strong id="toggleStatusProductName"></strong>.
                    </div>
                    <input type="hidden" name="product_id" id="toggleStatusProductId">
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Product Ad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i data-feather="alert-triangle" class="me-2"></i>
                        You are about to delete the ad for <strong id="deleteProductName"></strong>.
                    </div>
                    <p>This action cannot be undone. The product will be removed from the selected category.</p>
                    <div class="mb-3">
                        <label class="form-label">Deletion Reason (Optional)</label>
                        <textarea name="deletion_reason" class="form-control" rows="2" placeholder="Reason for deleting this ad..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i data-feather="trash-2"></i> Delete Ad
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--=== End Product Ads Area ===-->
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Feather Icons
    feather.replace();

    // Select All Functionality
    $('#selectAll').change(function() {
        $('.ad-checkbox').prop('checked', this.checked);
        updateSelectedCount();
    });

    $('.ad-checkbox').change(function() {
        updateSelectedCount();

        // Update select all checkbox
        const totalCheckboxes = $('.ad-checkbox').length;
        const checkedCheckboxes = $('.ad-checkbox:checked').length;
        $('#selectAll').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        $('#selectAll').prop('checked', checkedCheckboxes === totalCheckboxes);
    });

    // Bulk Action Form
    $('#bulkAction').change(function() {
        updateBulkActionButton();
    });

    // Bulk Action Form Submission
    $('#bulkActionForm').submit(function(e) {
        const selectedIds = getSelectedIds();
        if (selectedIds.length === 0) {
            e.preventDefault();
            alert('Please select at least one ad.');
            return;
        }

        // Add selected IDs to form
        selectedIds.forEach(id => {
            $(this).append(`<input type="hidden" name="ad_ids[]" value="${id}">`);
        });

        // Confirm action
        const action = $('#bulkAction').val();
        const count = selectedIds.length;
        if (!confirm(`Are you sure you want to ${action} ${count} ad(s)?`)) {
            e.preventDefault();
        }
    });
});

function updateSelectedCount() {
    const count = $('.ad-checkbox:checked').length;
    $('#selectedCount').text(count);
    updateBulkActionButton();
}

function updateBulkActionButton() {
    const selectedCount = $('.ad-checkbox:checked').length;
    const action = $('#bulkAction').val();
    $('#bulkActionSubmit').prop('disabled', selectedCount === 0 || !action);
}

function getSelectedIds() {
    return $('.ad-checkbox:checked').map(function() {
        return $(this).val();
    }).get();
}

function toggleAdStatus(id, product_id, status, productName) {
    $('#toggleStatusProductName').text(productName);
    $('#toggleStatusProductId').val(product_id);
    $('#toggleStatusValue').val(status ? 1 : 0);

    const action = status ? 'activate' : 'deactivate';
    const alertClass = status ? 'alert-success' : 'alert-warning';
    const btnClass = status ? 'btn-success' : 'btn-warning';
    const iconName = status ? 'play' : 'pause';

    $('#toggleStatusTitle').text(`${status ? 'Activate' : 'Deactivate'} Product Ad`);
    $('#toggleStatusAlert').removeClass('alert-success alert-warning').addClass(alertClass);
    $('#toggleStatusSubmitBtn').removeClass('btn-success btn-warning').addClass(btnClass);
    $('#toggleStatusIcon').attr('data-feather', iconName);
    $('#toggleStatusText').text(status ? 'Activate Ad' : 'Deactivate Ad');
    $('#toggleStatusForm').attr('action', `/admin/ads/${id}`);

    feather.replace();
    $('#toggleStatusModal').modal('show');
}

function deleteAd(id, productName) {
    $('#deleteProductName').text(productName);
    $('#deleteForm').attr('action', `/admin/ads/${id}`);
    $('#deleteModal').modal('show');
}

// Auto-refresh statistics every 30 seconds
setInterval(function() {
    // Could implement AJAX refresh of statistics here
}, 30000);
</script>
@endpush
