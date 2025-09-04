@extends('layouts.seller.main')

@section('title', 'Bank Account Details')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 col-md-8 order-1 mx-auto">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Bank Account Details</h5>
                    <div>
                        <a href="{{ route('seller.bank-accounts.edit', $bankAccount) }}" class="btn btn-outline-primary me-2">
                            <i class="bx bx-edit-alt me-1"></i>Edit
                        </a>
                        <a href="{{ route('seller.bank-accounts.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back me-1"></i>Back to Bank Accounts
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Bank Information -->
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Bank Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <strong>{{ $bankAccount->bank_name }}</strong>
                            @if($bankAccount->is_default)
                                <span class="badge bg-primary ms-2">Default Account</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Bank Code</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <code class="fs-6">{{ $bankAccount->bank_code }}</code>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Account Number</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <span class="text-monospace">{{ $bankAccount->account_number }}</span>
                            <small class="text-muted d-block mt-1">
                                Masked view: {{ $bankAccount->formatted_account_number }}
                            </small>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Account Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <span class="text-monospace">{{ $bankAccount->account_name }}</span>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            @if($bankAccount->is_default)
                                <span class="badge bg-success">Primary Account</span>
                            @else
                                <span class="badge bg-secondary">Secondary Account</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Created</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $bankAccount->created_at->format('l, F j, Y \a\t g:i A') }}
                            <small class="text-muted d-block">{{ $bankAccount->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Last Updated</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $bankAccount->updated_at->format('l, F j, Y \a\t g:i A') }}
                            <small class="text-muted d-block">{{ $bankAccount->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-3">Actions</h6>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('seller.bank-accounts.edit', $bankAccount) }}" class="btn btn-primary">
                                    <i class="bx bx-edit-alt me-1"></i>Edit Account
                                </a>

                                @if(!$bankAccount->is_default)
                                    <form action="{{ route('seller.bank-accounts.set-primary', $bankAccount) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-success"
                                                onclick="return confirm('Are you sure you want to set this as your default bank account?')">
                                            <i class="bx bx-star me-1"></i>Set as Default
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('seller.bank-accounts.destroy', $bankAccount) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this bank account? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bx bx-trash me-1"></i>Delete Account
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Information -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bx bx-shield-check text-success me-2"></i>Security & Privacy
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bx bx-check text-success me-2"></i>
                            Your bank account information is encrypted and stored securely
                        </li>
                        <li class="mb-2">
                            <i class="bx bx-check text-success me-2"></i>
                            Account details are only accessible by authorized personnel
                        </li>
                        <li class="mb-2">
                            <i class="bx bx-check text-success me-2"></i>
                            All transactions are monitored for security
                        </li>
                        <li>
                            <i class="bx bx-check text-success me-2"></i>
                            We comply with industry-standard security practices
                        </li>
                    </ul>
                </div>
            </div>

            @if($bankAccount->is_default)
            <!-- Default Account Info -->
            <div class="card mt-4 border-primary">
                <div class="card-body">
                    <h6 class="card-title text-primary">
                        <i class="bx bx-star text-primary me-2"></i>Default Account Benefits
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bx bx-check text-primary me-2"></i>
                            This account will be used for all automatic payouts
                        </li>
                        <li class="mb-2">
                            <i class="bx bx-check text-primary me-2"></i>
                            Withdrawal requests will default to this account
                        </li>
                        <li>
                            <i class="bx bx-check text-primary me-2"></i>
                            Priority processing for payment settlements
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
