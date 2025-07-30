@extends('layouts.seller.main')

@section('title', 'Bank Account Management')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 col-md-12 order-1">
            <div class="card">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-header">Bank Account Management</h5>
                    <div class="card-header">
                        <a href="{{ route('seller.bank-accounts.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i>Add New Bank Account
                        </a>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="card-body">
                    <form method="GET" action="{{ route('seller.bank-accounts.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           class="form-control" 
                                           placeholder="Search by bank name, code, or account number...">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(request('search'))
                                    <a href="{{ route('seller.bank-accounts.index') }}" class="btn btn-outline-secondary">
                                        <i class="bx bx-x"></i> Clear Search
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

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

                    <!-- Bank Accounts Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Bank Name</th>
                                    <th>Bank Code</th>
                                    <th>Account Number</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bankAccounts as $bankAccount)
                                    <tr>
                                        <td>
                                            <strong>{{ $bankAccount->bank_name }}</strong>
                                            @if($bankAccount->is_default)
                                                <span class="badge bg-primary ms-2">Default</span>
                                            @endif
                                        </td>
                                        <td>
                                            <code>{{ $bankAccount->bank_code }}</code>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $bankAccount->formatted_account_number }}</span>
                                        </td>
                                        <td>
                                            @if($bankAccount->is_default)
                                                <span class="badge bg-success">Primary Account</span>
                                            @else
                                                <span class="badge bg-secondary">Secondary</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $bankAccount->created_at->format('M d, Y') }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('seller.bank-accounts.show', $bankAccount) }}">
                                                        <i class="bx bx-show me-1"></i> View
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('seller.bank-accounts.edit', $bankAccount) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                    @if(!$bankAccount->is_default)
                                                        <form action="{{ route('seller.bank-accounts.set-primary', $bankAccount) }}" 
                                                              method="POST" 
                                                              style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="bx bx-star me-1"></i> Set as Default
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('seller.bank-accounts.destroy', $bankAccount) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Are you sure you want to delete this bank account?')"
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="bx bx-credit-card" style="font-size: 48px; color: #ccc;"></i>
                                                <h6 class="mt-2 text-muted">No bank accounts found</h6>
                                                <p class="text-muted">
                                                    @if(request('search'))
                                                        No bank accounts match your search criteria.
                                                    @else
                                                        Start by adding your first bank account for receiving payments.
                                                    @endif
                                                </p>
                                                @if(!request('search'))
                                                    <a href="{{ route('seller.bank-accounts.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus me-1"></i>Add Bank Account
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush
