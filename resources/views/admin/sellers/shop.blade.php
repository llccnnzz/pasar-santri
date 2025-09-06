@extends('layouts.admin.main')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="mb-0">Shop Details</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.sellers.index') }}">Sellers</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.sellers.show', $user) }}">{{ $user->name }}</a></li>
                                    <li class="breadcrumb-item active">Shop</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{ route('admin.sellers.show', $user) }}" class="btn btn-secondary me-2">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                            @if($user->shop->is_suspended)
                                <button type="button"
                                        class="btn btn-success unsuspend-btn"
                                        data-seller-id="{{ $user->id }}"
                                        data-seller-name="{{ $user->name }}"
                                        data-shop-name="{{ $user->shop->name }}">
                                    <i class="ri-user-check-line"></i> Unsuspend Shop
                                </button>
                            @else
                                <button type="button"
                                        class="btn btn-warning suspend-btn"
                                        data-seller-id="{{ $user->id }}"
                                        data-seller-name="{{ $user->name }}"
                                        data-shop-name="{{ $user->shop->name }}">
                                    <i class="ri-user-forbid-line"></i> Suspend Shop
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <!-- Shop Info Card -->
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center mb-4">
                                        @if($user->shop->logo)
                                            <img src="{{ $user->shop->logo->getUrl() }}"
                                                 alt="Shop Logo"
                                                 class="rounded-circle mb-3"
                                                 style="width: 100px; height: 100px; object-fit: cover;">
                                        @else
                                            <div class="avatar-lg mx-auto mb-3">
                                                <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-2">
                                                    {{ substr($user->shop->name, 0, 2) }}
                                                </div>
                                            </div>
                                        @endif

                                        <h5 class="mb-1">{{ $user->shop->name }}</h5>
                                        <p class="text-muted mb-3">{{ '@' . $user->shop->slug }}</p>

                                        <div class="d-flex justify-content-center gap-2 mb-3">
                                            @if($user->shop->is_open)
                                                <span class="badge bg-success">Open</span>
                                            @else
                                                <span class="badge bg-secondary">Closed</span>
                                            @endif

                                            @if($user->shop->is_suspended)
                                                <span class="badge bg-danger">Suspended</span>
                                            @else
                                                <span class="badge bg-primary">Active</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($user->shop->description)
                                        <div class="mb-3">
                                            <h6>Description</h6>
                                            <p class="text-muted">{{ $user->shop->description }}</p>
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-medium">Phone:</td>
                                                    <td>{{ $user->shop->phone ?? 'Not provided' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Email:</td>
                                                    <td>{{ $user->shop->email ?? 'Not provided' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Address:</td>
                                                    <td>{{ $user->shop->full_address ?? 'Not provided' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Created:</td>
                                                    <td>{{ $user->shop->created_at->format('M d, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Last Updated:</td>
                                                    <td>{{ $user->shop->updated_at->format('M d, Y H:i') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Suspension Info Card -->
                            @if($user->shop->is_suspended)
                                <div class="card border-warning">
                                    <div class="card-header bg-warning text-white">
                                        <h6 class="card-title mb-0">
                                            <i class="ri-alert-line"></i> Suspension Details
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <strong>Reason:</strong>
                                            <p class="text-muted mt-1">{{ $user->shop->suspended_reason }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <strong>Suspended At:</strong>
                                            <p class="text-muted mt-1">{{ $user->shop->suspended_at->format('M d, Y H:i') }}</p>
                                        </div>

                                        @if($user->shop->suspendedBy)
                                            <div class="mb-0">
                                                <strong>Suspended By:</strong>
                                                <p class="text-muted mt-1">{{ $user->shop->suspendedBy->name }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Shop Statistics and Content -->
                        <div class="col-xl-8">
                            <!-- Statistics Cards -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="text-primary mb-1">{{ $user->shop->products()->count() }}</h4>
                                            <p class="text-muted mb-0">Total Products</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="text-success mb-1">{{ $user->shop->products()->where('status', 'active')->count() }}</h4>
                                            <p class="text-muted mb-0">Active Products</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="text-info mb-1">{{ $user->shop->categories()->count() }}</h4>
                                            <p class="text-muted mb-0">Categories</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="text-warning mb-1">{{ $user->shop->banks()->count() }}</h4>
                                            <p class="text-muted mb-0">Bank Accounts</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Accounts -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Bank Accounts</h6>
                                </div>
                                <div class="card-body">
                                    @if($user->shop->banks->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Bank Name</th>
                                                        <th>Account Number</th>
                                                        <th>Account Name</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($user->shop->banks as $bank)
                                                    <tr>
                                                        <td>{{ $bank->bank_name }}</td>
                                                        <td class="font-monospace">{{ $bank->account_number }}</td>
                                                        <td>{{ $bank->account_name }}</td>
                                                        <td>
                                                            @if($bank->is_default)
                                                                <span class="badge bg-primary">Primary</span>
                                                            @else
                                                                <span class="badge bg-secondary">Secondary</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="ri-bank-line fs-1 text-muted"></i>
                                            <p class="text-muted mt-2">No bank accounts configured</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Recent Products -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0">Recent Products</h6>
                                    <a href="#" class="text-muted">View All</a>
                                </div>
                                <div class="card-body">
                                    @if($user->shop->products->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Category</th>
                                                        <th>Price</th>
                                                        <th>Stock</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($user->shop->products()->latest()->take(10)->get() as $product)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 me-2">
                                                                    @if($product->getFirstMedia('images'))
                                                                        <img src="{{ $product->getFirstMedia('images')->getUrl('thumb') }}"
                                                                             alt="" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                                    @else
                                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                                             style="width: 40px; height: 40px;">
                                                                            <i class="ri-image-line text-muted"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0">{{ Str::limit($product->name, 30) }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $product->categories[0]->name ?? 'Uncategorized' }}</td>
                                                        <td>IDR {{ number_format($product->price) }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                                                {{ $product->stock }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                                                                {{ ucfirst($product->status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $product->created_at->format('M d') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="ri-shopping-bag-line fs-1 text-muted"></i>
                                            <p class="text-muted mt-2">No products found</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Suspend Shop Modal -->
<div class="modal fade" id="suspendModal" tabindex="-1" aria-labelledby="suspendModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suspendModalLabel">Suspend Shop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="suspendForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="ri-alert-line"></i>
                        You are about to suspend the shop <strong id="suspendShopName"></strong> owned by <strong id="suspendSellerName"></strong>.
                    </div>

                    <div class="mb-3">
                        <label for="suspendReason" class="form-label">Suspension Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="suspendReason" name="suspended_reason" rows="4"
                                  placeholder="Please provide a detailed reason for the suspension..." required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ri-user-forbid-line"></i> Suspend Shop
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Unsuspend Shop Modal -->
<div class="modal fade" id="unsuspendModal" tabindex="-1" aria-labelledby="unsuspendModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unsuspendModalLabel">Unsuspend Shop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="ri-information-line"></i>
                    Are you sure you want to unsuspend the shop <strong id="unsuspendShopName"></strong> owned by <strong id="unsuspendSellerName"></strong>?
                </div>
                <p class="text-muted">The shop will be able to resume normal operations after unsuspension.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmUnsuspend">
                    <i class="ri-user-check-line"></i> Unsuspend Shop
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('head')
<style>
.avatar-lg {
    width: 4rem;
    height: 4rem;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let currentSellerId = null;

    // Suspend shop modal
    $('.suspend-btn').on('click', function() {
        currentSellerId = $(this).data('seller-id');
        $('#suspendSellerName').text($(this).data('seller-name'));
        $('#suspendShopName').text($(this).data('shop-name'));
        $('#suspendReason').val('');
        $('#suspendModal').modal('show');
    });

    // Unsuspend shop modal
    $('.unsuspend-btn').on('click', function() {
        currentSellerId = $(this).data('seller-id');
        $('#unsuspendSellerName').text($(this).data('seller-name'));
        $('#unsuspendShopName').text($(this).data('shop-name'));
        $('#unsuspendModal').modal('show');
    });

    // Handle suspend form submission
    $('#suspendForm').on('submit', function(e) {
        e.preventDefault();

        const reason = $('#suspendReason').val().trim();
        if (!reason) {
            $('#suspendReason').addClass('is-invalid');
            $('.invalid-feedback').text('Suspension reason is required.');
            return;
        }

        $.ajax({
            url: `/admin/sellers/${currentSellerId}/suspend-shop`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                suspended_reason: reason
            },
            beforeSend: function() {
                $('#suspendForm button[type="submit"]').prop('disabled', true);
            },
            success: function(response) {
                $('#suspendModal').modal('hide');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response.message) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while suspending the shop.'
                    });
                }
            },
            complete: function() {
                $('#suspendForm button[type="submit"]').prop('disabled', false);
            }
        });
    });

    // Handle unsuspend confirmation
    $('#confirmUnsuspend').on('click', function() {
        $.ajax({
            url: `/admin/sellers/${currentSellerId}/unsuspend-shop`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $(this).prop('disabled', true);
            },
            success: function(response) {
                $('#unsuspendModal').modal('hide');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response.message) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while unsuspending the shop.'
                    });
                }
            },
            complete: function() {
                $('#confirmUnsuspend').prop('disabled', false);
            }
        });
    });

    // Clear validation errors when typing
    $('#suspendReason').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush
