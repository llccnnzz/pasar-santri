@extends('layouts.admin.main')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Promotion Details</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.promos.edit', $promotion) }}" class="btn btn-primary">
                                    <i class="ri-edit-line"></i> Edit
                                </a>
                                <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary">
                                    <i class="ri-arrow-left-line"></i> Back
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <!-- Main Content -->
                                <div class="col-lg-8">
                                    <!-- Basic Information -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Basic Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Promo Code</label>
                                                        <div>
                                                            <code class="fs-5 text-primary">{{ $promotion->code }}</code>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary ms-2" 
                                                                    onclick="copyToClipboard('{{ $promotion->code }}')"
                                                                    title="Copy code">
                                                                <i class="ri-file-copy-line"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Promotion Name</label>
                                                        <div class="fw-bold">{{ $promotion->name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            @if($promotion->description)
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Description</label>
                                                <div>{{ $promotion->description }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Discount Configuration -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Discount Configuration</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Discount Type</label>
                                                        <div>
                                                            <span class="badge bg-info">Fixed Amount</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Discount Amount</label>
                                                        <div class="fs-5 text-success fw-bold">
                                                            Rp{{ number_format($promotion->discount_value, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Minimum Order Amount</label>
                                                <div class="fw-bold">
                                                    Rp{{ number_format($promotion->minimum_order_amount, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Usage Statistics -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Usage Statistics</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <div class="fs-2 fw-bold text-primary">{{ $promotion->used_count }}</div>
                                                        <div class="text-muted">Times Used</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <div class="fs-2 fw-bold text-info">
                                                            {{ $promotion->usage_limit ?? '∞' }}
                                                        </div>
                                                        <div class="text-muted">Usage Limit</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <div class="fs-2 fw-bold text-success">
                                                            @if($promotion->usage_limit)
                                                                {{ $promotion->usage_limit - $promotion->used_count }}
                                                            @else
                                                                ∞
                                                            @endif
                                                        </div>
                                                        <div class="text-muted">Remaining</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            @if($promotion->usage_limit)
                                            <div class="mt-3">
                                                <div class="d-flex justify-content-between small mb-1">
                                                    <span>Usage Progress</span>
                                                    <span>{{ number_format(($promotion->used_count / $promotion->usage_limit) * 100, 1) }}%</span>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: {{ ($promotion->used_count / $promotion->usage_limit) * 100 }}%"
                                                         aria-valuenow="{{ $promotion->used_count }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="{{ $promotion->usage_limit }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Sidebar -->
                                <div class="col-lg-4">
                                    <!-- Status Card -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Status</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <span class="badge bg-{{ $promotion->status_color }} fs-6 px-3 py-2">
                                                    {{ $promotion->status_label }}
                                                </span>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           id="is_active" 
                                                           {{ $promotion->is_active ? 'checked' : '' }}
                                                           disabled>
                                                    <label class="form-check-label ms-2" for="is_active">
                                                        Active
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            @if($promotion->status === 'active')
                                            <div class="alert alert-success">
                                                <i class="ri-check-line"></i>
                                                This promotion is currently active and can be used.
                                            </div>
                                            @elseif($promotion->status === 'expired')
                                            <div class="alert alert-danger">
                                                <i class="ri-time-line"></i>
                                                This promotion has expired.
                                            </div>
                                            @elseif($promotion->status === 'scheduled')
                                            <div class="alert alert-info">
                                                <i class="ri-calendar-line"></i>
                                                This promotion is scheduled for future activation.
                                            </div>
                                            @elseif($promotion->status === 'limit_reached')
                                            <div class="alert alert-warning">
                                                <i class="ri-forbid-line"></i>
                                                Usage limit has been reached.
                                            </div>
                                            @elseif($promotion->status === 'inactive')
                                            <div class="alert alert-secondary">
                                                <i class="ri-pause-line"></i>
                                                This promotion is currently inactive.
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Date Information -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Date Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Start Date</label>
                                                <div class="fw-bold">
                                                    {{ $promotion->starts_at->format('F d, Y \a\t g:i A') }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $promotion->starts_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Expiry Date</label>
                                                <div class="fw-bold">
                                                    {{ $promotion->expires_at->format('F d, Y \a\t g:i A') }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $promotion->expires_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Duration</label>
                                                <div class="fw-bold">
                                                    {{ $promotion->starts_at->diffInDays($promotion->expires_at) }} days
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Created</label>
                                                <div>{{ $promotion->created_at->format('F d, Y \a\t g:i A') }}</div>
                                                <small class="text-muted">
                                                    {{ $promotion->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            
                                            @if($promotion->updated_at != $promotion->created_at)
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Last Updated</label>
                                                <div>{{ $promotion->updated_at->format('F d, Y \a\t g:i A') }}</div>
                                                <small class="text-muted">
                                                    {{ $promotion->updated_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Quick Actions -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Quick Actions</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('admin.promos.edit', $promotion) }}" class="btn btn-primary">
                                                    <i class="ri-edit-line"></i> Edit Promotion
                                                </a>
                                                
                                                <button type="button" 
                                                        class="btn btn-outline-danger delete-promo-btn" 
                                                        data-promo-id="{{ $promotion->id }}"
                                                        data-promo-code="{{ $promotion->code }}">
                                                    <i class="ri-delete-bin-line"></i> Delete Promotion
                                                </button>
                                                
                                                <button type="button" 
                                                        class="btn btn-outline-secondary"
                                                        onclick="copyToClipboard('{{ $promotion->code }}')">
                                                    <i class="ri-file-copy-line"></i> Copy Code
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    
    // Copy to clipboard function
    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(function() {
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'Promo code copied to clipboard',
                timer: 1500,
                showConfirmButton: false
            });
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
        });
    };
    
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
                        window.location.href = '{{ route("admin.promos.index") }}';
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
