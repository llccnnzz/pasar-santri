@extends('layouts.admin.main')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Create New Promotion</h4>
                            <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line"></i> Back to Promotions
                            </a>
                        </div>
                        
                        <form action="{{ route('admin.promos.store') }}" method="POST" id="createPromoForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <!-- Basic Information -->
                                    <div class="col-lg-8">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Basic Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="code" class="form-label">
                                                                Promo Code <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" 
                                                                   class="form-control @error('code') is-invalid @enderror" 
                                                                   id="code" 
                                                                   name="code" 
                                                                   value="{{ old('code') }}" 
                                                                   placeholder="Enter promo code"
                                                                   style="text-transform: uppercase;">
                                                            @error('code')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            <small class="text-muted">Code will be automatically converted to uppercase</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">
                                                                Promotion Name <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" 
                                                                   class="form-control @error('name') is-invalid @enderror" 
                                                                   id="name" 
                                                                   name="name" 
                                                                   value="{{ old('name') }}" 
                                                                   placeholder="Enter promotion name">
                                                            @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                                              id="description" 
                                                              name="description" 
                                                              rows="3" 
                                                              placeholder="Enter promotion description">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
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
                                                            <label for="discount_value" class="form-label">
                                                                Discount Amount <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Rp</span>
                                                                <input type="number" 
                                                                       class="form-control @error('discount_value') is-invalid @enderror" 
                                                                       id="discount_value" 
                                                                       name="discount_value" 
                                                                       value="{{ old('discount_value') }}" 
                                                                       placeholder="0"
                                                                       step="1000"
                                                                       min="1000">
                                                                @error('discount_value')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <small class="text-muted">Fixed discount amount in Indonesian Rupiah</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="minimum_order_amount" class="form-label">
                                                                Minimum Order Amount
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Rp</span>
                                                                <input type="number" 
                                                                       class="form-control @error('minimum_order_amount') is-invalid @enderror" 
                                                                       id="minimum_order_amount" 
                                                                       name="minimum_order_amount" 
                                                                       value="{{ old('minimum_order_amount', 0) }}" 
                                                                       placeholder="0"
                                                                       step="1000"
                                                                       min="0">
                                                                @error('minimum_order_amount')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <small class="text-muted">Minimum order value to apply this promotion</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Date & Usage Configuration -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Date & Usage Configuration</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="starts_at" class="form-label">
                                                                Start Date <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="datetime-local" 
                                                                   class="form-control @error('starts_at') is-invalid @enderror" 
                                                                   id="starts_at" 
                                                                   name="starts_at" 
                                                                   value="{{ old('starts_at', now()->format('Y-m-d\TH:i')) }}">
                                                            @error('starts_at')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="expires_at" class="form-label">
                                                                Expiry Date <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="datetime-local" 
                                                                   class="form-control @error('expires_at') is-invalid @enderror" 
                                                                   id="expires_at" 
                                                                   name="expires_at" 
                                                                   value="{{ old('expires_at', now()->addDays(30)->format('Y-m-d\TH:i')) }}">
                                                            @error('expires_at')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="usage_limit" class="form-label">Usage Limit</label>
                                                    <input type="number" 
                                                           class="form-control @error('usage_limit') is-invalid @enderror" 
                                                           id="usage_limit" 
                                                           name="usage_limit" 
                                                           value="{{ old('usage_limit') }}" 
                                                           placeholder="Leave empty for unlimited usage"
                                                           min="1">
                                                    @error('usage_limit')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-muted">Maximum number of times this promotion can be used</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Sidebar -->
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Promotion Settings</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               id="is_active" 
                                                               name="is_active" 
                                                               value="1" 
                                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_active">
                                                            Active
                                                        </label>
                                                    </div>
                                                    <small class="text-muted">Toggle to activate/deactivate this promotion</small>
                                                </div>
                                                
                                                <div class="alert alert-info">
                                                    <h6 class="alert-heading">
                                                        <i class="ri-information-line"></i> Promotion Info
                                                    </h6>
                                                    <ul class="mb-0 small">
                                                        <li>Discount type is fixed to <strong>Fixed Amount</strong></li>
                                                        <li>Promo codes are case-insensitive</li>
                                                        <li>Each promotion can only be used once per order</li>
                                                        <li>Expired promotions cannot be used</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Preview Card -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Preview</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="promotion-preview border rounded p-3">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <code class="text-primary fw-bold" id="preview-code">PROMO-CODE</code>
                                                        <span class="badge bg-success">Active</span>
                                                    </div>
                                                    <h6 class="mb-1" id="preview-name">Promotion Name</h6>
                                                    <p class="text-muted small mb-2" id="preview-description">Promotion description</p>
                                                    <div class="d-flex justify-content-between small">
                                                        <span>Discount:</span>
                                                        <strong class="text-success" id="preview-discount">Rp0</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between small">
                                                        <span>Min. Order:</span>
                                                        <span id="preview-min-order">Rp0</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line"></i> Create Promotion
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-uppercase promo code
    $('#code').on('input', function() {
        this.value = this.value.toUpperCase();
        updatePreview();
    });
    
    // Update preview on form changes
    $('#name, #description, #discount_value, #minimum_order_amount').on('input', updatePreview);
    
    function updatePreview() {
        const code = $('#code').val() || 'PROMO-CODE';
        const name = $('#name').val() || 'Promotion Name';
        const description = $('#description').val() || 'Promotion description';
        const discount = parseFloat($('#discount_value').val()) || 0;
        const minOrder = parseFloat($('#minimum_order_amount').val()) || 0;
        
        $('#preview-code').text(code);
        $('#preview-name').text(name);
        $('#preview-description').text(description);
        $('#preview-discount').text('Rp' + new Intl.NumberFormat('id-ID').format(discount));
        $('#preview-min-order').text('Rp' + new Intl.NumberFormat('id-ID').format(minOrder));
    }
    
    // Form validation
    $('#createPromoForm').on('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        let isValid = true;
        const code = $('#code').val().trim();
        const name = $('#name').val().trim();
        const discountValue = parseFloat($('#discount_value').val());
        const startsAt = new Date($('#starts_at').val());
        const expiresAt = new Date($('#expires_at').val());
        
        // Remove previous validation classes
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        
        if (!code) {
            showFieldError('#code', 'Promo code is required.');
            isValid = false;
        }
        
        if (!name) {
            showFieldError('#name', 'Promotion name is required.');
            isValid = false;
        }
        
        if (!discountValue || discountValue < 1000) {
            showFieldError('#discount_value', 'Discount value must be at least Rp1,000.');
            isValid = false;
        }
        
        if (expiresAt <= startsAt) {
            showFieldError('#expires_at', 'Expiry date must be after start date.');
            isValid = false;
        }
        
        if (isValid) {
            this.submit();
        }
    });
    
    function showFieldError(fieldSelector, message) {
        $(fieldSelector).addClass('is-invalid');
        $(fieldSelector).after('<div class="invalid-feedback">' + message + '</div>');
    }
    
    // Initialize preview
    updatePreview();
});
</script>
@endpush
