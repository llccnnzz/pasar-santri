@extends('layouts.seller.main')

@section('title', 'Edit Bank Account')

@section('content')
    <!--=== Start Section Title Area ===-->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">Edit Bank Account</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.bank-accounts.index') }}">Bank Accounts</a></li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Edit Bank Account</li>
            </ol>
        </nav>
    </div>
    <!--=== End Section Title Area ===-->

    <form action="{{ route('seller.bank-accounts.update', $bankAccount) }}" method="POST">
        @csrf
        @method('PUT')
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
                                           value="{{ old('bank_name', $bankAccount->bank_name) }}"
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
                                           value="{{ old('bank_code', $bankAccount->bank_code) }}"
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
                                           value="{{ old('account_number', $bankAccount->account_number) }}"
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
                                               {{ old('is_default', $bankAccount->is_default) ? 'checked' : '' }}>
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
                                        <i data-feather="save" class="me-1" style="width: 16px;"></i>Update Bank Account
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
                            <h4 class="mb-2 mb-sm-0">Account Information</h4>
                        </div>

                        <div class="form-group mb-25">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Current Status</h6>
                                        <div class="d-flex align-items-center mb-3">
                                            @if($bankAccount->is_default)
                                                <span class="badge bg-success me-2">Default Account</span>
                                            @else
                                                <span class="badge bg-secondary me-2">Secondary Account</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Created</h6>
                                        <p class="mb-0">{{ $bankAccount->created_at->format('M d, Y \a\t H:i') }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Last Updated</h6>
                                        <p class="mb-0">{{ $bankAccount->updated_at->format('M d, Y \a\t H:i') }}</p>
                                    </div>

                                    <div class="alert alert-warning">
                                        <h6 class="alert-heading">
                                            <i class="fa fa-exclamation-triangle me-1"></i>Important Notes
                                        </h6>
                                        <ul class="list-unstyled mb-0 small">
                                            <li class="mb-1">• Changing account details may affect pending transactions</li>
                                            <li class="mb-1">• Ensure all information is accurate to avoid payment delays</li>
                                            <li>• Contact support if you need help with bank verification</li>
                                        </ul>
                                    </div>
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
