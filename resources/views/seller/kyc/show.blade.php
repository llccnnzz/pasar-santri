@extends('layouts.seller.main')

@section('title', 'KYC Application Details')

@section('content')
    <!--=== Start Section Title Area ===-->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">KYC Application Details</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('kyc.index') }}">KYC Verification</a></li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Application Details</li>
            </ol>
        </nav>
    </div>
    <!--=== End Section Title Area ===-->

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">KYC Application Details</h4>
                        <small class="text-muted">Application ID: {{ $kyc->id }}</small>
                    </div>
                    <span class="badge badge-{{ $kyc->status_badge }} badge-lg">
                        {{ $kyc->status_label }}
                    </span>
                </div>

                <div class="card-body">
                    @if($kyc->status === 'rejected' && $kyc->rejection_reason)
                        <div class="alert alert-danger">
                            <h6><i class="ri-alert-line"></i> Application Rejected</h6>
                            <strong>Reason:</strong> {{ $kyc->rejection_reason }}
                            @if($kyc->admin_notes)
                                <br><strong>Admin Notes:</strong> {{ $kyc->admin_notes }}
                            @endif
                            <div class="mt-2">
                                <a href="{{ route('kyc.reapply', $kyc) }}" class="btn btn-warning btn-sm">
                                    <i class="ri-refresh-line"></i> Reapply
                                </a>
                            </div>
                        </div>
                    @elseif($kyc->status === 'approved')
                        <div class="alert alert-success">
                            <i class="ri-check-line"></i>
                            <strong>Application Approved!</strong> Your KYC verification has been approved successfully.
                            @if($kyc->admin_notes)
                                <br><strong>Admin Notes:</strong> {{ $kyc->admin_notes }}
                            @endif
                        </div>
                    @elseif($kyc->status === 'under_review')
                        <div class="alert alert-info">
                            <i class="ri-time-line"></i>
                            <strong>Under Review</strong> Your application is currently being reviewed by our team.
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="ri-hourglass-line"></i>
                            <strong>Pending Review</strong> Your application is in queue for review.
                        </div>
                    @endif

                    <!-- Personal Information -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Personal Information</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Full Name</label>
                                <p class="form-control-plaintext">{{ $kyc->full_name }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Date of Birth</label>
                                <p class="form-control-plaintext">{{ $kyc->date_of_birth->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Gender</label>
                                <p class="form-control-plaintext">{{ ucfirst($kyc->gender) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Nationality</label>
                                <p class="form-control-plaintext">{{ $kyc->nationality }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Phone Number</label>
                                <p class="form-control-plaintext">{{ $kyc->phone }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Address Information</h5>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Street Address</label>
                        <p class="form-control-plaintext">{{ $kyc->address }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">City</label>
                                <p class="form-control-plaintext">{{ $kyc->city }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">State/Province</label>
                                <p class="form-control-plaintext">{{ $kyc->state }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Postal Code</label>
                                <p class="form-control-plaintext">{{ $kyc->postal_code }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Country</label>
                        <p class="form-control-plaintext">{{ $kyc->country }}</p>
                    </div>

                    <!-- Document Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Identity Document</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Document Type</label>
                                <p class="form-control-plaintext">{{ $kyc->getDocumentTypeLabel() }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Document Number</label>
                                <p class="form-control-plaintext">{{ $kyc->document_number }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Document Expiry Date</label>
                                <p class="form-control-plaintext">{{ $kyc->document_expiry_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Issued Country</label>
                                <p class="form-control-plaintext">{{ $kyc->document_issued_country }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Document Images -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Uploaded Documents</h5>
                        </div>
                    </div>

                    <div class="row">
                        @if($kyc->getFirstMedia('document_front'))
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Document Front</label>
                                <div class="card">
                                    <img src="{{ $kyc->getFirstMediaUrl('document_front', 'preview') }}" 
                                         class="card-img-top" alt="Document Front" style="height: 200px; object-fit: cover;">
                                    <div class="card-body p-2">
                                        <a href="{{ $kyc->getFirstMediaUrl('document_front') }}" 
                                           target="_blank" class="btn btn-sm btn-outline-primary btn-block">
                                            <i class="ri-expand-diagonal-line"></i> View Full Size
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($kyc->getFirstMedia('document_back'))
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Document Back</label>
                                <div class="card">
                                    <img src="{{ $kyc->getFirstMediaUrl('document_back', 'preview') }}" 
                                         class="card-img-top" alt="Document Back" style="height: 200px; object-fit: cover;">
                                    <div class="card-body p-2">
                                        <a href="{{ $kyc->getFirstMediaUrl('document_back') }}" 
                                           target="_blank" class="btn btn-sm btn-outline-primary btn-block">
                                            <i class="ri-expand-diagonal-line"></i> View Full Size
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($kyc->getFirstMedia('selfie'))
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Selfie with Document</label>
                                <div class="card">
                                    <img src="{{ $kyc->getFirstMediaUrl('selfie', 'preview') }}" 
                                         class="card-img-top" alt="Selfie" style="height: 200px; object-fit: cover;">
                                    <div class="card-body p-2">
                                        <a href="{{ $kyc->getFirstMediaUrl('selfie') }}" 
                                           target="_blank" class="btn btn-sm btn-outline-primary btn-block">
                                            <i class="ri-expand-diagonal-line"></i> View Full Size
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($kyc->getMedia('additional_docs')->count() > 0)
                    <div class="row">
                        <div class="col-12">
                            <h6>Additional Documents</h6>
                        </div>
                        @foreach($kyc->getMedia('additional_docs') as $media)
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="card">
                                    @if(str_contains($media->mime_type, 'image'))
                                        <img src="{{ $media->getUrl('preview') }}" 
                                             class="card-img-top" alt="Additional Document" style="height: 150px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 150px; background-color: #f8f9fa;">
                                            <i class="ri-file-pdf-line" style="font-size: 3rem; color: #6c757d;"></i>
                                        </div>
                                    @endif
                                    <div class="card-body p-2">
                                        <a href="{{ $media->getUrl() }}" 
                                           target="_blank" class="btn btn-sm btn-outline-primary btn-block">
                                            <i class="ri-download-line"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Application Timeline -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Application Timeline</h5>
                        </div>
                    </div>

                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6>Application Submitted</h6>
                                <p class="text-muted mb-0">{{ $kyc->created_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                        </div>

                        @if($kyc->status !== 'pending')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6>Under Review</h6>
                                <p class="text-muted mb-0">Application moved to review queue</p>
                            </div>
                        </div>
                        @endif

                        @if($kyc->reviewed_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-{{ $kyc->status === 'approved' ? 'success' : 'danger' }}"></div>
                            <div class="timeline-content">
                                <h6>{{ $kyc->status === 'approved' ? 'Approved' : 'Rejected' }}</h6>
                                <p class="text-muted mb-0">{{ $kyc->reviewed_at->format('M d, Y \a\t H:i') }}</p>
                                @if($kyc->reviewer)
                                    <small class="text-muted">Reviewed by: {{ $kyc->reviewer->name }}</small>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('kyc.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back to KYC
                        </a>
                        @if($kyc->status === 'rejected')
                        <a href="{{ route('kyc.reapply', $kyc) }}" class="btn btn-warning">
                            <i class="ri-refresh-line"></i> Reapply
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    border-left: 3px solid #007bff;
}

.badge-lg {
    font-size: 0.9em;
    padding: 0.5em 0.75em;
}
</style>
@endsection
