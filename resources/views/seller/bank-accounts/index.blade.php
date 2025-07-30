@extends('layouts.seller.main')

@section('title', 'Bank Account Management')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 col-md-12 order-1">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Bank Account Management</h5>
                </div>

                <div class="card-body">
                    <!-- Bank Accounts Grid Header -->
                    <div class="d-flex justify-content-between align-items-center mb-24">
                        <div class="section-title-wrapper d-flex align-items-center">
                            <h4 class="section-title mb-0">My Bank Accounts</h4>
                        </div>
                        
                        <div class="section-title-option d-flex align-items-center gap-3">
                            <form method="GET" action="{{ route('seller.bank-accounts.index') }}" class="src-form position-relative">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       class="form-control" 
                                       placeholder="Search bank accounts..." 
                                       style="padding-right: 40px;">
                                <button class="bg-transparent position-absolute top-50 end-0 translate-middle border-0 pe-3" type="submit">
                                    <i data-feather="search" style="stroke: #8c9097; width: 20px;"></i>
                                </button>
                            </form>
                            @if(request('search'))
                                <a href="{{ route('seller.bank-accounts.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i data-feather="x" style="width: 16px;" class="me-1"></i>Clear
                                </a>
                            @endif
                            <a href="{{ route('seller.bank-accounts.create') }}" class="btn btn-primary d-flex align-items-center">
                                <i data-feather="plus" style="stroke: #ffffff;" class="me-1"></i>
                                <span>Add Bank Account</span>
                            </a>
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

                    <!-- Bank Accounts Grid -->
                    <div class="row justify-content-center">
                        @forelse($bankAccounts as $bankAccount)
                            <div class="col-lg-6 col-xxl-6">
                                <div class="card rounded-3 border-1 mb-24">
                                    <div class="card-body p-25">
                                        <div class="d-lg-flex d-md-flex d-sm-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bank-logo-container {{ $bankAccount->is_default ? 'bg-primary' : 'bg-secondary' }} rounded-1 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                                    @php
                                                        $bankLogos = [
                                                            'BCA' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/2560px-Bank_Central_Asia.svg.png',
                                                            'MANDIRI' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/2560px-Bank_Mandiri_logo_2016.svg.png',
                                                            'BNI' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/BNI_logo.svg/2560px-BNI_logo.svg.png',
                                                            'BRI' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/BRI_Logo.svg/2560px-BRI_Logo.svg.png'
                                                        ];
                                                        $logoUrl = $bankLogos[strtoupper($bankAccount->bank_code)] ?? null;
                                                    @endphp
                                                    
                                                    @if($logoUrl)
                                                        <img src="{{ $logoUrl }}" 
                                                             alt="{{ $bankAccount->bank_name }} Logo" 
                                                             class="img-fluid" 
                                                             style="max-width: 80px; max-height: 80px; object-fit: contain;"
                                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    @endif
                                                    
                                                    <div class="text-white text-center {{ $logoUrl ? 'd-none' : 'd-flex' }} flex-column align-items-center justify-content-center w-100 h-100">
                                                        <i data-feather="credit-card" style="width: 32px; height: 32px;"></i>
                                                        <small class="mt-1 fw-bold">{{ strtoupper($bankAccount->bank_code) }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-lg-3 ms-md-3 ms-sm-3 mt-3 mt-lg-0 mt-md-0 mt-sm-0">
                                                <div class="mb-2 d-flex justify-content-between">
                                                    <div>
                                                        <h6 class="mb-0 fw-medium fs-15">{{ $bankAccount->bank_name }}</h6>
                                                        <span class="text-body d-block">{{ $bankAccount->bank_code }}</span>
                                                        @if($bankAccount->is_default)
                                                            <span class="badge bg-success mt-1">Primary</span>
                                                        @else
                                                            <span class="badge bg-secondary mt-1">Secondary</span>
                                                        @endif
                                                    </div>
                                                    <div class="dropdown action-dropdown">
                                                        <button class="btn p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i data-feather="more-vertical" style="width: 18px; stroke: #8c9097;"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end border-color">
                                                            <li class="m-0">
                                                                <a class="dropdown-item fs-14 text-body" href="{{ route('seller.bank-accounts.show', $bankAccount) }}">
                                                                    <i data-feather="eye"></i> View Details
                                                                </a>
                                                            </li>
                                                            <li class="m-0">
                                                                <a class="dropdown-item fs-14 text-body" href="{{ route('seller.bank-accounts.edit', $bankAccount) }}">
                                                                    <i data-feather="edit"></i> Edit
                                                                </a>
                                                            </li>
                                                            @if(!$bankAccount->is_default)
                                                                <li class="m-0">
                                                                    <form action="{{ route('seller.bank-accounts.set-primary', $bankAccount) }}" 
                                                                          method="POST" 
                                                                          style="display: inline;">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item fs-14 text-body" onclick="return confirm('Set this as your primary bank account?')">
                                                                            <i data-feather="star"></i> Set as Primary
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            @endif
                                                            <li class="m-0">
                                                                <form action="{{ route('seller.bank-accounts.destroy', $bankAccount) }}" 
                                                                      method="POST" 
                                                                      style="display: inline;"
                                                                      onsubmit="return confirm('Are you sure you want to delete this bank account?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item fs-14 text-danger">
                                                                        <i data-feather="trash"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="bank-details">
                                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                                        <span class="text-body">
                                                            <span class="text-dark fw-medium">Account:</span> 
                                                            {{ $bankAccount->formatted_account_number }}
                                                        </span>
                                                        <button class="btn btn-sm btn-outline-secondary copy-btn" 
                                                                onclick="copyToClipboard('{{ $bankAccount->account_number }}')" 
                                                                data-bs-toggle="tooltip" 
                                                                title="Copy Account Number">
                                                            <i data-feather="copy" style="width: 14px;"></i>
                                                        </button>
                                                    </div>
                                                    <span class="text-body d-block">
                                                        <span class="text-dark fw-medium">Full Account:</span> 
                                                        <span class="account-number-full d-none">{{ $bankAccount->account_number }}</span>
                                                        <span class="account-number-masked">{{ $bankAccount->formatted_account_number }}</span>
                                                        <button type="button" 
                                                                class="btn btn-link btn-sm p-0 ms-1 toggle-account-number" 
                                                                onclick="toggleAccountNumber(this)">
                                                            <small>Show</small>
                                                        </button>
                                                    </span>
                                                    <span class="text-body d-block">
                                                        <span class="text-dark fw-medium">Created:</span> 
                                                        {{ $bankAccount->created_at->format('M d, Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Empty State -->
                            <div class="col-lg-8 col-xxl-6">
                                <div class="card rounded-3 border-1 mb-24 border-dashed" style="border-style: dashed !important;">
                                    <div class="card-body p-25 text-center">
                                        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px;">
                                            <i data-feather="credit-card" style="width: 64px; height: 64px; stroke: #8c9097;" class="mb-3"></i>
                                            
                                            @if(request('search'))
                                                <h6 class="text-muted mb-2">No bank accounts found</h6>
                                                <p class="text-muted mb-3">No bank accounts match your search criteria "{{ request('search') }}"</p>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('seller.bank-accounts.index') }}" class="btn btn-outline-secondary btn-sm">
                                                        <i data-feather="x" style="width: 16px;" class="me-1"></i>
                                                        Clear Search
                                                    </a>
                                                    <a href="{{ route('seller.bank-accounts.create') }}" class="btn btn-primary btn-sm">
                                                        <i data-feather="plus" style="width: 16px;" class="me-1"></i>
                                                        Add Bank Account
                                                    </a>
                                                </div>
                                            @else
                                                <h6 class="text-muted mb-2">No Bank Accounts Yet</h6>
                                                <p class="text-muted mb-3">Connect your bank account to receive payments from your shop sales</p>
                                                <a href="{{ route('seller.bank-accounts.create') }}" class="btn btn-primary">
                                                    <i data-feather="plus" style="width: 16px;" class="me-1"></i>
                                                    Add Your First Bank Account
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($bankAccounts->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <p class="text-muted small">
                                    Showing {{ $bankAccounts->firstItem() }} to {{ $bankAccounts->lastItem() }} of {{ $bankAccounts->total() }} results
                                </p>
                            </div>
                            <div>
                                {{ $bankAccounts->links() }}
                            </div>
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
    // Copy to clipboard functionality
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            showCopySuccess(text);
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
            
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showCopySuccess(text);
        });
    }

    // Show copy success feedback
    function showCopySuccess(text) {
        // Create temporary notification
        const notification = document.createElement('div');
        notification.innerHTML = `<i data-feather="check-circle" class="me-2"></i>Copied: ${text}`;
        notification.className = 'position-fixed bg-success text-white p-3 rounded shadow';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.fontSize = '14px';
        
        document.body.appendChild(notification);
        
        // Replace feather icons in notification
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s ease';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 2000);
    }

    // Toggle account number visibility
    function toggleAccountNumber(button) {
        const container = button.closest('.bank-details');
        const fullNumber = container.querySelector('.account-number-full');
        const maskedNumber = container.querySelector('.account-number-masked');
        
        if (fullNumber.classList.contains('d-none')) {
            fullNumber.classList.remove('d-none');
            maskedNumber.classList.add('d-none');
            button.innerHTML = '<small>Hide</small>';
        } else {
            fullNumber.classList.add('d-none');
            maskedNumber.classList.remove('d-none');
            button.innerHTML = '<small>Show</small>';
        }
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
        
        console.log('Bank account management loaded successfully');
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
</script>
@endpush

@push('head')
<style>
    /* Bank account grid specific styles */
    .bank-logo-container {
        transition: all 0.3s ease;
    }
    
    .bank-logo-container:hover {
        transform: scale(1.05);
    }
    
    .copy-btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        transition: all 0.2s ease;
    }
    
    .copy-btn:hover {
        background-color: var(--bs-primary);
        color: white;
        border-color: var(--bs-primary);
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    .bank-details {
        font-size: 0.875rem;
    }
    
    .border-dashed {
        border: 2px dashed #dee2e6 !important;
    }
    
    .border-dashed:hover {
        border-color: var(--bs-primary) !important;
        background-color: rgba(var(--bs-primary-rgb), 0.05);
    }
    
    .toggle-account-number {
        font-size: 0.75rem;
        text-decoration: none !important;
        color: var(--bs-primary);
    }
    
    .toggle-account-number:hover {
        color: var(--bs-primary);
        text-decoration: underline !important;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--bs-dark);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .d-lg-flex.d-md-flex.d-sm-flex {
            flex-direction: column;
            text-align: center;
        }
        
        .ms-lg-3.ms-md-3.ms-sm-3 {
            margin-left: 0 !important;
            margin-top: 1rem !important;
        }
        
        .section-title-option {
            flex-direction: column;
            gap: 0.5rem !important;
        }
        
        .src-form {
            width: 100%;
        }
    }
</style>
@endpush
