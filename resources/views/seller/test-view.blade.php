@extends('layouts.seller.main')

@section('title', 'Test View - Wallet Balance')

@section('content')
<!--=== Start Section Title Area ===-->
<div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
    <h4 class="text-dark mb-0">Wallet Balance - Test View</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item fs-14">Financial</li>
            <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Wallet Test</li>
        </ol>
    </nav>
</div>
<!--=== End Section Title Area ===-->

<!-- Testing Controls -->
<div class="alert alert-info border-0 mb-4" role="alert">
    <div class="d-flex align-items-center">
        <i data-feather="info" class="me-2"></i>
        <div class="flex-grow-1">
            <strong>Development Testing Environment</strong><br>
            <small>Wallet balance page layout based on admin templates with balance cards and transaction history.</small>
        </div>
    </div>
</div>

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
                            <h3 class="fs-25">Rp 2,580,000</h3>
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
                                        <h3 class="fs-25">Rp 750,000</h3>
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
                                        <h3 class="fs-25">Rp 3,330,000</h3>
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
            <span class="badge bg-info-transparent text-info">Test Mode</span>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="withdrawAmount" class="form-label">Withdrawal Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" id="withdrawAmount" placeholder="0" max="2580000">
                    </div>
                    <small class="text-muted">Max: Rp 2,580,000 (Available Balance)</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="withdrawBank" class="form-label">Bank Destination</label>
                    <select class="form-select" id="withdrawBank">
                        <option value="">Select Bank Account</option>
                        <option value="1" data-bank="BCA" data-account="****5678">BCA - ****5678 (Primary)</option>
                        <option value="2" data-bank="MANDIRI" data-account="****9876">Mandiri - ****9876</option>
                        <option value="3" data-bank="BNI" data-account="****1357">BNI - ****1357</option>
                        <option value="4" data-bank="BRI" data-account="****2468">BRI - ****2468</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="withdrawNote" class="form-label">Note (Optional)</label>
                    <input type="text" class="form-control" id="withdrawNote" placeholder="Withdrawal note...">
                </div>
            </div>
        </div>
        
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" onclick="processWithdrawal()">
                <i data-feather="send" style="width: 16px;" class="me-1"></i>
                Request Withdrawal
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearWithdrawForm()">
                <i data-feather="x" style="width: 16px;" class="me-1"></i>
                Clear
            </button>
        </div>
    </div>
</div>

<!-- Balance History Section -->
<div class="card rounded-3 border-0 mb-24 table-edit-area">
    <div class="card-body text-body p-25">
        <div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color">
            <h4 class="mb-0">
                <i data-feather="list" class="me-2"></i>Transaction History
            </h4>
            <div class="d-flex gap-2">
                <select class="form-select form-control" style="width: auto;">
                    <option selected>All Transactions</option>
                    <option value="in">Income Only</option>
                    <option value="out">Withdrawals Only</option>
                </select>
                <select class="form-select form-control" style="width: auto;">
                    <option selected>This Month</option>
                    <option value="1">This Week</option>
                    <option value="2">Last 30 Days</option>
                    <option value="3">Last 3 Months</option>
                </select>
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
                                    <!-- Income Transaction -->
                                    <tr>
                                        <td>30-07-2025</td>
                                        <td>
                                            <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1">
                                                <i data-feather="arrow-down-right" style="width: 12px;" class="me-1"></i>Income
                                            </span>
                                        </td>
                                        <td class="fw-medium text-success">+Rp 250,000</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-1 d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <i data-feather="shopping-bag" style="width: 16px; color: white;"></i>
                                                </div>
                                                <span>Order Settlement</span>
                                            </div>
                                        </td>
                                        <td><code>#ORD-2025-001</code></td>
                                        <td>
                                            <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1">Completed</span>
                                        </td>
                                        <td>Sales from 3 orders</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
                                                <i data-feather="eye" style="width: 14px;"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Pending Income -->
                                    <tr>
                                        <td>30-07-2025</td>
                                        <td>
                                            <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1">
                                                <i data-feather="arrow-down-right" style="width: 12px;" class="me-1"></i>Income
                                            </span>
                                        </td>
                                        <td class="fw-medium text-success">+Rp 750,000</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-info rounded-1 d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <i data-feather="clock" style="width: 16px; color: white;"></i>
                                                </div>
                                                <span>Order Settlement</span>
                                            </div>
                                        </td>
                                        <td><code>#ORD-2025-002</code></td>
                                        <td>
                                            <span class="badge bg-warning-transparent text-warning fw-normal py-1 px-2 fs-12 rounded-1">Pending</span>
                                        </td>
                                        <td>Settlement H+1</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
                                                <i data-feather="eye" style="width: 14px;"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Withdrawal Transaction -->
                                    <tr>
                                        <td>29-07-2025</td>
                                        <td>
                                            <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1">
                                                <i data-feather="arrow-up-right" style="width: 12px;" class="me-1"></i>Withdrawal
                                            </span>
                                        </td>
                                        <td class="fw-medium text-danger">-Rp 500,000</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-1 d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <span class="text-white fw-bold" style="font-size: 10px;">BCA</span>
                                                </div>
                                                <span>BCA - ****5678</span>
                                            </div>
                                        </td>
                                        <td><code>#WD-2025-001</code></td>
                                        <td>
                                            <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1">Completed</span>
                                        </td>
                                        <td>Manual withdrawal</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
                                                <i data-feather="eye" style="width: 14px;"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- More Income -->
                                    <tr>
                                        <td>28-07-2025</td>
                                        <td>
                                            <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1">
                                                <i data-feather="arrow-down-right" style="width: 12px;" class="me-1"></i>Income
                                            </span>
                                        </td>
                                        <td class="fw-medium text-success">+Rp 1,200,000</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success rounded-1 d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <i data-feather="shopping-bag" style="width: 16px; color: white;"></i>
                                                </div>
                                                <span>Order Settlement</span>
                                            </div>
                                        </td>
                                        <td><code>#ORD-2025-003</code></td>
                                        <td>
                                            <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1">Completed</span>
                                        </td>
                                        <td>Sales from 8 orders</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
                                                <i data-feather="eye" style="width: 14px;"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Older Withdrawal -->
                                    <tr>
                                        <td>26-07-2025</td>
                                        <td>
                                            <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1">
                                                <i data-feather="arrow-up-right" style="width: 12px;" class="me-1"></i>Withdrawal
                                            </span>
                                        </td>
                                        <td class="fw-medium text-danger">-Rp 800,000</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning rounded-1 d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <span class="text-white fw-bold" style="font-size: 10px;">MDR</span>
                                                </div>
                                                <span>Mandiri - ****9876</span>
                                            </div>
                                        </td>
                                        <td><code>#WD-2025-002</code></td>
                                        <td>
                                            <span class="badge bg-success-transparent text-success fw-normal py-1 px-2 fs-12 rounded-1">Completed</span>
                                        </td>
                                        <td>Weekly withdrawal</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
                                                <i data-feather="eye" style="width: 14px;"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Failed Transaction -->
                                    <tr>
                                        <td>25-07-2025</td>
                                        <td>
                                            <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1">
                                                <i data-feather="arrow-up-right" style="width: 12px;" class="me-1"></i>Withdrawal
                                            </span>
                                        </td>
                                        <td class="fw-medium text-danger">-Rp 300,000</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-info rounded-1 d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <span class="text-white fw-bold" style="font-size: 10px;">BNI</span>
                                                </div>
                                                <span>BNI - ****1357</span>
                                            </div>
                                        </td>
                                        <td><code>#WD-2025-003</code></td>
                                        <td>
                                            <span class="badge bg-danger-transparent text-danger fw-normal py-1 px-2 fs-12 rounded-1">Failed</span>
                                        </td>
                                        <td>Bank validation error</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
                                                    <i data-feather="eye" style="width: 14px;"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Retry">
                                                    <i data-feather="refresh-cw" style="width: 14px;"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-sm-flex align-items-center justify-content-between mt-25 text-center">
                            <span class="fs-15 fw-medium text-dark mb-10 mb-sm-0 d-block">Showing 1 to 6 of 24 transactions</span>
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Withdrawal functionality
    function processWithdrawal() {
        const amount = document.getElementById('withdrawAmount').value;
        const bank = document.getElementById('withdrawBank');
        const note = document.getElementById('withdrawNote').value;
        
        if (!amount || amount <= 0) {
            showNotification('Please enter a valid withdrawal amount', 'error');
            return;
        }
        
        if (!bank.value) {
            showNotification('Please select a bank destination', 'error');
            return;
        }
        
        if (parseFloat(amount) > 2580000) {
            showNotification('Withdrawal amount exceeds available balance', 'error');
            return;
        }
        
        const selectedOption = bank.options[bank.selectedIndex];
        const bankName = selectedOption.dataset.bank;
        const accountNumber = selectedOption.dataset.account;
        
        // Simulate processing
        const processingMsg = showNotification('Processing withdrawal request...', 'info');
        
        setTimeout(() => {
            processingMsg.remove();
            showNotification(`Withdrawal request of Rp ${parseInt(amount).toLocaleString('id-ID')} to ${bankName} ${accountNumber} has been submitted successfully!`, 'success');
            clearWithdrawForm();
        }, 2000);
    }
    
    function clearWithdrawForm() {
        document.getElementById('withdrawAmount').value = '';
        document.getElementById('withdrawBank').value = '';
        document.getElementById('withdrawNote').value = '';
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
        document.getElementById('withdrawAmount').value = amount;
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
        
        // Add quick amount buttons
        const amountInput = document.getElementById('withdrawAmount');
        if (amountInput) {
            const quickAmounts = [100000, 500000, 1000000, 2580000];
            const buttonsHtml = quickAmounts.map(amount => 
                `<button type="button" class="btn btn-sm btn-outline-secondary me-1 mb-1" onclick="setQuickAmount(${amount})">
                    Rp ${amount.toLocaleString('id-ID')}
                </button>`
            ).join('');
            
            const quickButtonsContainer = document.createElement('div');
            quickButtonsContainer.className = 'mt-2';
            quickButtonsContainer.innerHTML = `<small class="text-muted d-block mb-1">Quick amounts:</small>${buttonsHtml}`;
            amountInput.parentNode.appendChild(quickButtonsContainer);
        }
        
        console.log('Wallet balance test view loaded successfully');
    });
</script>
@endpush

@push('head')
<style>
    /* Status card styles */
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
    
    /* Background color utilities */
    .bg-success-transparent {
        background-color: rgba(40, 167, 69, 0.1);
    }
    
    .bg-warning-transparent {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .bg-primary-transparent {
        background-color: rgba(93, 135, 255, 0.1);
    }
    
    .bg-danger-transparent {
        background-color: rgba(220, 53, 69, 0.1);
    }
    
    .bg-info-transparent {
        background-color: rgba(13, 202, 240, 0.1);
    }
    
    /* Table styles */
    .table-responsive {
        border-radius: 8px;
    }
    
    .table th {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .table td {
        border-color: #dee2e6;
        vertical-align: middle;
    }
    
    /* Badge enhancements */
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
    
    /* Form enhancements */
    .form-control:focus,
    .form-select:focus {
        border-color: #5d87ff;
        box-shadow: 0 0 0 0.2rem rgba(93, 135, 255, 0.25);
    }
    
    /* Button enhancements */
    .btn {
        border-radius: 6px;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
    
    /* Alert positioning */
    .alert {
        border-radius: 8px;
    }
    
    /* Quick amount buttons */
    .btn-outline-secondary {
        font-size: 0.75rem;
    }
    
    /* Card enhancements */
    .card {
        border: 1px solid #e9ecef;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .border-color {
        border-color: #e9ecef !important;
    }
    
    /* Typography */
    .fs-25 {
        font-size: 1.5625rem !important;
    }
    
    .fs-15 {
        font-size: 0.9375rem !important;
    }
    
    .fs-13 {
        font-size: 0.8125rem !important;
    }
    
    .fs-12 {
        font-size: 0.75rem !important;
    }
    
    /* Additional spacing */
    .mb-24 {
        margin-bottom: 1.5rem !important;
    }
    
    .p-25 {
        padding: 1.5625rem !important;
    }
    
    .mb-20 {
        margin-bottom: 1.25rem !important;
    }
    
    .pb-20 {
        padding-bottom: 1.25rem !important;
    }
</style>
@endpush
