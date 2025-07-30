@extends('layouts.seller.main')

@section('title', 'Add Bank Account')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 col-md-8 order-1 mx-auto">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Add New Bank Account</h5>
                    <a href="{{ route('seller.bank-accounts.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Back to Bank Accounts
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('seller.bank-accounts.store') }}" method="POST">
                        @csrf

                        <!-- Bank Name -->
                        <div class="mb-3">
                            <label for="bank_name" class="form-label">Bank Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('bank_name') is-invalid @enderror" 
                                   id="bank_name" 
                                   name="bank_name" 
                                   value="{{ old('bank_name') }}"
                                   placeholder="Enter bank name (e.g., Bank Mandiri, BCA, BNI)"
                                   required>
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Full name of the bank institution
                            </div>
                        </div>

                        <!-- Bank Code -->
                        <div class="mb-3">
                            <label for="bank_code" class="form-label">Bank Code <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('bank_code') is-invalid @enderror" 
                                   id="bank_code" 
                                   name="bank_code" 
                                   value="{{ old('bank_code') }}"
                                   placeholder="Enter bank code (e.g., BCA, BNI, MANDIRI)"
                                   maxlength="10"
                                   required>
                            @error('bank_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Short bank code or abbreviation
                            </div>
                        </div>

                        <!-- Account Number -->
                        <div class="mb-3">
                            <label for="account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('account_number') is-invalid @enderror" 
                                   id="account_number" 
                                   name="account_number" 
                                   value="{{ old('account_number') }}"
                                   placeholder="Enter your bank account number"
                                   maxlength="50"
                                   required>
                            @error('account_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Your complete bank account number
                            </div>
                        </div>

                        <!-- Set as Default -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input @error('is_default') is-invalid @enderror" 
                                       type="checkbox" 
                                       id="is_default" 
                                       name="is_default" 
                                       value="1"
                                       {{ old('is_default') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_default">
                                    Set as default bank account
                                </label>
                                @error('is_default')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">
                                Default account will be used for payments and withdrawals
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('seller.bank-accounts.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-x me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i>Save Bank Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Information Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bx bx-info-circle text-info me-2"></i>Important Information
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bx bx-check text-success me-2"></i>
                            Ensure the account number is correct as it will be used for payment processing
                        </li>
                        <li class="mb-2">
                            <i class="bx bx-check text-success me-2"></i>
                            You can add multiple bank accounts and set one as default
                        </li>
                        <li class="mb-2">
                            <i class="bx bx-check text-success me-2"></i>
                            Only verified bank accounts will be eligible for payouts
                        </li>
                        <li>
                            <i class="bx bx-check text-success me-2"></i>
                            Bank account information is kept secure and encrypted
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-format bank code to uppercase
    document.getElementById('bank_code').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });
    
    // Only allow numbers for account number
    document.getElementById('account_number').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });
</script>
@endpush
