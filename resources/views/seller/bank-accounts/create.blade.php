@extends('layouts.seller.main')

@section('title', 'Add Bank Account')

@section('content')
    <!--=== Start Section Title Area ===-->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">Add Bank Account</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.bank-accounts.index') }}">Bank Accounts</a></li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Add Bank Account</li>
            </ol>
        </nav>
    </div>
    <!--=== End Section Title Area ===-->

    <form action="{{ route('seller.bank-accounts.store') }}" method="POST">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card rounded-3 border-0 create-product-card mb-24">
                    <div class="card-body p-25">
                        <div class="card-title mb-20 pb-20 border-bottom border-color">
                            <h4 class="mb-2 mb-sm-0">Bank Account Details</h4>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
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

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('seller.bank-accounts.index') }}" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i data-feather="save" class="me-1" style="width: 16px;"></i>Add Bank Account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card rounded-3 border-0 create-product-card mb-24">
                    <div class="card-body p-25">
                        <div class="card-title mb-20 pb-20 border-bottom border-color">
                            <h4 class="mb-2 mb-sm-0">Bank Account Guide</h4>
                        </div>

                        <div class="form-group mb-25">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-primary">Security</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-check text-success"></i> Encrypted data storage</li>
                                                <li><i class="fa fa-check text-success"></i> Secure payment processing</li>
                                                <li><i class="fa fa-check text-success"></i> Bank-level security</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-info">Features</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-check text-success"></i> Multiple accounts</li>
                                                <li><i class="fa fa-check text-success"></i> Default account setting</li>
                                                <li><i class="fa fa-check text-success"></i> Quick withdrawal</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        <strong>Note:</strong> Ensure the account details are correct as they will be used for payment processing and withdrawals.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
