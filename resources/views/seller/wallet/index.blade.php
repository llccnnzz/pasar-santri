@extends('layouts.seller.main')

@section('title', 'Wallet Dashboard')

@section('content')
    <!--=== Start Section Title Area ===-->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">Wallet Balance</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item fs-14">Financial</li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Wallet</li>
            </ol>
        </nav>
    </div>
    <!--=== End Section Title Area ===-->

    @if(session('success'))
        <div class="alert alert-success border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i data-feather="check-circle" class="me-2"></i>
                <div class="flex-grow-1">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i data-feather="alert-circle" class="me-2"></i>
                <div class="flex-grow-1">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    <!-- Wallet Balance Overview Cards -->
    <div class="status-area">
        <div class="row justify-content-center">
            <!-- Available Balance Card -->
            <div class="col-xxl-4 col-sm-6">
                <div class="card status-card border-0 rounded-3 mb-24">
                    <div class="card-body p-25 text-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon rounded-3 bg-success-transparent">
                                    <i data-feather="dollar-sign" style="color: #28a745;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <span class="d-block mb-1">Available Balance</span>
                                <h3 class="fs-25">Rp {{ number_format($balance->available_balance, 0, ',', '.') }}</h3>
                                <p class="fw-medium fs-13">Ready for withdrawal <span class="badge bg-success-transparent text-success mx-1"><i data-feather="check-circle" class="me-1" style="width: 12px;"></i>Settled</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Balance Card -->
            <div class="col-xxl-4 col-sm-6">
                <div class="card status-card border-0 rounded-3 mb-24">
                    <div class="card-body p-25 text-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon rounded-3 bg-warning-transparent">
                                    <i data-feather="clock" style="color: #ffc107;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <span class="d-block mb-1">Pending Balance</span>
                                <h3 class="fs-25">Rp {{ number_format($balance->pending_in, 0, ',', '.') }}</h3>
                                <p class="fw-medium fs-13">Settlement in progress <span class="badge bg-warning-transparent text-warning mx-1"><i data-feather="clock" class="me-1" style="width: 12px;"></i>H+1</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Balance Card -->
            <div class="col-xxl-4 col-sm-6">
                <div class="card status-card border-0 rounded-3 mb-24">
                    <div class="card-body p-25 text-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon rounded-3 bg-primary-transparent">
                                    <i data-feather="trending-up" style="color: #5d87ff;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <span class="d-block mb-1">Total Balance</span>
                                <h3 class="fs-25">Rp {{ number_format($balance->total_balance, 0, ',', '.') }}</h3>
                                <p class="fw-medium fs-13">
                                            <span class="badge bg-primary-transparent text-primary mx-1">
                                                <i data-feather="wallet" class="me-1" style="width: 12px;"></i>Combined
                                            </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Withdraw Section -->
    <div class="card rounded-3 border-0 mb-24">
        <div class="card-body p-25">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i data-feather="send" class="me-2"></i>Quick Withdrawal
                </h5>
                @if($bankAccounts->isEmpty())
                    <a href="{{ route('seller.bank-accounts.create') }}" class="btn btn-sm btn-outline-primary">
                        <i data-feather="plus" style="width: 16px;" class="me-1"></i>Add Bank Account
                    </a>
                @endif
            </div>

            @if($bankAccounts->isEmpty())
                <div class="alert alert-warning">
                    <i data-feather="alert-triangle" class="me-2"></i>
                    You need to add a bank account before you can make withdrawals.
                    <a href="{{ route('seller.bank-accounts.create') }}" class="alert-link">Add one now</a>.
                </div>
            @elseif($balance->available_balance <= 0)
                <div class="alert alert-info">
                    <i data-feather="info" class="me-2"></i>
                    No available balance for withdrawal. Complete some orders to build up your balance.
                </div>
            @else
                <form action="{{ route('seller.wallet.withdraw.request') }}" method="POST" id="withdrawForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Withdrawal Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control @error('amount') is-invalid @enderror" 
                                           id="amount" 
                                           name="amount"
                                           placeholder="0" 
                                           min="10000"
                                           max="{{ $balance->available_balance }}"
                                           value="{{ old('amount') }}">
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Max: Rp {{ number_format($balance->available_balance, 0, ',', '.') }} (Available Balance)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="shop_bank_id" class="form-label">Bank Destination</label>
                                <select class="form-select @error('shop_bank_id') is-invalid @enderror" id="shop_bank_id" name="shop_bank_id">
                                    <option value="">Select Bank Account</option>
                                    @foreach($bankAccounts as $bankAccount)
                                        <option value="{{ $bankAccount->id }}" 
                                                data-bank="{{ $bankAccount->bank_name }}" 
                                                data-account="****{{ substr($bankAccount->account_number, -4) }}"
                                                {{ old('shop_bank_id') == $bankAccount->id ? 'selected' : '' }}>
                                            {{ $bankAccount->bank_name }} - ****{{ substr($bankAccount->account_number, -4) }}
                                            @if($bankAccount->is_default) (Primary) @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('shop_bank_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="note" class="form-label">Note (Optional)</label>
                                <input type="text" 
                                       class="form-control @error('note') is-invalid @enderror" 
                                       id="note" 
                                       name="note"
                                       placeholder="Withdrawal note..."
                                       value="{{ old('note') }}"
                                       maxlength="255">
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="send" style="width: 16px;" class="me-1"></i>
                            Request Withdrawal
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="clearWithdrawForm()">
                            <i data-feather="x" style="width: 16px;" class="me-1"></i>
                            Clear
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <!-- Balance History Section -->
    <div class="card rounded-3 border-0 mb-24 table-edit-area">
        <div class="card-body text-body p-25">
            <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color">
                <h4 class="mb-0">
                    <i data-feather="list" class="me-2"></i>Recent Transactions
                </h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('seller.wallet.transactions') }}" class="btn btn-outline-primary btn-sm">
                        <i data-feather="eye" style="width: 14px;" class="me-1"></i>View All
                    </a>
                </div>
            </div>

            <div class="table-wrapper">
                <div class="member">
                    <div class="global-table-area">
                        <div class="table-responsive overflow-auto" style="max-height: 600px;" data-simplebar>
                            <table class="table align-middle table-bordered">
                                <thead class="text-dark">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Bank/Source</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="text-body">
                                @forelse($recentTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <span class="badge {{ $transaction->type === 'in' ? 'bg-success-transparent text-success' : 'bg-danger-transparent text-danger' }} fw-normal py-1 px-2 fs-12 rounded-1">
                                                <i data-feather="{{ $transaction->type === 'in' ? 'arrow-down-right' : 'arrow-up-right' }}" style="width: 12px;" class="me-1"></i>
                                                {{ $transaction->type === 'in' ? 'Income' : 'Withdrawal' }}
                                            </span>
                                        </td>
                                        <td class="fw-medium {{ $transaction->type === 'in' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->formatted_amount }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-{{ $transaction->type === 'in' ? 'primary' : ($transaction->shopBank ? 'info' : 'secondary') }} rounded-1 d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    @if($transaction->type === 'in')
                                                        <i data-feather="shopping-bag" style="width: 16px; color: white;"></i>
                                                    @elseif($transaction->shopBank)
                                                        <span class="text-white fw-bold" style="font-size: 10px;">{{ strtoupper(substr($transaction->shopBank->bank_code, 0, 3)) }}</span>
                                                    @else
                                                        <i data-feather="help-circle" style="width: 16px; color: white;"></i>
                                                    @endif
                                                </div>
                                                <span>
                                                    @if($transaction->type === 'in')
                                                        {{ $transaction->details['type'] ?? 'Order Settlement' }}
                                                    @elseif($transaction->shopBank)
                                                        {{ $transaction->shopBank->bank_name }} - ****{{ substr($transaction->shopBank->account_number, -4) }}
                                                    @else
                                                        Unknown Source
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td><code>{{ $transaction->reference ?? '#N/A' }}</code></td>
                                        <td>
                                            @php
                                                $statusColor = match($transaction->status) {
                                                    'completed' => 'success',
                                                    'pending' => 'warning', 
                                                    'failed' => 'danger',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $statusColor }}-transparent text-{{ $statusColor }} fw-normal py-1 px-2 fs-12 rounded-1">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($transaction->details && isset($transaction->details['note']))
                                                {{ $transaction->details['note'] }}
                                            @elseif($transaction->type === 'in')
                                                {{ $transaction->details['description'] ?? 'Sales income' }}
                                            @else
                                                {{ $transaction->details['type'] ?? 'Manual withdrawal' }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('seller.wallet.transaction.details', $transaction->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
                                                    <i data-feather="eye" style="width: 14px;"></i>
                                                </a>
                                                @if($transaction->status === 'failed' && $transaction->type === 'out')
                                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Retry" onclick="retryWithdrawal({{ $transaction->id }})">
                                                        <i data-feather="refresh-cw" style="width: 14px;"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i data-feather="inbox" style="width: 48px; height: 48px; color: #ccc;" class="mb-2"></i>
                                                <span class="text-muted">No transactions found</span>
                                                <small class="text-muted">Your transaction history will appear here</small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($recentTransactions->count() > 0)
                            <div class="d-sm-flex align-items-center justify-content-between mt-25 text-center">
                                <span class="fs-15 fw-medium text-dark mb-10 mb-sm-0 d-block">Showing recent {{ $recentTransactions->count() }} transactions</span>
                                <a href="{{ route('seller.wallet.transactions') }}" class="btn btn-outline-primary btn-sm">
                                    <i data-feather="arrow-right" style="width: 14px;" class="me-1"></i>
                                    View All Transactions
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
        // Clear withdrawal form
        function clearWithdrawForm() {
            const form = document.getElementById('withdrawForm');
            if (form) {
                form.reset();
            }
        }

        // Retry withdrawal functionality
        function retryWithdrawal(transactionId) {
            if (confirm('Are you sure you want to retry this withdrawal?')) {
                // Here you could implement retry logic
                // For now, just show a message
                showNotification('Retry functionality will be implemented soon', 'info');
            }
        }

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.zIndex = '9999';
            notification.style.minWidth = '300px';

            const icon = type === 'success' ? 'check-circle' : type === 'error' ? 'x-circle' : 'info';

            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <i data-feather="${icon}" class="me-2" style="width: 18px;"></i>
                    <span>${message}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            `;

            document.body.appendChild(notification);

            // Replace feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);

            return notification;
        }

        // Quick amount buttons
        function setQuickAmount(amount) {
            const amountInput = document.getElementById('amount');
            if (amountInput) {
                amountInput.value = amount;
            }
        }

        // Form validation
        function validateWithdrawForm() {
            const amount = document.getElementById('amount');
            const bankSelect = document.getElementById('shop_bank_id');
            
            if (!amount || !amount.value || parseFloat(amount.value) <= 0) {
                showNotification('Please enter a valid withdrawal amount', 'error');
                return false;
            }

            if (!bankSelect || !bankSelect.value) {
                showNotification('Please select a bank account', 'error');
                return false;
            }

            const maxAmount = parseFloat(amount.getAttribute('max'));
            if (parseFloat(amount.value) > maxAmount) {
                showNotification('Withdrawal amount exceeds available balance', 'error');
                return false;
            }

            return true;
        }

        // Initialize feather icons and tooltips when DOM loads
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Add quick amount buttons if form exists
            const amountInput = document.getElementById('amount');
            if (amountInput) {
                const maxAmount = parseFloat(amountInput.getAttribute('max'));
                const quickAmounts = [100000, 500000, 1000000];
                
                // Add max amount if it's different from predefined amounts
                if (maxAmount > 0 && !quickAmounts.includes(maxAmount)) {
                    quickAmounts.push(maxAmount);
                }

                const buttonsHtml = quickAmounts
                    .filter(amount => amount <= maxAmount && amount > 0)
                    .map(amount =>
                        `<button type="button" class="btn btn-sm btn-outline-secondary me-1 mb-1" onclick="setQuickAmount(${amount})">
                            Rp ${amount.toLocaleString('id-ID')}
                        </button>`
                    ).join('');

                if (buttonsHtml) {
                    const quickButtonsContainer = document.createElement('div');
                    quickButtonsContainer.className = 'mt-2';
                    quickButtonsContainer.innerHTML = `<small class="text-muted d-block mb-1">Quick amounts:</small>${buttonsHtml}`;
                    amountInput.parentNode.appendChild(quickButtonsContainer);
                }
            }

            // Add form submission validation
            const withdrawForm = document.getElementById('withdrawForm');
            if (withdrawForm) {
                withdrawForm.addEventListener('submit', function(e) {
                    if (!validateWithdrawForm()) {
                        e.preventDefault();
                    }
                });
            }

            console.log('Wallet balance view loaded successfully');
        });
    </script>
@endpush

