@extends('layouts.seller.main')

@section('title', 'Withdraw Funds')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i data-feather="send" class="me-2"></i>Withdraw Funds
                    </h5>
                    <a href="{{ route('seller.wallet.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i data-feather="arrow-left" style="width: 16px;" class="me-1"></i>Back to Wallet
                    </a>
                </div>

                <div class="card-body">
                    @if($balance)
                        <!-- Balance Overview -->
                        <div class="alert alert-info border-0 mb-4">
                            <div class="d-flex align-items-center">
                                <i data-feather="info" class="me-2"></i>
                                <div class="flex-grow-1">
                                    <strong>Available Balance: {{ $balance->formatted_available_balance }}</strong><br>
                                    <small>Maximum withdrawal amount: {{ $balance->formatted_available_balance }}</small>
                                </div>
                            </div>
                        </div>

                        @if($balance->available_balance > 0)
                            <form action="{{ route('seller.wallet.withdraw.request') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Withdrawal Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" 
                                                       class="form-control @error('amount') is-invalid @enderror" 
                                                       id="amount" 
                                                       name="amount"
                                                       value="{{ old('amount') }}"
                                                       placeholder="0" 
                                                       min="10000"
                                                       max="{{ $balance->available_balance }}"
                                                       required>
                                            </div>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @endif
                                            <small class="text-muted">Minimum: Rp 10,000 | Maximum: {{ $balance->formatted_available_balance }}</small>
                                            
                                            <!-- Quick Amount Buttons -->
                                            <div class="mt-2">
                                                <small class="text-muted d-block mb-1">Quick amounts:</small>
                                                @php
                                                    $quickAmounts = [100000, 500000, 1000000];
                                                    if ($balance->available_balance > 0) {
                                                        $quickAmounts[] = $balance->available_balance;
                                                    }
                                                @endphp
                                                @foreach($quickAmounts as $quickAmount)
                                                    @if($quickAmount <= $balance->available_balance)
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-secondary me-1 mb-1" 
                                                                onclick="setAmount({{ $quickAmount }})">
                                                            Rp {{ number_format($quickAmount, 0, ',', '.') }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="shop_bank_id" class="form-label">Bank Destination <span class="text-danger">*</span></label>
                                            <select class="form-select @error('shop_bank_id') is-invalid @enderror" 
                                                    id="shop_bank_id" 
                                                    name="shop_bank_id" 
                                                    required>
                                                <option value="">Select Bank Account</option>
                                                @foreach($bankAccounts as $bank)
                                                    <option value="{{ $bank->id }}" 
                                                            {{ old('shop_bank_id') == $bank->id ? 'selected' : '' }}
                                                            data-bank="{{ $bank->bank_name }}" 
                                                            data-account="{{ $bank->formatted_account_number }}">
                                                        {{ $bank->bank_name }} - {{ $bank->formatted_account_number }}
                                                        @if($bank->is_default) (Primary) @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('shop_bank_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @endif
                                            <small class="text-muted">
                                                <a href="{{ route('seller.bank-accounts.index') }}" target="_blank">
                                                    Manage bank accounts
                                                </a>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="note" class="form-label">Note (Optional)</label>
                                    <input type="text" 
                                           class="form-control @error('note') is-invalid @enderror" 
                                           id="note" 
                                           name="note"
                                           value="{{ old('note') }}"
                                           placeholder="Add a note for this withdrawal..."
                                           maxlength="255">
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>

                                <!-- Withdrawal Information -->
                                <div class="alert alert-warning border-0 mb-4">
                                    <h6 class="alert-heading">
                                        <i data-feather="alert-triangle" class="me-2"></i>Withdrawal Information
                                    </h6>
                                    <ul class="mb-0">
                                        <li>Processing time: 1-3 business days</li>
                                        <li>Minimum withdrawal: Rp 10,000</li>
                                        <li>No withdrawal fees</li>
                                        <li>Withdrawals are processed during business hours</li>
                                    </ul>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i data-feather="send" style="width: 16px;" class="me-1"></i>
                                        Submit Withdrawal Request
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                        <i data-feather="x" style="width: 16px;" class="me-1"></i>
                                        Reset
                                    </button>
                                    <a href="{{ route('seller.wallet.index') }}" class="btn btn-outline-secondary">
                                        <i data-feather="arrow-left" style="width: 16px;" class="me-1"></i>
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-5">
                                <i data-feather="dollar-sign" style="width: 64px; height: 64px; stroke: #8c9097;" class="mb-3"></i>
                                <h6 class="text-muted mb-2">Insufficient Balance</h6>
                                <p class="text-muted">You don't have enough available balance to make a withdrawal.</p>
                                <a href="{{ route('seller.wallet.index') }}" class="btn btn-primary">
                                    <i data-feather="arrow-left" style="width: 16px;" class="me-1"></i>
                                    Back to Wallet
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i data-feather="alert-circle" style="width: 64px; height: 64px; stroke: #dc3545;" class="mb-3"></i>
                            <h6 class="text-muted mb-2">Balance Information Unavailable</h6>
                            <p class="text-muted">Unable to load your balance information. Please try again later.</p>
                            <a href="{{ route('seller.wallet.index') }}" class="btn btn-primary">
                                <i data-feather="arrow-left" style="width: 16px;" class="me-1"></i>
                                Back to Wallet
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function setAmount(amount) {
        document.getElementById('amount').value = amount;
    }
    
    function resetForm() {
        document.getElementById('amount').value = '';
        document.getElementById('shop_bank_id').value = '';
        document.getElementById('note').value = '';
    }
    
    // Initialize feather icons when DOM loads
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        console.log('Withdrawal form loaded successfully');
    });
</script>
@endpush
