@extends('layouts.seller.main')

@section('title', 'Shipping Methods')

@section('content')
<!--=== Start Section Title Area ===-->
<div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
    <h4 class="text-dark mb-0">Shipping Methods</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
            <li class="breadcrumb-item fs-14">
                <a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Shipping Methods</li>
        </ol>
    </nav>
</div>
<!--=== End Section Title Area ===-->

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
        <div class="card status-card border-0 rounded-3 mb-3">
            <div class="card-body p-20">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="icon rounded-3">
                            <i data-feather="package" class="text-primary w-20 h-20"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Available Methods</span>
                        <h4 class="fs-20 mb-0">{{ $inactiveGlobal->count() + $enabledMethods->count() + $disabledMethods->count() }}</h4>
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
                            <i data-feather="check-circle" class="text-success w-20 h-20"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Active</span>
                        <h4 class="fs-20 mb-0">{{ $enabledMethods->count() }}</h4>
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
                            <i data-feather="pause-circle" class="text-warning w-20 h-20"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Inactive</span>
                        <h4 class="fs-20 mb-0">{{ $disabledMethods->count() }}</h4>
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
                            <i data-feather="plus-circle" class="text-info w-20 h-20"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Not Used</span>
                        <h4 class="fs-20 mb-0">{{ $inactiveGlobal->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Courier Cards -->
<div class="row">
    @if($groupedMethods->count() > 0)
        @foreach($groupedMethods as $courier)
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="card border-0 rounded-3 courier-card cursor-pointer" style="background-color: {{ $courier['enabled_services'] === 0 ? '#ffcaca' : '#fff' }}"
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
                                       {{ $courier['all_enabled'] ? 'checked' : '' }}
                                       onclick="event.stopPropagation(); toggleAllCourier('{{ $courier['courier_code'] }}', this.checked);">
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-3">
                                <div class="border-end">
                                    <h6 class="mb-0 text-primary">{{ $courier['total_services'] }}</h6>
                                    <small class="text-muted">Total</small>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="border-end">
                                    <h6 class="mb-0 text-success">{{ $courier['enabled_services'] }}</h6>
                                    <small class="text-muted">Enabled</small>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="border-end">
                                    <h6 class="mb-0 text-warning">{{ $courier['disabled_services'] }}</h6>
                                    <small class="text-muted">Disabled</small>
                                </div>
                            </div>
                            <div class="col-3">
                                <h6 class="mb-0 text-secondary">{{ $courier['not_used_services'] }}</h6>
                                <small class="text-muted">Not Used</small>
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
                    <p class="text-muted">No shipping methods are available for your shop.</p>
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

<!-- Toast Notification Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
    <div id="toast-container"></div>
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

.status-card {
    transition: transform 0.2s;
}

.status-card:hover {
    transform: translateY(-1px);
}
</style>
@endpush

@push('scripts')
<script>
// Store grouped methods data for modal
const groupedMethodsData = @json($groupedMethods);
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let deleteId = null;
let deleteData = null;

$(document).ready(function() {
    // Initialize feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
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
        // Determine method status
        let status = 'not-used';
        let statusBadge = 'secondary';
        let statusText = 'Not Added';
        let isChecked = false;
        let actionButtons = '';

        if (method.pivot) {
            if (method.pivot.enabled) {
                status = 'enabled';
                statusBadge = 'success';
                statusText = 'Active';
                isChecked = true;
                actionButtons = `
                    <div class="form-check form-switch me-2">
                        <input class="form-check-input method-toggle"
                               type="checkbox"
                               data-method-id="${method.id}"
                               data-method-name="${method.service_name}"
                               checked>
                    </div>`;
            } else {
                status = 'disabled';
                statusBadge = 'warning';
                statusText = 'Inactive';
                actionButtons = `
                    <div class="form-check form-switch me-2">
                        <input class="form-check-input method-toggle"
                               type="checkbox"
                               data-method-id="${method.id}"
                               data-method-name="${method.service_name}">
                    </div>`;
            }
        } else {
            actionButtons = `
                <button class="btn btn-sm btn-success method-add"
                        data-method-id="${method.id}"
                        data-method-name="${method.courier_name} - ${method.service_name}">
                    <i data-feather="plus" class="w-14 h-14 me-1"></i> Add
                </button>`;
        }

        methodsHtml += `
            <div class="card method-card border mb-2" data-method-id="${method.id}">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">${method.service_name}</h6>
                            <div class="d-flex gap-2 mb-1">
                                <span class="badge bg-secondary">${method.service_code.toUpperCase()}</span>
                                <span class="badge bg-${statusBadge}">${statusText}</span>
                            </div>
                            <small class="text-muted">${method.description || 'No description available'}</small>
                        </div>
                        <div class="flex-shrink-0 ms-3 d-flex align-items-center">
                            ${actionButtons}
                        </div>
                    </div>
                </div>
            </div>`;
    });

    $('#courierMethodsList').html(methodsHtml);

    // Re-initialize feather icons for modal content
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    // Bind events for modal buttons
    bindModalEvents();

    $('#courierMethodsModal').modal('show');
}

function bindModalEvents() {
    // Method toggle events
    $('.method-toggle').off('change').on('change', function() {
        const methodId = $(this).data('method-id');
        const methodName = $(this).data('method-name');
        const isEnabled = $(this).is(':checked');

        toggleMethodStatus(methodId, methodName, isEnabled, $(this));
    });

    // Method add events
    $('.method-add').off('click').on('click', function() {
        const methodId = $(this).data('method-id');
        const methodName = $(this).data('method-name');

        addMethod(methodId, methodName, $(this));
    });

    // Method remove events
    $('.method-remove').off('click').on('click', function() {
        deleteId = $(this).data('method-id');
        deleteData = {
            name: $(this).data('method-name')
        };

        $('#method-name').text(deleteData.name);
    });
}

// Bulk toggle function for entire courier
function toggleAllCourier(courierCode, enabled) {
    $.ajax({
        url: "{{ route('seller.shipping.bulk-toggle') }}",
        method: 'POST',
        data: {
            _token: csrfToken,
            courier_code: courierCode,
            enabled: enabled ? 1 : 0
        },
        success: function(response) {
            if (response.success) {
                showToast(response.message, 'success');

                // Refresh page after 0.5 second to update all statistics and states
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            showToast(response?.message || 'Failed to toggle courier methods.', 'danger');

            // Revert toggle switch if it was changed
            const courierToggle = $(`.courier-toggle[data-courier-code="${courierCode}"]`);
            courierToggle.prop('checked', !enabled);
        }
    });
}

function addMethod(methodId, methodName, buttonElement) {
    $.ajax({
        url: "{{ route('seller.shipping.toggle') }}",
        method: 'POST',
        data: {
            _token: csrfToken,
            shipping_method_id: methodId,
            enabled: 1
        },
        success: function(response) {
            if (response.success) {
                showToast(response.message, 'success');

                // Update button to toggle switch
                const methodCard = buttonElement.closest('.method-card');
                const actionContainer = methodCard.find('.flex-shrink-0');
                actionContainer.html(`
                    <div class="form-check form-switch me-2">
                        <input class="form-check-input method-toggle"
                               type="checkbox"
                               data-method-id="${methodId}"
                               data-method-name="${methodName.split(' - ')[1]}"
                               checked>
                    </div>`);

                // Update status badge
                methodCard.find('.badge').last().removeClass('bg-secondary').addClass('bg-success').text('Active');

                // Re-initialize feather icons and rebind events
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
                bindModalEvents();

                // Refresh page after 1 second to update statistics
                // setTimeout(() => {
                //     window.location.reload();
                // }, 1000);
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            showToast(response?.message || 'Failed to add shipping method.', 'danger');
        }
    });
}

function toggleMethodStatus(methodId, methodName, isEnabled, toggleElement) {
    $.ajax({
        url: "{{ route('seller.shipping.toggle') }}",
        method: 'POST',
        data: {
            _token: csrfToken,
            shipping_method_id: methodId,
            enabled: isEnabled ? 1 : 0
        },
        success: function(response) {
            if (response.success) {
                showToast(response.message, 'success');

                // Update status badge
                const methodCard = toggleElement.closest('.method-card');
                const statusBadge = methodCard.find('.badge').last();

                if (isEnabled) {
                    statusBadge.removeClass('bg-warning').addClass('bg-success').text('Active');
                } else {
                    statusBadge.removeClass('bg-success').addClass('bg-warning').text('Inactive');
                }

                // Refresh page after 1 second to update statistics
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            showToast(response?.message || 'Failed to toggle shipping method.', 'danger');

            // Revert toggle
            toggleElement.prop('checked', !isEnabled);
        }
    });
}

function showToast(message, type = 'success') {
    const toastId = 'toast-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>`;

    $('#toast-container').append(toastHtml);

    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        delay: 3000
    });

    toast.show();

    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}
</script>
@endpush

