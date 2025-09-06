@extends('layouts.admin.main')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Service Fees Management</h4>
                            <div class="text-muted">
                                <i class="ri-information-line"></i>
                                Configure payment processing fees for the marketplace
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <!-- Fee Type Overview -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h6 class="text-white">Current Fee Type</h6>
                                            <h4 class="text-white mb-0">
                                                {{ ucfirst($paymentFees['payment_fee_type']['value']) }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h6 class="text-white">Percentage Rate</h6>
                                            <h4 class="text-white mb-0">
                                                {{ $paymentFees['payment_fee_percent']['value'] }}%
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h6 class="text-white">Fixed Amount</h6>
                                            <h4 class="text-white mb-0">
                                                IDR {{ number_format($paymentFees['payment_fee_fixed']['value']) }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fee Configuration -->
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3">Fee Configuration</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 25%">Setting</th>
                                                    <th style="width: 40%">Description</th>
                                                    <th style="width: 20%">Current Value</th>
                                                    <th style="width: 15%" class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($paymentFees as $key => $fee)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $fee['label'] }}</strong>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $fee['description'] }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary" id="value-display-{{ $key }}">
                                                            @if($fee['type'] === 'select')
                                                                {{ $fee['options'][$fee['value']] ?? $fee['value'] }}
                                                            @else
                                                                @if(isset($fee['prefix'])){{ $fee['prefix'] }} @endif
                                                                {{ $fee['value'] ?? 'Not set' }}
                                                                @if(isset($fee['suffix'])){{ $fee['suffix'] }}@endif
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-primary edit-fee-btn" 
                                                                data-key="{{ $key }}"
                                                                data-label="{{ $fee['label'] }}"
                                                                data-type="{{ $fee['type'] }}"
                                                                data-value="{{ $fee['value'] }}"
                                                                data-description="{{ $fee['description'] }}"
                                                                @if(isset($fee['options']))
                                                                data-options="{{ json_encode($fee['options']) }}"
                                                                @endif
                                                                @if(isset($fee['min']))data-min="{{ $fee['min'] }}"@endif
                                                                @if(isset($fee['max']))data-max="{{ $fee['max'] }}"@endif
                                                                @if(isset($fee['step']))data-step="{{ $fee['step'] }}"@endif
                                                                @if(isset($fee['prefix']))data-prefix="{{ $fee['prefix'] }}"@endif
                                                                @if(isset($fee['suffix']))data-suffix="{{ $fee['suffix'] }}"@endif
                                                                title="Edit {{ $fee['label'] }}">
                                                            <i class="ri-edit-line"></i> Edit
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Fee Calculation Preview -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="mb-3">Fee Calculation Preview</h5>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Test Amount (IDR)</label>
                                                        <input type="number" id="testAmount" class="form-control" value="100000" min="0" step="1000">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Calculated Fee</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">IDR</span>
                                                            <input type="text" id="calculatedFee" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                Enter an amount above to see how the current fee configuration would be applied.
                                            </small>
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

<!-- Edit Fee Modal -->
<div class="modal fade" id="editFeeModal" tabindex="-1" aria-labelledby="editFeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFeeModalLabel">Edit Service Fee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFeeForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" id="feeLabel">Setting Name</label>
                        <p class="text-muted" id="feeDescription">Setting description</p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="feeValue" class="form-label">Value</label>
                        <div id="feeInputContainer">
                            <!-- Dynamic input will be inserted here -->
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="alert alert-info">
                        <i class="ri-information-line"></i>
                        <strong>Note:</strong> Changes to service fees will affect all future transactions.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> Update Fee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('head')
<style>
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.input-group-text {
    background-color: #e9ecef;
    border-color: #ced4da;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let currentFeeKey = null;
    
    // Fee calculation preview
    function calculatePreviewFee() {
        const amount = parseFloat($('#testAmount').val()) || 0;
        const feeType = '{{ $paymentFees["payment_fee_type"]["value"] }}';
        let calculatedFee = 0;
        
        if (feeType === 'percent') {
            const percent = {{ $paymentFees['payment_fee_percent']['value'] }};
            const minValue = {{ $paymentFees['payment_fee_percent_min_value']['value'] ?? 0 }};
            const maxValue = {{ $paymentFees['payment_fee_percent_max_value']['value'] ?? 'null' }};
            
            calculatedFee = (amount * percent) / 100;
            
            if (calculatedFee < minValue) {
                calculatedFee = minValue;
            }
            
            if (maxValue !== null && calculatedFee > maxValue) {
                calculatedFee = maxValue;
            }
        } else {
            calculatedFee = {{ $paymentFees['payment_fee_fixed']['value'] }};
        }
        
        $('#calculatedFee').val(new Intl.NumberFormat('id-ID').format(calculatedFee));
    }
    
    // Calculate preview on amount change
    $('#testAmount').on('input', calculatePreviewFee);
    
    // Initial calculation
    calculatePreviewFee();
    
    // Edit fee button click
    $('.edit-fee-btn').on('click', function() {
        const data = $(this).data();
        currentFeeKey = data.key;
        
        $('#feeLabel').text(data.label);
        $('#feeDescription').text(data.description);
        
        // Build input based on type
        let inputHtml = '';
        
        if (data.type === 'select') {
            inputHtml = '<select class="form-select" id="feeValue" name="value" required>';
            const options = JSON.parse($(this).attr('data-options'));
            for (const [value, label] of Object.entries(options)) {
                const selected = value === data.value ? 'selected' : '';
                inputHtml += `<option value="${value}" ${selected}>${label}</option>`;
            }
            inputHtml += '</select>';
        } else if (data.type === 'number') {
            const prefix = data.prefix || '';
            const suffix = data.suffix || '';
            const min = data.min || '';
            const max = data.max || '';
            const step = data.step || 'any';
            
            inputHtml = '<div class="input-group">';
            if (prefix) {
                inputHtml += `<span class="input-group-text">${prefix}</span>`;
            }
            inputHtml += `<input type="number" class="form-control" id="feeValue" name="value" value="${data.value || ''}" `;
            if (min) inputHtml += `min="${min}" `;
            if (max) inputHtml += `max="${max}" `;
            if (step) inputHtml += `step="${step}" `;
            inputHtml += '>';
            if (suffix) {
                inputHtml += `<span class="input-group-text">${suffix}</span>`;
            }
            inputHtml += '</div>';
        } else {
            inputHtml = `<input type="text" class="form-control" id="feeValue" name="value" value="${data.value || ''}" required>`;
        }
        
        $('#feeInputContainer').html(inputHtml);
        $('#editFeeModal').modal('show');
    });
    
    // Handle form submission
    $('#editFeeForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!currentFeeKey) return;
        
        const formData = {
            value: $('#feeValue').val(),
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: 'PUT'
        };
        
        $.ajax({
            url: `/admin/service-fees/${currentFeeKey}`,
            method: 'POST',
            data: formData,
            beforeSend: function() {
                $('#editFeeForm button[type="submit"]').prop('disabled', true);
                $('#feeValue').removeClass('is-invalid');
            },
            success: function(response) {
                $('#editFeeModal').modal('hide');
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
                if (response.errors && response.errors.value) {
                    $('#feeValue').addClass('is-invalid');
                    $('.invalid-feedback').text(response.errors.value[0]);
                } else if (response.message) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while updating the service fee.'
                    });
                }
            },
            complete: function() {
                $('#editFeeForm button[type="submit"]').prop('disabled', false);
            }
        });
    });
    
    // Clear validation errors when typing
    $(document).on('input', '#feeValue', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush
