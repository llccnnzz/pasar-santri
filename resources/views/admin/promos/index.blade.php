@extends('layouts.admin.main')

@section('title', 'Promotion Management')

@section('content')
<!--=== Start Promotion Management Area ===-->
<div class="card border-0 rounded-3 mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Promotion Management</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.promos.create') }}" class="btn btn-success btn-sm">
                <i data-feather="plus"></i> Create Promotion
            </a>
        </div>
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
                            <i data-feather="tag" class="text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Total Promotions</span>
                        <h4 class="fs-20 mb-0">{{ number_format($stats['total']) }}</h4>
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
                            <i data-feather="check-circle" class="text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Active</span>
                        <h4 class="fs-20 mb-0">{{ number_format($stats['active']) }}</h4>
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
                            <i data-feather="clock" class="text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Scheduled</span>
                        <h4 class="fs-20 mb-0">{{ number_format($stats['scheduled']) }}</h4>
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
                            <i data-feather="x-circle" class="text-danger"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Expired</span>
                        <h4 class="fs-20 mb-0">{{ number_format($stats['expired']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Filters -->
<div class="card border-0 rounded-3 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.promos.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status Filter</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by code, name, description..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i data-feather="search"></i> Filter
                </button>
                <a href="{{ route('admin.promos.index') }}" class="btn btn-outline-secondary">
                    <i data-feather="refresh-cw"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>
<!-- Promotions Table -->
<div class="card border-0 rounded-3">
    <div class="card-body">
        @if($promotions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>Promotion Details</th>
                            <th>Discount</th>
                            <th>Usage</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promotions as $promotion)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input promo-checkbox" type="checkbox" value="{{ $promotion->id }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i data-feather="tag" class="text-primary" style="width: 18px; height: 18px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">{{ $promotion->name }}</h6>
                                            <small class="text-muted">Code: <code class="text-primary">{{ $promotion->code }}</code></small>
                                            @if($promotion->description)
                                                <br><small class="text-muted">{{ Str::limit($promotion->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">Rp{{ number_format($promotion->discount_value, 0, ',', '.') }} Fixed</span>
                                    @if($promotion->minimum_order_amount)
                                        <br><small class="text-muted">Min: Rp{{ number_format($promotion->minimum_order_amount, 0, ',', '.') }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($promotion->usage_limit)
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 6px; width: 60px;">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: {{ $promotion->usage_limit > 0 ? ($promotion->used_count / $promotion->usage_limit) * 100 : 0 }}%"></div>
                                            </div>
                                            <small>{{ $promotion->used_count }}/{{ $promotion->usage_limit }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">{{ $promotion->used_count }} used</span>
                                    @endif
                                </td>
                                <td>
                                    <small>
                                        <strong>Start:</strong> {{ $promotion->starts_at->format('M d, Y') }}<br>
                                        <strong>End:</strong> {{ $promotion->expires_at->format('M d, Y') }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $promotion->status_color }}">{{ $promotion->status_label }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.promos.show', $promotion) }}">
                                                    <i data-feather="eye" class="me-2" style="width: 14px; height: 14px;"></i>
                                                    View Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.promos.edit', $promotion) }}">
                                                    <i data-feather="edit" class="me-2" style="width: 14px; height: 14px;"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button class="dropdown-item text-danger" onclick="deletePromotion('{{ $promotion->id }}', '{{ $promotion->code }}')">
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
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Showing {{ $promotions->firstItem() ?? 0 }} to {{ $promotions->lastItem() ?? 0 }}
                    of {{ $promotions->total() }} results
                </div>
                {{ $promotions->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i data-feather="tag" class="text-muted" style="width: 64px; height: 64px;"></i>
                <h5 class="mt-3 text-muted">No promotions found</h5>
                <p class="text-muted">Create your first promotion to get started.</p>
                <a href="{{ route('admin.promos.create') }}" class="btn btn-primary">
                    <i data-feather="plus"></i> Create Promotion
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deletePromoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="deletePromoForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i data-feather="alert-triangle" class="me-2"></i>
                        You are about to delete the promotion code <strong id="deletePromoCode"></strong>.
                    </div>
                    <p class="text-danger mb-3"><small>This action cannot be undone.</small></p>
                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="2" placeholder="Reason for deletion..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i data-feather="trash-2"></i> Delete Promotion
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--=== End Promotion Management Area ===-->
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Feather Icons
    feather.replace();

    // Select All Functionality
    $('#selectAll').change(function() {
        $('.promo-checkbox').prop('checked', this.checked);
        updateSelectedCount();
    });

    $('.promo-checkbox').change(function() {
        updateSelectedCount();

        // Update select all checkbox
        const totalCheckboxes = $('.promo-checkbox').length;
        const checkedCheckboxes = $('.promo-checkbox:checked').length;
        $('#selectAll').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        $('#selectAll').prop('checked', checkedCheckboxes === totalCheckboxes);
    });

    // Delete Promotion Form Submission
    $('#deletePromoForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                $('#deletePromoForm button[type="submit"]').prop('disabled', true);
            },
            success: function(response) {
                $('#deletePromoModal').modal('hide');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
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
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message || 'An error occurred while deleting the promotion.'
                });
            },
            complete: function() {
                $('#deletePromoForm button[type="submit"]').prop('disabled', false);
            }
        });
    });
});

function updateSelectedCount() {
    const count = $('.promo-checkbox:checked').length;
    $('#selectedCount').text(count);
}

function getSelectedIds() {
    return $('.promo-checkbox:checked').map(function() {
        return $(this).val();
    }).get();
}

function deletePromotion(promoId, promoCode) {
    $('#deletePromoCode').text(promoCode);
    $('#deletePromoForm').attr('action', `/admin/promos/${promoId}`);
    feather.replace();
    $('#deletePromoModal').modal('show');
}
</script>
@endpush
