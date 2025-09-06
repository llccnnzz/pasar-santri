@extends('layouts.admin.main')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Promotion Management</h4>
                            <a href="{{ route('admin.promos.create') }}" class="btn btn-primary">
                                <i class="ri-add-line"></i> Create Promotion
                            </a>
                        </div>
                        
                        <!-- Statistics Cards -->
                        <div class="card-body border-bottom">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white mb-0">
                                        <div class="card-body text-center py-3">
                                            <h6 class="text-white mb-0">Total Promotions</h6>
                                            <h4 class="text-white mb-0">{{ $stats['total'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white mb-0">
                                        <div class="card-body text-center py-3">
                                            <h6 class="text-white mb-0">Active</h6>
                                            <h4 class="text-white mb-0">{{ $stats['active'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white mb-0">
                                        <div class="card-body text-center py-3">
                                            <h6 class="text-white mb-0">Scheduled</h6>
                                            <h4 class="text-white mb-0">{{ $stats['scheduled'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-danger text-white mb-0">
                                        <div class="card-body text-center py-3">
                                            <h6 class="text-white mb-0">Expired</h6>
                                            <h4 class="text-white mb-0">{{ $stats['expired'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Filters -->
                        <div class="card-body border-bottom">
                            <form method="GET" action="{{ route('admin.promos.index') }}" class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search promotions..." 
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="sort_by" class="form-select">
                                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                                        <option value="code" {{ request('sort_by') == 'code' ? 'selected' : '' }}>Code</option>
                                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                        <option value="expires_at" {{ request('sort_by') == 'expires_at' ? 'selected' : '' }}>Expiry Date</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-outline-primary">
                                            <i class="ri-search-line"></i>
                                        </button>
                                        <a href="{{ route('admin.promos.index') }}" class="btn btn-outline-secondary">
                                            <i class="ri-refresh-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Promotions Table -->
                        <div class="card-body">
                            @if($promotions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Discount</th>
                                            <th>Min. Order</th>
                                            <th>Usage</th>
                                            <th>Dates</th>
                                            <th>Status</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($promotions as $promotion)
                                        <tr>
                                            <td>
                                                <code class="text-primary">{{ $promotion->code }}</code>
                                            </td>
                                            <td>
                                                <strong>{{ $promotion->name }}</strong>
                                                @if($promotion->description)
                                                <br><small class="text-muted">{{ Str::limit($promotion->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    Rp{{ number_format($promotion->discount_value, 0, ',', '.') }} Fixed
                                                </span>
                                            </td>
                                            <td>
                                                Rp{{ number_format($promotion->minimum_order_amount, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @if($promotion->usage_limit)
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                        <div class="progress-bar" role="progressbar" 
                                                             style="width: {{ ($promotion->used_count / $promotion->usage_limit) * 100 }}%"></div>
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
                                                <span class="badge bg-{{ $promotion->status_color }}">
                                                    {{ $promotion->status_label }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.promos.show', $promotion) }}" 
                                                       class="btn btn-outline-info" title="View">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                    <a href="{{ route('admin.promos.edit', $promotion) }}" 
                                                       class="btn btn-outline-primary" title="Edit">
                                                        <i class="ri-edit-line"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-outline-danger delete-promo-btn" 
                                                            data-promo-id="{{ $promotion->id }}"
                                                            data-promo-code="{{ $promotion->code }}"
                                                            title="Delete">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
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
                                <i class="ri-coupon-line fs-1 text-muted"></i>
                                <h5 class="mt-3 text-muted">No promotions found</h5>
                                <p class="text-muted">Create your first promotion to get started.</p>
                                <a href="{{ route('admin.promos.create') }}" class="btn btn-primary">
                                    <i class="ri-add-line"></i> Create Promotion
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deletePromoModal" tabindex="-1" aria-labelledby="deletePromoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePromoModalLabel">Delete Promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the promotion code <strong id="deletePromoCode"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeletePromo">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let promoToDelete = null;
    
    // Delete promotion button click
    $('.delete-promo-btn').on('click', function() {
        promoToDelete = $(this).data('promo-id');
        const promoCode = $(this).data('promo-code');
        $('#deletePromoCode').text(promoCode);
        $('#deletePromoModal').modal('show');
    });
    
    // Confirm delete
    $('#confirmDeletePromo').on('click', function() {
        if (!promoToDelete) return;
        
        $.ajax({
            url: `/admin/promos/${promoToDelete}`,
            method: 'DELETE',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#confirmDeletePromo').prop('disabled', true).text('Deleting...');
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
                $('#confirmDeletePromo').prop('disabled', false).text('Delete');
                promoToDelete = null;
            }
        });
    });
    
    // Clear modal when hidden
    $('#deletePromoModal').on('hidden.bs.modal', function() {
        promoToDelete = null;
        $('#confirmDeletePromo').prop('disabled', false).text('Delete');
    });
});
</script>
@endpush
