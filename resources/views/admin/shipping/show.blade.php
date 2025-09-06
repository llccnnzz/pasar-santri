@extends('layouts.admin.main')

@section('title', 'Shipping Method Details')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Shipping Method Info -->
        <div class="card border-0 rounded-3 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Shipping Method Information</h4>
                <div>
                    <span class="badge bg-{{ $shippingMethod->active ? 'success' : 'secondary' }} fs-12">
                        {{ $shippingMethod->active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Courier Name</label>
                            <p class="mb-0 fw-medium">{{ $shippingMethod->courier_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Courier Code</label>
                            <p class="mb-0 fw-medium">
                                <span class="badge bg-primary">{{ strtoupper($shippingMethod->courier_code) }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Service Name</label>
                            <p class="mb-0 fw-medium">{{ $shippingMethod->service_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Service Code</label>
                            <p class="mb-0 fw-medium">
                                <span class="badge bg-secondary">{{ strtoupper($shippingMethod->service_code) }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label text-muted">Description</label>
                            <p class="mb-0 fw-medium">{{ $shippingMethod->description ?: 'No description available' }}</p>
                        </div>
                    </div>
                    @if($shippingMethod->logo_url)
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label text-muted">Courier Logo</label>
                            <div class="mt-2">
                                <img src="{{ $shippingMethod->logo_url }}" 
                                     alt="{{ $shippingMethod->courier_name }}" 
                                     class="rounded border"
                                     style="width: 80px; height: 80px; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="card border-0 rounded-3 mb-4">
            <div class="card-header">
                <h4 class="mb-0">System Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Created At</label>
                            <p class="mb-0 fw-medium">{{ $shippingMethod->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Last Updated</label>
                            <p class="mb-0 fw-medium">{{ $shippingMethod->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label text-muted">Unique Identifier</label>
                            <p class="mb-0">
                                <code>{{ $shippingMethod->courier_code }}.{{ $shippingMethod->service_code }}</code>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card border-0 rounded-3 mb-4">
            <div class="card-header">
                <h4 class="mb-0">Quick Actions</h4>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-{{ $shippingMethod->active ? 'warning' : 'success' }}" 
                            onclick="toggleStatus('{{ $shippingMethod->id }}', '{{ $shippingMethod->courier_name }} - {{ $shippingMethod->service_name }}', {{ $shippingMethod->active ? 'false' : 'true' }})">
                        <i data-feather="{{ $shippingMethod->active ? 'pause' : 'play' }}" class="me-2"></i>
                        {{ $shippingMethod->active ? 'Deactivate' : 'Activate' }} Method
                    </button>
                    <a href="{{ route('admin.shipping.index') }}" class="btn btn-outline-primary">
                        <i data-feather="arrow-left" class="me-2"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Information -->
        <div class="card border-0 rounded-3 mb-4">
            <div class="card-header">
                <h4 class="mb-0">Status Information</h4>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between p-3 rounded" 
                     style="background: {{ $shippingMethod->active ? '#d4edda' : '#f8f9fa' }};">
                    <div class="d-flex align-items-center">
                        <i data-feather="{{ $shippingMethod->active ? 'check-circle' : 'x-circle' }}" 
                           class="me-2 text-{{ $shippingMethod->active ? 'success' : 'secondary' }}"></i>
                        <span class="fw-medium">{{ $shippingMethod->active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <span class="badge bg-{{ $shippingMethod->active ? 'success' : 'secondary' }}">
                        {{ $shippingMethod->active ? 'Available' : 'Unavailable' }}
                    </span>
                </div>
                <small class="text-muted mt-2 d-block">
                    {{ $shippingMethod->active ? 'This shipping method is available for customers to select during checkout.' : 'This shipping method is not available for selection during checkout.' }}
                </small>
            </div>
        </div>

        <!-- Integration Info -->
        <div class="card border-0 rounded-3">
            <div class="card-header">
                <h4 class="mb-0">API Integration</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Source</label>
                    <p class="mb-2">
                        <span class="badge bg-info">Biteship API</span>
                    </p>
                    <small class="text-muted">This shipping method is synchronized from Biteship courier API.</small>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i data-feather="info" class="me-2" style="width: 16px; height: 16px;"></i>
                    <small>
                        To update shipping rates and availability, use the "Sync from API" feature in the shipping methods list.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toggle Status Modal -->
<div class="modal fade" id="toggleStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Toggle Shipping Method Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="toggleStatusForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i data-feather="info" class="me-2"></i>
                        You are about to <strong id="toggleAction"></strong> shipping method: <strong id="toggleMethodName"></strong>
                    </div>
                    <p class="text-muted">
                        <span id="toggleDescription"></span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="toggleSubmitBtn">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    feather.replace();
});

function toggleStatus(id, name, willBeActive) {
    const action = willBeActive === 'true' ? 'activate' : 'deactivate';
    $('#toggleAction').text(action);
    $('#toggleMethodName').text(name);
    $('#toggleStatusForm').attr('action', `/admin/shipping-methods/${id}/toggle-status`);
    $('#toggleSubmitBtn').text(`${action.charAt(0).toUpperCase() + action.slice(1)}`);
    
    if (willBeActive === 'true') {
        $('#toggleDescription').text('This shipping method will become available for customers during checkout.');
    } else {
        $('#toggleDescription').text('This shipping method will no longer be available for customers during checkout.');
    }
    
    $('#toggleStatusModal').modal('show');
}
</script>
@endpush
