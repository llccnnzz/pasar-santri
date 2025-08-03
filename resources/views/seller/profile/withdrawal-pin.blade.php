@extends('layouts.seller.main')

@section('title', 'Withdrawal PIN - Seller Dashboard')

@section('content')
<!--=== Start Section Title Area ===-->
<div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
    <h4 class="text-dark mb-0">Withdrawal PIN Management</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.profile.index') }}">Profile</a></li>
            <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Withdrawal PIN</li>
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
    <!-- PIN Setup/Change Card -->
    <div class="col-lg-8">
        <div class="card rounded-3 border-0 mb-24">
            <div class="card-body p-25">
                <div class="card-title mb-20 pb-20 border-bottom border-color">
                    <h4 class="mb-0">
                        @if($user->hasWithdrawalPin())
                            Change Withdrawal PIN
                        @else
                            Setup Withdrawal PIN
                        @endif
                    </h4>
                    <p class="text-muted fs-14 mb-0">
                        @if($user->hasWithdrawalPin())
                            Update your 6-digit withdrawal PIN for secure transactions
                        @else
                            Create a 6-digit PIN to secure your withdrawal transactions
                        @endif
                    </p>
                </div>

                <form action="{{ route('seller.profile.withdrawal-pin.update') }}" method="POST" id="pinForm">
                    @csrf
                    @method('PUT')

                    @if($user->hasWithdrawalPin())
                    <div class="form-group mb-25">
                        <label class="fw-semibold fs-14 text-dark mb-2">Current PIN<span class="text-danger">*</span></label>
                        <div class="pin-input-group">
                            <input type="password" maxlength="6" class="form-control pin-input @error('current_pin') is-invalid @enderror" 
                                   name="current_pin" id="current_pin" placeholder="Enter current 6-digit PIN" 
                                   pattern="[0-9]{6}" required autocomplete="off">
                            @error('current_pin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @endif

                    <div class="form-group mb-25">
                        <label class="fw-semibold fs-14 text-dark mb-2">
                            @if($user->hasWithdrawalPin())
                                New PIN<span class="text-danger">*</span>
                            @else
                                Withdrawal PIN<span class="text-danger">*</span>
                            @endif
                        </label>
                        <div class="pin-input-group">
                            <input type="password" maxlength="6" class="form-control pin-input @error('withdrawal_pin') is-invalid @enderror" 
                                   name="withdrawal_pin" id="withdrawal_pin" placeholder="Enter 6-digit PIN" 
                                   pattern="[0-9]{6}" required autocomplete="off">
                            @error('withdrawal_pin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-25">
                        <label class="fw-semibold fs-14 text-dark mb-2">Confirm PIN<span class="text-danger">*</span></label>
                        <div class="pin-input-group">
                            <input type="password" maxlength="6" class="form-control pin-input @error('withdrawal_pin_confirmation') is-invalid @enderror" 
                                   name="withdrawal_pin_confirmation" id="withdrawal_pin_confirmation" 
                                   placeholder="Confirm 6-digit PIN" pattern="[0-9]{6}" required autocomplete="off">
                            @error('withdrawal_pin_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Account Password Verification -->
                    <div class="form-group mb-25">
                        <label class="fw-semibold fs-14 text-dark mb-2">Account Password<span class="text-danger">*</span></label>
                        <div class="form-floating position-relative">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" id="password" placeholder="Enter your account password" required>
                            <label class="text-body fs-12" for="password">Enter your account password to confirm</label>
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-3 border-0" 
                                    onclick="togglePassword('password')">
                                <i data-feather="eye" class="w-16 h-16"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-sm-flex justify-content-end text-center">
                        <button type="submit" class="btn btn-primary me-2">
                            @if($user->hasWithdrawalPin())
                                Update PIN
                            @else
                                Create PIN
                            @endif
                        </button>
                        <a href="{{ route('seller.profile.security') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PIN Information Card -->
    <div class="col-lg-4">
        <div class="card rounded-3 border-0 mb-24">
            <div class="card-body p-25">
                <div class="card-title mb-20 pb-20 border-bottom border-color">
                    <h4 class="mb-0">PIN Information</h4>
                </div>

                <div class="pin-status mb-20">
                    <div class="d-flex align-items-center mb-15">
                        @if($user->hasWithdrawalPin())
                            <i data-feather="check-circle" class="text-success w-20 h-20 me-2"></i>
                            <span class="text-success fw-semibold">PIN is Active</span>
                        @else
                            <i data-feather="alert-circle" class="text-warning w-20 h-20 me-2"></i>
                            <span class="text-warning fw-semibold">PIN Not Setup</span>
                        @endif
                    </div>

                    @if($user->hasWithdrawalPin() && $user->pin_last_changed_at)
                    <p class="text-muted fs-14 mb-0">
                        <strong>Last Changed:</strong><br>
                        {{ $user->pin_last_changed_at->format('M d, Y - H:i') }}
                    </p>
                    @endif
                </div>

                @if($user->hasWithdrawalPin())
                <div class="alert alert-info">
                    <div class="d-flex align-items-start">
                        <i data-feather="info" class="w-16 h-16 mt-1 me-2"></i>
                        <div>
                            <strong>Security Notice</strong>
                            <p class="mb-0 fs-14">Your withdrawal PIN is required for all payout transactions.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- PIN Verification Test -->
        @if($user->hasWithdrawalPin())
        <div class="card rounded-3 border-0 mb-24">
            <div class="card-body p-25">
                <div class="card-title mb-20 pb-20 border-bottom border-color">
                    <h4 class="mb-0">Test PIN</h4>
                    <p class="text-muted fs-14 mb-0">Verify your current PIN</p>
                </div>

                <form action="{{ route('seller.profile.verify-pin') }}" method="POST" id="verifyPinForm">
                    @csrf
                    
                    <div class="form-group mb-20">
                        <label class="fw-semibold fs-14 text-dark mb-2">Enter PIN</label>
                        <div class="pin-input-group">
                            <input type="password" maxlength="6" class="form-control pin-input" 
                                   name="test_pin" id="test_pin" placeholder="Enter 6-digit PIN" 
                                   pattern="[0-9]{6}" required autocomplete="off">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-outline-primary w-100">Verify PIN</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- PIN Security Guidelines -->
<div class="card rounded-3 border-0 mb-24">
    <div class="card-body p-25">
        <div class="card-title mb-20 pb-20 border-bottom border-color">
            <h4 class="mb-0">PIN Security Guidelines</h4>
            <p class="text-muted fs-14 mb-0">Follow these guidelines to keep your PIN secure</p>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="d-flex align-items-start">
                    <i data-feather="check" class="text-success w-16 h-16 mt-1 me-3"></i>
                    <div>
                        <h6 class="mb-1 text-success">Do</h6>
                        <ul class="text-muted fs-14 mb-0 ps-3">
                            <li>Use 6 unique digits</li>
                            <li>Choose numbers you can remember</li>
                            <li>Change PIN regularly</li>
                            <li>Keep PIN confidential</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-3">
                <div class="d-flex align-items-start">
                    <i data-feather="x" class="text-danger w-16 h-16 mt-1 me-3"></i>
                    <div>
                        <h6 class="mb-1 text-danger">Don't</h6>
                        <ul class="text-muted fs-14 mb-0 ps-3">
                            <li>Use sequential numbers (123456)</li>
                            <li>Use repeated digits (111111)</li>
                            <li>Share PIN with anyone</li>
                            <li>Write PIN down where others can see</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-warning mt-20">
            <div class="d-flex align-items-start">
                <i data-feather="alert-triangle" class="w-16 h-16 mt-1 me-2"></i>
                <div>
                    <strong>Important:</strong>
                    <p class="mb-0 fs-14">Your withdrawal PIN is separate from your account password and is specifically used for financial transactions. If you forget your PIN, you'll need to reset it using your account password.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // PIN input validation - only allow numbers
    const pinInputs = document.querySelectorAll('.pin-input');
    
    pinInputs.forEach(function(input) {
        input.addEventListener('input', function(e) {
            // Remove any non-numeric characters
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            
            // Limit to 6 digits
            if (e.target.value.length > 6) {
                e.target.value = e.target.value.slice(0, 6);
            }
        });

        input.addEventListener('keypress', function(e) {
            // Only allow numeric keys, backspace, delete, tab, escape, enter
            if (!/[0-9]/.test(e.key) && 
                !['Backspace', 'Delete', 'Tab', 'Escape', 'Enter'].includes(e.key)) {
                e.preventDefault();
            }
        });
    });

    // PIN confirmation validation
    const pinForm = document.getElementById('pinForm');
    if (pinForm) {
        pinForm.addEventListener('submit', function(e) {
            const pin = document.getElementById('withdrawal_pin').value;
            const confirmPin = document.getElementById('withdrawal_pin_confirmation').value;
            
            if (pin !== confirmPin) {
                e.preventDefault();
                alert('PIN and confirmation PIN do not match. Please try again.');
                return false;
            }
            
            if (pin.length !== 6) {
                e.preventDefault();
                alert('PIN must be exactly 6 digits.');
                return false;
            }
        });
    }

    // Verify PIN form
    const verifyPinForm = document.getElementById('verifyPinForm');
    if (verifyPinForm) {
        verifyPinForm.addEventListener('submit', function(e) {
            const testPin = document.getElementById('test_pin').value;
            
            if (testPin.length !== 6) {
                e.preventDefault();
                alert('Please enter a 6-digit PIN.');
                return false;
            }
        });
    }
});

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

<style>
.pin-input {
    font-size: 18px;
    font-weight: 600;
    text-align: center;
    letter-spacing: 0.5em;
    font-family: 'Courier New', monospace;
}

.pin-input::placeholder {
    letter-spacing: normal;
    font-weight: normal;
    font-family: inherit;
}
</style>
@endpush
@endsection
