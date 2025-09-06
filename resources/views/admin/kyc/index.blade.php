@extends('layouts.admin.main')

@section('title', 'KYC Applications Management')

@section('content')
<!--=== Start KYC Applications Area ===-->
<div class="card border-0 rounded-3 mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">KYC Applications Management</h2>
        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bulkActionModal">
                <i data-feather="layers"></i> Bulk Actions
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
                        <div class="icon rounded-3 bg-primary bg-opacity-10">
                            <i data-feather="file-text" class="text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Total</span>
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
                        <div class="icon rounded-3 bg-warning bg-opacity-10">
                            <i data-feather="clock" class="text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Pending</span>
                        <h4 class="fs-20 mb-0">{{ number_format($statistics['pending']) }}</h4>
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
                        <div class="icon rounded-3 bg-success bg-opacity-10">
                            <i data-feather="check-circle" class="text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Approved</span>
                        <h4 class="fs-20 mb-0">{{ number_format($statistics['approved']) }}</h4>
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
                        <div class="icon rounded-3 bg-danger bg-opacity-10">
                            <i data-feather="x-circle" class="text-danger"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <span class="d-block mb-1 text-muted">Rejected</span>
                        <h4 class="fs-20 mb-0">{{ number_format($statistics['rejected']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 rounded-3 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.kyc.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status Filter</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by name, email, document number..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i data-feather="search"></i> Filter
                </button>
                <a href="{{ route('admin.kyc.index') }}" class="btn btn-outline-secondary">
                    <i data-feather="refresh-cw"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- KYC Applications Table -->
<div class="card border-0 rounded-3">
    <div class="card-body">
        @if($kycApplications->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>Applicant</th>
                            <th>Document Type</th>
                            <th>Document Number</th>
                            <th>Status</th>
                            <th>Applied Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kycApplications as $kyc)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input kyc-checkbox" type="checkbox" value="{{ $kyc->id }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i data-feather="user" class="text-white" style="width: 18px; height: 18px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">{{ $kyc->full_name }}</h6>
                                            <small class="text-muted">{{ $kyc->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucwords(str_replace('_', ' ', $kyc->document_type)) }}</span>
                                </td>
                                <td>{{ $kyc->document_number }}</td>
                                <td>
                                    <span class="badge bg-{{ $kyc->status_badge }}">{{ $kyc->status }}</span>
                                </td>
                                <td>{{ $kyc->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.kyc.show', $kyc) }}">
                                                    <i data-feather="eye" class="me-2" style="width: 14px; height: 14px;"></i>
                                                    View Details
                                                </a>
                                            </li>
                                            @if($kyc->status === 'pending')
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button class="dropdown-item text-success" onclick="approveKyc('{{ $kyc->id }}', '{{ $kyc->full_name }}')">
                                                        <i data-feather="check" class="me-2" style="width: 14px; height: 14px;"></i>
                                                        Approve
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-danger" onclick="rejectKyc('{{ $kyc->id }}', '{{ $kyc->full_name }}')">
                                                        <i data-feather="x" class="me-2" style="width: 14px; height: 14px;"></i>
                                                        Reject
                                                    </button>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($kycApplications->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted mb-0">
                            Showing {{ $kycApplications->firstItem() }} to {{ $kycApplications->lastItem() }} of {{ $kycApplications->total() }} results
                        </p>
                    </div>
                    <div>
                        {{ $kycApplications->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i data-feather="file-text" class="mb-3" style="width: 48px; height: 48px;" stroke="1.5"></i>
                <h5>No KYC Applications Found</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['status', 'search']))
                        No applications match your current filters.
                    @else
                        No KYC applications have been submitted yet.
                    @endif
                </p>
                @if(request()->hasAny(['status', 'search']))
                    <a href="{{ route('admin.kyc.index') }}" class="btn btn-outline-primary">Clear Filters</a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bulkActionForm" method="POST" action="{{ route('admin.kyc.bulk-action') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Action</label>
                        <select name="action" id="bulkAction" class="form-select" required>
                            <option value="">Choose action...</option>
                            <option value="approve">Approve Selected</option>
                            <option value="reject">Reject Selected</option>
                            <option value="delete">Delete Selected</option>
                        </select>
                    </div>

                    <div id="rejectionReasonField" class="mb-3" style="display: none;">
                        <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="3" placeholder="Please provide a reason for rejection..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="2" placeholder="Any additional notes..."></textarea>
                    </div>

                    <div class="selected-count">
                        <p class="text-muted mb-0">Selected: <span id="selectedCount">0</span> applications</p>
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

<!-- Individual Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve KYC Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-success">
                        <i data-feather="check-circle" class="me-2"></i>
                        You are about to approve KYC application for <strong id="approveUserName"></strong>.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Any notes about this approval..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i data-feather="check"></i> Approve Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Individual Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject KYC Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i data-feather="alert-triangle" class="me-2"></i>
                        You are about to reject KYC application for <strong id="rejectUserName"></strong>.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="3" placeholder="Please provide a clear reason for rejection..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="2" placeholder="Any additional notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i data-feather="x"></i> Reject Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--=== End KYC Applications Area ===-->
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Feather Icons
    feather.replace();

    // Select All Functionality
    $('#selectAll').change(function() {
        $('.kyc-checkbox').prop('checked', this.checked);
        updateSelectedCount();
    });

    $('.kyc-checkbox').change(function() {
        updateSelectedCount();

        // Update select all checkbox
        const totalCheckboxes = $('.kyc-checkbox').length;
        const checkedCheckboxes = $('.kyc-checkbox:checked').length;
        $('#selectAll').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        $('#selectAll').prop('checked', checkedCheckboxes === totalCheckboxes);
    });

    // Bulk Action Form
    $('#bulkAction').change(function() {
        const action = $(this).val();
        if (action === 'reject') {
            $('#rejectionReasonField').show();
            $('#rejectionReasonField textarea').prop('required', true);
        } else {
            $('#rejectionReasonField').hide();
            $('#rejectionReasonField textarea').prop('required', false);
        }
        updateBulkActionButton();
    });

    // Bulk Action Form Submission
    $('#bulkActionForm').submit(function(e) {
        const selectedIds = getSelectedIds();
        if (selectedIds.length === 0) {
            e.preventDefault();
            alert('Please select at least one application.');
            return;
        }

        // Add selected IDs to form
        selectedIds.forEach(id => {
            $(this).append(`<input type="hidden" name="kyc_ids[]" value="${id}">`);
        });

        // Confirm action
        const action = $('#bulkAction').val();
        const count = selectedIds.length;
        if (!confirm(`Are you sure you want to ${action} ${count} application(s)?`)) {
            e.preventDefault();
        }
    });
});

function updateSelectedCount() {
    const count = $('.kyc-checkbox:checked').length;
    $('#selectedCount').text(count);
    updateBulkActionButton();
}

function updateBulkActionButton() {
    const selectedCount = $('.kyc-checkbox:checked').length;
    const action = $('#bulkAction').val();
    $('#bulkActionSubmit').prop('disabled', selectedCount === 0 || !action);
}

function getSelectedIds() {
    return $('.kyc-checkbox:checked').map(function() {
        return $(this).val();
    }).get();
}

function approveKyc(id, name) {
    $('#approveUserName').text(name);
    $('#approveForm').attr('action', `/admin/kyc/${id}/approve`);
    $('#approveModal').modal('show');
}

function rejectKyc(id, name) {
    $('#rejectUserName').text(name);
    $('#rejectForm').attr('action', `/admin/kyc/${id}/reject`);
    $('#rejectModal').modal('show');
}
</script>
@endpush
