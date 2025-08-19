@extends('layouts.seller.main')

@section('title', 'KYC Verification Status')

@section('content')
    <!--=== Start Section Title Area ===-->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">KYC Verification Status</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">KYC Verification</li>
            </ol>
        </nav>
    </div>
    <!--=== End Section Title Area ===-->

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">KYC Verification Status</h4>
                    @if(!$hasApprovedKyc && !$latestApplication?->whereIn('status', ['pending', 'under_review'])->count())
                    <a href="{{ route('kyc.create') }}" class="btn btn-primary">
                        <i class="ri-add-line"></i> Start KYC Verification
                    </a>
                    @endif
                </div>

                <div class="card-body">
                    @if ($hasApprovedKyc)
                        <div class="alert alert-success">
                            <i class="ri-check-line"></i>
                            <strong>Congratulations!</strong> Your KYC verification has been approved. You can now set up your shop.
                            <div class="mt-2">
                                <a href="{{ route('seller.shop.setup') }}" class="btn btn-success btn-sm">
                                    <i class="ri-store-line"></i> Set Up Your Shop
                                </a>
                            </div>
                        </div>
                    @elseif($latestApplication && in_array($latestApplication->status, ['pending', 'under_review']))
                        <div class="alert alert-info">
                            <i class="ri-time-line"></i>
                            <strong>Application Under Review</strong><br>
                            Your KYC application is currently being reviewed. This process typically takes 3-5 business days.
                            <div class="mt-2">
                                <small class="text-muted">
                                    Application ID: {{ $latestApplication->id }}<br>
                                    Status: {{ $latestApplication->status_label }}<br>
                                    Submitted: {{ $latestApplication->created_at->format('M d, Y \a\t H:i') }}
                                </small>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="ri-alert-line"></i>
                            <strong>KYC Verification Required</strong><br>
                            You need to complete KYC (Know Your Customer) verification before you can set up your shop and start selling.
                        </div>
                    @endif

                    @if($kycApplications->count() > 0)
                        <h5 class="mt-4">Application History</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Application ID</th>
                                        <th>Status</th>
                                        <th>Submitted</th>
                                        <th>Reviewed</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kycApplications as $application)
                                    <tr>
                                        <td>
                                            <code>{{ substr($application->id, 0, 8) }}...</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $application->status_badge }}">
                                                {{ $application->status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $application->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            @if($application->reviewed_at)
                                                {{ $application->reviewed_at->format('M d, Y H:i') }}
                                            @else
                                                <span class="text-muted">Not reviewed</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('kyc.show', $application) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="ri-eye-line"></i> View
                                            </a>
                                            @if($application->status === 'rejected')
                                            <a href="{{ route('kyc.reapply', $application) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="ri-refresh-line"></i> Reapply
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if(!$hasApprovedKyc)
                        <div class="mt-4">
                            <h6>Required Documents</h6>
                            <ul class="list-unstyled">
                                <li><i class="ri-check-line text-success"></i> Government-issued photo ID (National ID, Passport, or Driving License)</li>
                                <li><i class="ri-check-line text-success"></i> Clear selfie holding your ID document</li>
                                <li><i class="ri-check-line text-success"></i> Personal information matching your ID</li>
                            </ul>
                            
                            <div class="alert alert-info">
                                <i class="ri-information-line"></i>
                                <strong>Important Notes:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>All documents must be clear and readable</li>
                                    <li>Information provided must match your ID documents exactly</li>
                                    <li>Review process typically takes 3-5 business days</li>
                                    <li>You will be notified via email once your application is reviewed</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
