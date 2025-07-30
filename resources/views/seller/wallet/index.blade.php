@extends('layouts.seller.main')

@section('title', 'Wallet Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
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
                                <h3 class="fs-25">{{ $balance->formatted_available_balance }}</h3>
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
                                <h3 class="fs-25">{{ $balance->formatted_pending_balance }}</h3>
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
                                <h3 class="fs-25">{{ $balance->formatted_total_balance }}</h3>
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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <div class="card rounded-3 border-0 mb-24">
                <div class="card-body p-25">
                    <h5 class="mb-3">
                        <i data-feather="zap" class="me-2"></i>Quick Actions
                    </h5>
                    
                    <div class="d-flex gap-2 flex-wrap">
                        @if($balance->available_balance > 0)
                            <a href="{{ route('seller.wallet.withdraw.form') }}" class="btn btn-primary">
                                <i data-feather="send" style="width: 16px;" class="me-1"></i>
                                Withdraw Funds
                            </a>
                        @else
                            <button type="button" class="btn btn-outline-secondary" disabled>
                                <i data-feather="send" style="width: 16px;" class="me-1"></i>
                                No Funds Available
                            </button>
                        @endif
                        
                        <a href="{{ route('seller.wallet.transactions') }}" class="btn btn-outline-primary">
                            <i data-feather="list" style="width: 16px;" class="me-1"></i>
                            View All Transactions
                        </a>
                        
                        <a href="{{ route('seller.wallet.withdraw.history') }}" class="btn btn-outline-secondary">
                            <i data-feather="clock" style="width: 16px;" class="me-1"></i>
                            Withdrawal History
                        </a>
                        
                        <a href="{{ route('seller.wallet.earnings') }}" class="btn btn-outline-success">
                            <i data-feather="trending-up" style="width: 16px;" class="me-1"></i>
                            Earnings Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card rounded-3 border-0 mb-24">
                <div class="card-body p-25">
                    <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color">
                        <h4 class="mb-0">
                            <i data-feather="activity" class="me-2"></i>Recent Transactions
                        </h4>
                        <a href="{{ route('seller.wallet.transactions') }}" class="btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    </div>

                    @if($recentTransactions->count() > 0)
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table align-middle table-bordered">
                                    <thead class="text-dark">
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Bank/Source</th>
                                            <th scope="col">Reference</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-body">
                                        @foreach($recentTransactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <span class="badge {{ $transaction->type_badge_class }} fw-normal py-1 px-2 fs-12 rounded-1">
                                                        <i data-feather="{{ $transaction->type === 'in' ? 'arrow-down-right' : 'arrow-up-right' }}" style="width: 12px;" class="me-1"></i>
                                                        {{ $transaction->type_label }}
                                                    </span>
                                                </td>
                                                <td class="fw-medium {{ $transaction->type === 'in' ? 'text-success' : 'text-danger' }}">
                                                    {{ $transaction->formatted_amount }}
                                                </td>
                                                <td>
                                                    @if($transaction->shopBank)
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-primary rounded-1 d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                                <span class="text-white fw-bold" style="font-size: 10px;">{{ $transaction->shopBank->bank_code }}</span>
                                                            </div>
                                                            <span>{{ $transaction->shopBank->bank_name }} - {{ $transaction->shopBank->formatted_account_number }}</span>
                                                        </div>
                                                    @else
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-success rounded-1 d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                                <i data-feather="shopping-bag" style="width: 16px; color: white;"></i>
                                                            </div>
                                                            <span>Order Settlement</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td><code>{{ $transaction->reference ?: '#' . $transaction->id }}</code></td>
                                                <td>
                                                    <span class="badge {{ $transaction->status_badge_class }} fw-normal py-1 px-2 fs-12 rounded-1">
                                                        {{ ucfirst($transaction->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" 
                                                            onclick="viewTransactionDetails({{ $transaction->id }})"
                                                            data-bs-toggle="tooltip" 
                                                            title="View Details">
                                                        <i data-feather="eye" style="width: 14px;"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i data-feather="activity" style="width: 64px; height: 64px; stroke: #8c9097;" class="mb-3"></i>
                            <h6 class="text-muted mb-2">No Transactions Yet</h6>
                            <p class="text-muted">Your transaction history will appear here once you start earning.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="transactionDetails">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // View transaction details
    function viewTransactionDetails(transactionId) {
        const modal = new bootstrap.Modal(document.getElementById('transactionModal'));
        const detailsContainer = document.getElementById('transactionDetails');
        
        // Show loading
        detailsContainer.innerHTML = `
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        
        modal.show();
        
        // Fetch transaction details
        fetch(`{{ route('seller.wallet.transaction.details', '') }}/${transactionId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    detailsContainer.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                    return;
                }
                
                const transaction = data.transaction;
                const typeIcon = transaction.type === 'in' ? 'arrow-down-right' : 'arrow-up-right';
                const typeColor = transaction.type === 'in' ? 'success' : 'danger';
                
                detailsContainer.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Type:</strong><br>
                            <span class="badge bg-${typeColor}-transparent text-${typeColor}">
                                <i data-feather="${typeIcon}" style="width: 12px;"></i> ${transaction.type === 'in' ? 'Income' : 'Withdrawal'}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <strong>Amount:</strong><br>
                            <span class="fw-bold text-${typeColor}">${data.formatted_amount}</span>
                        </div>
                        <div class="col-md-6 mt-3">
                            <strong>Status:</strong><br>
                            <span class="badge bg-secondary">${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}</span>
                        </div>
                        <div class="col-md-6 mt-3">
                            <strong>Date:</strong><br>
                            ${data.formatted_date}
                        </div>
                        <div class="col-12 mt-3">
                            <strong>Reference:</strong><br>
                            <code>${transaction.reference || '#' + transaction.id}</code>
                        </div>
                        ${transaction.details ? `
                            <div class="col-12 mt-3">
                                <strong>Details:</strong><br>
                                <pre class="bg-light p-2 rounded">${JSON.stringify(transaction.details, null, 2)}</pre>
                            </div>
                        ` : ''}
                    </div>
                `;
                
                // Re-initialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            })
            .catch(error => {
                detailsContainer.innerHTML = `<div class="alert alert-danger">Failed to load transaction details.</div>`;
            });
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
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 500);
                }
            });
        }, 5000);
        
        console.log('Wallet dashboard loaded successfully');
    });
</script>
@endpush

@push('head')
<style>
    /* Include the same styles from test-view */
    .status-card {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .status-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }
    
    .icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }
    
    .bg-success-transparent { background-color: rgba(40, 167, 69, 0.1); }
    .bg-warning-transparent { background-color: rgba(255, 193, 7, 0.1); }
    .bg-primary-transparent { background-color: rgba(93, 135, 255, 0.1); }
    .bg-danger-transparent { background-color: rgba(220, 53, 69, 0.1); }
    .bg-info-transparent { background-color: rgba(13, 202, 240, 0.1); }
    
    .table-responsive { border-radius: 8px; }
    .table th {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        font-weight: 600;
        font-size: 0.875rem;
    }
    .table td { border-color: #dee2e6; vertical-align: middle; }
    
    .badge { font-size: 0.75rem; padding: 0.35em 0.65em; }
    .btn { border-radius: 6px; }
    .btn-sm { padding: 0.25rem 0.5rem; }
    .alert { border-radius: 8px; }
    .card {
        border: 1px solid #e9ecef;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .border-color { border-color: #e9ecef !important; }
    
    .fs-25 { font-size: 1.5625rem !important; }
    .fs-15 { font-size: 0.9375rem !important; }
    .fs-13 { font-size: 0.8125rem !important; }
    .fs-12 { font-size: 0.75rem !important; }
    
    .mb-24 { margin-bottom: 1.5rem !important; }
    .p-25 { padding: 1.5625rem !important; }
    .mb-20 { margin-bottom: 1.25rem !important; }
    .pb-20 { padding-bottom: 1.25rem !important; }
</style>
@endpush
