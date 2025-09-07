@extends('layouts.admin.main')

@section('title', 'Shipping Methods Management')

@section('content')
<div class="card border-0 rounded-3 mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Shipping Couriers Management</h2>
        <div class="d-flex gap-2">
            <button class="btn btn-success btn-sm" onclick="syncFromApi()">
                <i data-feather="refresh-cw"></i> Sync from API
            </button>
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
                            <i data-feather="package" class="text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Total Methods</span>
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
                            <i data-feather="check-circle" class="text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Active</span>
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
                            <i data-feather="x-circle" class="text-secondary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Inactive</span>
                        <h4 class="fs-20 mb-0">{{ number_format($statistics['inactive']) }}</h4>
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
                            <i data-feather="truck" class="text-info"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Couriers</span>
                        <h4 class="fs-20 mb-0">{{ number_format($statistics['couriers']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 rounded-3 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.shipping.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status Filter</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by courier name, service name, code..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i data-feather="search"></i> Filter
                </button>
                <a href="{{ route('admin.shipping.index') }}" class="btn btn-outline-secondary">
                    <i data-feather="refresh-cw"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Courier Cards -->
<div class="row">
    @if($groupedMethods->count() > 0)
        @foreach($groupedMethods as $courier)
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="card border-0 rounded-3 courier-card cursor-pointer" style="background-color: {{ $courier['active_services'] === 0 ? '#ffcaca' : '#fff' }}"
                     onclick="showCourierMethods('{{ $courier['courier_code'] }}', '{{ $courier['courier_name'] }}')">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    @if($courier['logo_url'])
                                        <img src="{{ $courier['logo_url'] }}"
                                             alt="{{ $courier['courier_name'] }}"
                                             class="rounded"
                                             style="width: 50px; height: 50px; object-fit: contain;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center"
                                             style="width: 50px; height: 50px;">
                                            <i data-feather="truck" class="text-primary" style="width: 24px; height: 24px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">{{ $courier['courier_name'] }}</h5>
                                    <small class="text-muted">{{ strtoupper($courier['courier_code']) }}</small>
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input courier-toggle"
                                       type="checkbox"
                                       data-courier-code="{{ $courier['courier_code'] }}"
                                       data-courier-name="{{ $courier['courier_name'] }}"
                                       {{ $courier['all_active'] ? 'checked' : '' }}
                                       onclick="event.stopPropagation();">
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-4">
                                <div class="border-end">
                                    <h6 class="mb-0 text-primary">{{ $courier['total_services'] }}</h6>
                                    <small class="text-muted">Services</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border-end">
                                    <h6 class="mb-0 text-success">{{ $courier['active_services'] }}</h6>
                                    <small class="text-muted">Active</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <h6 class="mb-0 text-secondary">{{ $courier['inactive_services'] }}</h6>
                                <small class="text-muted">Inactive</small>
                            </div>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">Click to manage individual services</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12">
            <div class="card border-0 rounded-3">
                <div class="card-body text-center py-5">
                    <i data-feather="package" class="mb-3" style="width: 48px; height: 48px;" stroke="1.5"></i>
                    <h5>No Shipping Methods Found</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['status', 'search']))
                            No shipping methods match your current filters.
                        @else
                            No shipping methods have been configured yet.
                        @endif
                    </p>
                    @if(request()->hasAny(['status', 'search']))
                        <a href="{{ route('admin.shipping.index') }}" class="btn btn-outline-primary">Clear Filters</a>
                    @else
                        <button class="btn btn-primary" onclick="syncFromApi()">
                            <i data-feather="refresh-cw"></i> Sync from API
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Courier Methods Modal -->
<div class="modal fade" id="courierMethodsModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span id="modalCourierName">Courier</span> - Shipping Methods
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="courierMethodsList">
                    <!-- Methods will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Sync from API Modal -->
<div class="modal fade" id="syncApiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sync Shipping Methods from API</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.shipping.sync-api') }}">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i data-feather="alert-triangle" class="me-2"></i>
                        This will sync shipping methods from Biteship API. New methods will be added and existing ones will be updated.
                    </div>
                    <p class="text-muted">This process may take a few moments to complete.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i data-feather="refresh-cw"></i> Sync Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.courier-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.courier-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.method-card {
    transition: background-color 0.2s;
}

.method-card:hover {
    background-color: #f8f9fa;
}

.cursor-pointer {
    cursor: pointer;
}
</style>
@endpush

@push('scripts')
<script>
// Store grouped methods data for modal
const groupedMethodsData = @json($groupedMethods);

$(document).ready(function() {
    feather.replace();

    // Handle courier toggle
    $('.courier-toggle').change(function(e) {
        e.stopPropagation();

        const courierCode = $(this).data('courier-code');
        const courierName = $(this).data('courier-name');
        const isActive = $(this).is(':checked');

        toggleCourierStatus(courierCode, courierName, isActive, $(this));
    });
});

function showCourierMethods(courierCode, courierName) {
    const courierData = groupedMethodsData[courierCode];

    if (!courierData) {
        console.error('Courier data not found for:', courierCode);
        return;
    }

    $('#modalCourierName').text(courierName);

    let methodsHtml = '';
    courierData.methods.forEach(method => {
        methodsHtml +=
            '<div class="card method-card border mb-2">' +
                '<div class="card-body p-3">' +
                    '<div class="d-flex align-items-center justify-content-between">' +
                        '<div class="flex-grow-1">' +
                            '<h6 class="mb-1">' + method.service_name + '</h6>' +
                            '<div class="d-flex gap-2 mb-1">' +
                                '<span class="badge bg-secondary">' + method.service_code.toUpperCase() + '</span>' +
                                '<span class="badge bg-' + (method.active ? 'success' : 'secondary') + '">' + (method.active ? 'Active' : 'Inactive') + '</span>' +
                            '</div>' +
                            '<small class="text-muted">' + (method.description || 'No description') + '</small>' +
                        '</div>' +
                        '<div class="flex-shrink-0 ms-3">' +
                            '<div class="form-check form-switch">' +
                                '<input class="form-check-input method-toggle" ' +
                                       'type="checkbox" ' +
                                       'data-method-id="' + method.id + '" ' +
                                       'data-method-name="' + method.service_name + '" ' +
                                       (method.active ? 'checked' : '') + '>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
    });

    $('#courierMethodsList').html(methodsHtml);

    // Bind toggle events for individual methods
    $('.method-toggle').change(function() {
        const methodId = $(this).data('method-id');
        const methodName = $(this).data('method-name');
        const isActive = $(this).is(':checked');

        toggleMethodStatus(methodId, methodName, isActive, $(this));
    });

    $('#courierMethodsModal').modal('show');
}

function toggleCourierStatus(courierCode, courierName, isActive, toggleElement) {
    $.ajax({
        url: '/admin/shipping-methods/courier/' + courierCode + '/toggle-status',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            active: isActive
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });

                // Reload page to update UI
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            Swal.fire({
                title: 'Error!',
                text: response?.message || 'Failed to update courier status.',
                icon: 'error',
                confirmButtonText: 'OK'
            });

            // Revert toggle
            toggleElement.prop('checked', !isActive);
        }
    });
}

function toggleMethodStatus(methodId, methodName, isActive, toggleElement) {
    $.ajax({
        url: '/admin/shipping-methods/' + methodId + '/toggle-status',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function() {
            Swal.fire({
                title: 'Success!',
                text: methodName + ' has been ' + (isActive ? 'activated' : 'deactivated') + ' successfully.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        },
        error: function() {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update method status.',
                icon: 'error',
                confirmButtonText: 'OK'
            });

            // Revert toggle
            toggleElement.prop('checked', !isActive);
        }
    });
}

function syncFromApi() {
    $('#syncApiModal').modal('show');
}
</script>
@endpush
