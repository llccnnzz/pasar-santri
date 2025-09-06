@extends('layouts.admin.main')

@section('title', 'KYC Application Details')

@section('content')
<!--=== Start KYC Application Details Area ===-->
<div class="row">
    <div class="col-lg-8">
        <!-- Application Info -->
        <div class="card border-0 rounded-3 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Application Information</h4>
                <div>
                    <span class="badge bg-{{ $kycApplication->status_badge }} fs-12">{{ $kycApplication->status_text }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">First Name</label>
                            <p class="mb-0 fw-medium">{{ $kycApplication->first_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Last Name</label>
                            <p class="mb-0 fw-medium">{{ $kycApplication->last_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Date of Birth</label>
                            <p class="mb-0 fw-medium">{{ $kycApplication->date_of_birth ? $kycApplication->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Phone Number</label>
                            <p class="mb-0 fw-medium">{{ $kycApplication->phone_number ?: 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label text-muted">Address</label>
                            <p class="mb-0 fw-medium">{{ $kycApplication->address ?: 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Information -->
        <div class="card border-0 rounded-3 mb-4">
            <div class="card-header">
                <h4 class="mb-0">Document Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Document Type</label>
                            <p class="mb-0 fw-medium">
                                <span class="badge bg-secondary">{{ ucwords(str_replace('_', ' ', $kycApplication->document_type)) }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Document Number</label>
                            <p class="mb-0 fw-medium">{{ $kycApplication->document_number }}</p>
                        </div>
                    </div>
                    @if($kycApplication->document_expiry_date)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Expiry Date</label>
                            <p class="mb-0 fw-medium">{{ $kycApplication->document_expiry_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Document Images -->
        <div class="card border-0 rounded-3 mb-4">
            <div class="card-header">
                <h4 class="mb-0">Document Files</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($kycApplication->getFirstMediaUrl('document_front'))
                    <div class="col-md-6 mb-4">
                        <h6 class="mb-2">Document Front</h6>
                        <div class="document-preview">
                            <img src="{{ $kycApplication->getFirstMediaUrl('document_front') }}"
                                 class="img-fluid rounded border"
                                 alt="Document Front"
                                 style="max-height: 200px; cursor: pointer;"
                                 onclick="showImageModal(this.src, 'Document Front')">
                        </div>
                    </div>
                    @endif

                    @if($kycApplication->getFirstMediaUrl('document_back'))
                    <div class="col-md-6 mb-4">
                        <h6 class="mb-2">Document Back</h6>
                        <div class="document-preview">
                            <img src="{{ $kycApplication->getFirstMediaUrl('document_back') }}"
                                 class="img-fluid rounded border"
                                 alt="Document Back"
                                 style="max-height: 200px; cursor: pointer;"
                                 onclick="showImageModal(this.src, 'Document Back')">
                        </div>
                    </div>
                    @endif

                    @if($kycApplication->getFirstMediaUrl('selfie'))
                    <div class="col-md-6 mb-4">
                        <h6 class="mb-2">Selfie with Document</h6>
                        <div class="document-preview">
                            <img src="{{ $kycApplication->getFirstMediaUrl('selfie') }}"
                                 class="img-fluid rounded border"
                                 alt="Selfie"
                                 style="max-height: 200px; cursor: pointer;"
                                 onclick="showImageModal(this.src, 'Selfie with Document')">
                        </div>
                    </div>
                    @endif

                    @if($kycApplication->getMedia('additional_docs')->count() > 0)
                    <div class="col-12">
                        <h6 class="mb-2">Additional Documents</h6>
                        <div class="row">
                            @foreach($kycApplication->getMedia('additional_docs') as $media)
                            <div class="col-md-4 mb-3">
                                <div class="document-preview">
                                    <img src="{{ $media->getUrl() }}"
                                         class="img-fluid rounded border"
                                         alt="Additional Document"
                                         style="max-height: 150px; cursor: pointer;"
                                         onclick="showImageModal(this.src, 'Additional Document')">
                                    <small class="d-block mt-1 text-muted">{{ $media->name }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                @if(!$kycApplication->getFirstMediaUrl('document_front') && !$kycApplication->getFirstMediaUrl('document_back') && !$kycApplication->getFirstMediaUrl('selfie'))
                <div class="text-center py-4">
                    <i data-feather="image" class="mb-2" style="width: 48px; height: 48px;" stroke="1.5"></i>
                    <p class="text-muted mb-0">No documents uploaded</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Timeline -->
        @if($kycApplication->reviewed_at || $kycApplication->admin_notes || $kycApplication->rejection_reason)
        <div class="card border-0 rounded-3 mb-4">
            <div class="card-header">
                <h4 class="mb-0">Application Timeline</h4>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Application Submitted</h6>
                            <p class="text-muted mb-0">{{ $kycApplication->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>

                    @if($kycApplication->reviewed_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-{{ $kycApplication->status === 'approved' ? 'success' : 'danger' }}"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Application {{ ucfirst($kycApplication->status) }}</h6>
                            <p class="text-muted mb-1">{{ $kycApplication->reviewed_at->format('M d, Y \a\t g:i A') }}</p>
                            @if($kycApplication->reviewer)
                                <small class="text-muted">by {{ $kycApplication->reviewer->name }}</small>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- User Information -->
        <div class="card border-0 rounded-3 mb-4">
            <div class="card-header">
                <h4 class="mb-0">User Information</h4>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                        <i data-feather="user" class="text-white" style="width: 32px; height: 32px;"></i>
                    </div>
                    <h5 class="mt-3 mb-1">{{ $kycApplication->user->name }}</h5>
                    <p class="text-muted mb-2">{{ $kycApplication->user->email }}</p>
                    @foreach($kycApplication->user->roles as $role)
                        <span class="badge bg-primary me-1">{{ ucfirst($role->name) }}</span>
                    @endforeach
                </div>

                <div class="border-top pt-3">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="mb-2">
                                <h6 class="mb-0">{{ $kycApplication->user->created_at->format('M d, Y') }}</h6>
                                <small class="text-muted">Member Since</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <h6 class="mb-0">{{ $kycApplication->user->created_at->diffForHumans() }}</h6>
                                <small class="text-muted">Last Active</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Status Actions -->
        @if($kycApplication->status === 'pending')
        <div class="card border-0 rounded-3 mb-4">
            <div class="card-header">
                <h4 class="mb-0">Review Actions</h4>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-success" onclick="approveKyc('{{ $kycApplication->id }}', '{{ $kycApplication->full_name }}')">
                        <i data-feather="check" class="me-2"></i>
                        Approve Application
                    </button>
                    <button class="btn btn-danger" onclick="rejectKyc('{{ $kycApplication->id }}', '{{ $kycApplication->full_name }}')">
                        <i data-feather="x" class="me-2"></i>
                        Reject Application
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- Review Information -->
        @if($kycApplication->admin_notes || $kycApplication->rejection_reason)
        <div class="card border-0 rounded-3 mb-4">
            <div class="card-header">
                <h4 class="mb-0">Review Information</h4>
            </div>
            <div class="card-body">
                @if($kycApplication->rejection_reason)
                <div class="mb-3">
                    <label class="form-label text-muted">Rejection Reason</label>
                    <div class="alert alert-danger">
                        {{ $kycApplication->rejection_reason }}
                    </div>
                </div>
                @endif

                @if($kycApplication->admin_notes)
                <div class="mb-3">
                    <label class="form-label text-muted">Admin Notes</label>
                    <div class="bg-light p-3 rounded">
                        {{ $kycApplication->admin_notes }}
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="card border-0 rounded-3">
            <div class="card-header">
                <h4 class="mb-0">Quick Actions</h4>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.kyc.index') }}" class="btn btn-outline-primary">
                        <i data-feather="arrow-left" class="me-2"></i>
                        Back to List
                    </a>
                    <a href="mailto:{{ $kycApplication->user->email }}" class="btn btn-outline-secondary">
                        <i data-feather="mail" class="me-2"></i>
                        Contact User
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalTitle">Document Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imageModalImage" src="" class="img-fluid" alt="Document">
            </div>
            <div class="modal-footer">
                <a id="imageDownloadLink" href="" download class="btn btn-outline-primary">
                    <i data-feather="download" class="me-2"></i>
                    Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
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
                        <br><small>This will grant them seller privileges.</small>
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

<!-- Reject Modal -->
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
<!--=== End KYC Application Details Area ===-->
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-left: 15px;
}

.document-preview img {
    transition: transform 0.2s;
}

.document-preview img:hover {
    transform: scale(1.05);
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    feather.replace();
});

function showImageModal(src, title) {
    $('#imageModalTitle').text(title);
    $('#imageModalImage').attr('src', src);
    $('#imageDownloadLink').attr('href', src);
    $('#imageModal').modal('show');
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
