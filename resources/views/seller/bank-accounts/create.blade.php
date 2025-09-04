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
                                <!-- Bank Selection -->
                                <div class="mb-3">
                                    <label for="bank_name" class="form-label">Select Bank <span class="text-danger">*</span></label>
                                    <select class="form-select @error('bank_name') is-invalid @enderror"
                                            id="bank_name"
                                            name="bank_name"
                                            required>
                                        <option value="">Choose a bank...</option>
                                        <option value="BCA" data-code="BCA" data-logo="bca.png" {{ old('bank_name') == 'BCA' ? 'selected' : '' }}>Bank Central Asia (BCA)</option>
                                        <option value="BNI" data-code="BNI" data-logo="bni.png" {{ old('bank_name') == 'BNI' ? 'selected' : '' }}>Bank Negara Indonesia (BNI)</option>
                                        <option value="BRI" data-code="BRI" data-logo="bri.png" {{ old('bank_name') == 'BRI' ? 'selected' : '' }}>Bank Rakyat Indonesia (BRI)</option>
                                        <option value="BSI" data-code="BSI" data-logo="bsi.png" {{ old('bank_name') == 'BSI' ? 'selected' : '' }}>Bank Syariah Indonesia (BSI)</option>
                                        <option value="BTN" data-code="BTN" data-logo="btn.png" {{ old('bank_name') == 'BTN' ? 'selected' : '' }}>Bank Tabungan Negara (BTN)</option>
                                        <option value="CIMB" data-code="CIMB" data-logo="cimb.png" {{ old('bank_name') == 'CIMB' ? 'selected' : '' }}>CIMB Niaga</option>
                                        <option value="CITY" data-code="CITY" data-logo="city.png" {{ old('bank_name') == 'CITY' ? 'selected' : '' }}>Citibank</option>
                                        <option value="DBS" data-code="DBS" data-logo="dbs.png" {{ old('bank_name') == 'DBS' ? 'selected' : '' }}>DBS Bank</option>
                                        <option value="MANDIRI" data-code="MANDIRI" data-logo="mandiri.png" {{ old('bank_name') == 'MANDIRI' ? 'selected' : '' }}>Bank Mandiri</option>
                                        <option value="OCBC" data-code="OCBC" data-logo="ocbc.png" {{ old('bank_name') == 'OCBC' ? 'selected' : '' }}>OCBC NISP</option>
                                        <option value="PERMATA" data-code="PERMATA" data-logo="permata.png" {{ old('bank_name') == 'PERMATA' ? 'selected' : '' }}>Bank Permata</option>
                                        <option value="SMBC" data-code="SMBC" data-logo="smbc.png" {{ old('bank_name') == 'SMBC' ? 'selected' : '' }}>Sumitomo Mitsui Banking Corporation</option>
                                        <option value="UOB" data-code="UOB" data-logo="uob.png" {{ old('bank_name') == 'UOB' ? 'selected' : '' }}>United Overseas Bank</option>
                                        <option value="OTHER" data-code="OTHER" data-logo="" {{ old('bank_name') == 'OTHER' ? 'selected' : '' }}>Other Bank</option>
                                    </select>
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Select your bank from the list or choose "Other" for unlisted banks
                                    </div>

                                    <!-- Bank Logo Preview -->
                                    <div id="bank-logo-preview" class="mt-2" style="display: none;">
                                        <img id="bank-logo-img" src="" alt="Bank Logo" style="height: 40px; width: auto;">
                                    </div>
                                </div>

                                <!-- Custom Bank Name (shown when "Other" is selected) -->
                                <div class="mb-3" id="custom-bank-name" style="display: none;">
                                    <label for="custom_bank_name" class="form-label">Bank Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control"
                                           id="custom_bank_name"
                                           name="custom_bank_name"
                                           value="{{ old('custom_bank_name') }}"
                                           placeholder="Enter bank name">
                                    <div class="form-text">
                                        Enter the full name of your bank
                                    </div>
                                </div>

                                <!-- Bank Code (Auto-filled) -->
                                <div class="mb-3">
                                    <label for="bank_code" class="form-label">Bank Code <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('bank_code') is-invalid @enderror"
                                           id="bank_code"
                                           name="bank_code"
                                           value="{{ old('bank_code') }}"
                                           placeholder="Bank code will be auto-filled"
                                           maxlength="10"
                                           required
                                           readonly>
                                    @error('bank_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Bank code is automatically filled based on selected bank
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

                                <!-- Account Name -->
                                <div class="mb-3">
                                    <label for="account_name" class="form-label">Account Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('account_name') is-invalid @enderror"
                                           id="account_name"
                                           name="account_name"
                                           value="{{ old('account_name') }}"
                                           placeholder="Enter your bank account name"
                                           required>
                                    @error('account_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Your complete bank account name
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
    // Bank selection handler
    document.getElementById('bank_name').addEventListener('change', function(e) {
        const selectedOption = e.target.selectedOptions[0];
        const bankCode = selectedOption.getAttribute('data-code');
        const bankLogo = selectedOption.getAttribute('data-logo');
        const customBankDiv = document.getElementById('custom-bank-name');
        const bankCodeInput = document.getElementById('bank_code');
        const logoPreview = document.getElementById('bank-logo-preview');
        const logoImg = document.getElementById('bank-logo-img');

        // Handle "Other" bank selection
        if (e.target.value === 'OTHER') {
            customBankDiv.style.display = 'block';
            document.getElementById('custom_bank_name').required = true;
            bankCodeInput.value = '';
            bankCodeInput.readOnly = false;
            bankCodeInput.placeholder = 'Enter bank code';
            logoPreview.style.display = 'none';
        } else if (e.target.value) {
            customBankDiv.style.display = 'none';
            document.getElementById('custom_bank_name').required = false;
            bankCodeInput.value = bankCode;
            bankCodeInput.readOnly = true;
            bankCodeInput.placeholder = 'Bank code auto-filled';

            // Show bank logo
            if (bankLogo) {
                logoImg.src = '/admin-assets/assets/images/bank/' + bankLogo;
                logoPreview.style.display = 'block';
            } else {
                logoPreview.style.display = 'none';
            }
        } else {
            customBankDiv.style.display = 'none';
            document.getElementById('custom_bank_name').required = false;
            bankCodeInput.value = '';
            bankCodeInput.readOnly = false;
            bankCodeInput.placeholder = 'Bank code will be auto-filled';
            logoPreview.style.display = 'none';
        }
    });

    // Only allow numbers for account number
    document.getElementById('account_number').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });

    // Handle custom bank name input
    document.getElementById('custom_bank_name').addEventListener('input', function(e) {
        if (document.getElementById('bank_name').value === 'OTHER') {
            // Auto-generate bank code from custom name
            const customName = e.target.value.toUpperCase();
            const bankCodeInput = document.getElementById('bank_code');

            // Extract first letters or meaningful abbreviation
            let code = '';
            const words = customName.split(' ');
            for (let word of words) {
                if (word.length > 0) {
                    code += word.charAt(0);
                }
            }
            bankCodeInput.value = code.substring(0, 10); // Limit to 10 characters
        }
    });
</script>
@endpush
