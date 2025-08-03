@extends('layouts.seller.main')

@section('title', 'Security Settings - Seller Dashboard')

@section('content')
<!--=== Start Section Title Area ===-->
<div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
    <h4 class="text-dark mb-0">Security Settings</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.profile.index') }}">Profile</a></li>
            <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Security</li>
        </ol>
    </nav>
</div>
<!--=== End Section Title Area ===-->

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6>Please fix the following errors:</h6>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <!-- Change Password Card -->
    <div class="col-lg-6 mb-24">
        <div class="card rounded-3 border-0 h-100">
            <div class="card-body p-25">
                <div class="card-title mb-20 pb-20 border-bottom border-color">
                    <h4 class="mb-0">Change Password</h4>
                    <p class="text-muted fs-14 mb-0">Update your account login password</p>
                </div>

                <form action="{{ route('seller.profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-25">
                        <label class="fw-semibold fs-14 text-dark mb-2">Current Password<span class="text-danger">*</span></label>
                        <div class="form-floating position-relative">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   name="current_password" id="current_password" 
                                   placeholder="Enter Current Password" required>
                            <label class="text-body fs-12" for="current_password">Enter Current Password</label>
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-3 border-0" 
                                    onclick="togglePassword('current_password')">
                                <i data-feather="eye" class="w-16 h-16"></i>
                            </button>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-25">
                        <label class="fw-semibold fs-14 text-dark mb-2">New Password<span class="text-danger">*</span></label>
                        <div class="form-floating position-relative">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" id="new_password" 
                                   placeholder="Enter New Password" required>
                            <label class="text-body fs-12" for="new_password">Enter New Password</label>
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-3 border-0" 
                                    onclick="togglePassword('new_password')">
                                <i data-feather="eye" class="w-16 h-16"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-25">
                        <label class="fw-semibold fs-14 text-dark mb-2">Confirm New Password<span class="text-danger">*</span></label>
                        <div class="form-floating position-relative">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   name="password_confirmation" id="password_confirmation" 
                                   placeholder="Confirm New Password" required>
                            <label class="text-body fs-12" for="password_confirmation">Confirm New Password</label>
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-3 border-0" 
                                    onclick="togglePassword('password_confirmation')">
                                <i data-feather="eye" class="w-16 h-16"></i>
                            </button>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Password</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Security Information Card -->
    <div class="col-lg-6 mb-24">
        <div class="card rounded-3 border-0 h-100">
            <div class="card-body p-25">
                <div class="card-title mb-20 pb-20 border-bottom border-color">
                    <h4 class="mb-0">Security Information</h4>
                    <p class="text-muted fs-14 mb-0">Account security details</p>
                </div>

                <div class="security-info">
                    <div class="security-item d-flex justify-content-between align-items-center mb-20 pb-20 border-bottom border-color">
                        <div>
                            <h6 class="mb-1">Password Last Changed</h6>
                            <p class="text-muted fs-14 mb-0">
                                @if($user->password_changed_at)
                                    {{ $user->password_changed_at->format('M d, Y - H:i') }}
                                @else
                                    Never changed
                                @endif
                            </p>
                        </div>
                        <i data-feather="shield" class="text-success w-20 h-20"></i>
                    </div>

                    <div class="security-item d-flex justify-content-between align-items-center mb-20 pb-20 border-bottom border-color">
                        <div>
                            <h6 class="mb-1">Account Created</h6>
                            <p class="text-muted fs-14 mb-0">{{ $user->created_at->format('M d, Y - H:i') }}</p>
                        </div>
                        <i data-feather="calendar" class="text-info w-20 h-20"></i>
                    </div>

                    <div class="security-item d-flex justify-content-between align-items-center mb-20 pb-20 border-bottom border-color">
                        <div>
                            <h6 class="mb-1">Email Verification</h6>
                            <p class="text-muted fs-14 mb-0">
                                @if($user->email_verified_at)
                                    <span class="text-success">Verified</span>
                                @else
                                    <span class="text-warning">Not Verified</span>
                                @endif
                            </p>
                        </div>
                        @if($user->email_verified_at)
                            <i data-feather="check-circle" class="text-success w-20 h-20"></i>
                        @else
                            <i data-feather="alert-circle" class="text-warning w-20 h-20"></i>
                        @endif
                    </div>

                    <div class="security-item d-flex justify-content-between align-items-center mb-20">
                        <div>
                            <h6 class="mb-1">Withdrawal PIN</h6>
                            <p class="text-muted fs-14 mb-0">
                                @if($user->hasWithdrawalPin())
                                    <span class="text-success">Setup Complete</span>
                                @else
                                    <span class="text-warning">Not Setup</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            @if($user->hasWithdrawalPin())
                                <i data-feather="lock" class="text-success w-20 h-20"></i>
                            @else
                                <i data-feather="unlock" class="text-warning w-20 h-20"></i>
                            @endif
                        </div>
                    </div>

                    <div class="text-center mt-25">
                        <a href="{{ route('seller.profile.withdrawal-pin') }}" 
                           class="btn {{ $user->hasWithdrawalPin() ? 'btn-outline-primary' : 'btn-warning' }} w-100">
                            @if($user->hasWithdrawalPin())
                                Manage Withdrawal PIN
                            @else
                                Setup Withdrawal PIN
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Security Tips Card -->
<div class="card rounded-3 border-0 mb-24">
    <div class="card-body p-25">
        <div class="card-title mb-20 pb-20 border-bottom border-color">
            <h4 class="mb-0">Security Tips</h4>
            <p class="text-muted fs-14 mb-0">Keep your account secure with these recommendations</p>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="d-flex align-items-start">
                    <i data-feather="shield" class="text-success w-20 h-20 mt-1 me-3"></i>
                    <div>
                        <h6 class="mb-1">Use Strong Passwords</h6>
                        <p class="text-muted fs-14 mb-0">Use a combination of letters, numbers, and special characters</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-3">
                <div class="d-flex align-items-start">
                    <i data-feather="lock" class="text-success w-20 h-20 mt-1 me-3"></i>
                    <div>
                        <h6 class="mb-1">Setup Withdrawal PIN</h6>
                        <p class="text-muted fs-14 mb-0">Protect your financial transactions with a 6-digit PIN</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-3">
                <div class="d-flex align-items-start">
                    <i data-feather="refresh-cw" class="text-success w-20 h-20 mt-1 me-3"></i>
                    <div>
                        <h6 class="mb-1">Regular Updates</h6>
                        <p class="text-muted fs-14 mb-0">Change your password and PIN regularly for better security</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-3">
                <div class="d-flex align-items-start">
                    <i data-feather="eye-off" class="text-success w-20 h-20 mt-1 me-3"></i>
                    <div>
                        <h6 class="mb-1">Keep Credentials Secret</h6>
                        <p class="text-muted fs-14 mb-0">Never share your password or PIN with anyone</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.nextElementSibling.nextElementSibling.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.setAttribute('data-feather', 'eye-off');
    } else {
        field.type = 'password';
        icon.setAttribute('data-feather', 'eye');
    }
    
    // Re-initialize feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}
</script>
@endpush
@endsection
