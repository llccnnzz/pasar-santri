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
                            <h4 class="mb-0">Seller Details</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.sellers.index') }}">Sellers</a></li>
                                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                                </ol>
                            </nav>
                        </div>
                        <a href="{{ route('admin.sellers.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back to Sellers
                        </a>
                    </div>

                    <div class="row">
                        <!-- Seller Info Card -->
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="avatar-lg mx-auto mb-3">
                                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-2">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                        </div>
                                        <h5 class="mb-1">{{ $user->name }}</h5>
                                        <p class="text-muted mb-3">{{ $user->email }}</p>
                                        
                                        <div class="d-flex justify-content-center gap-2 mb-3">
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active Seller</span>
                                            @else
                                                <span class="badge bg-danger">Inactive Seller</span>
                                            @endif
                                            
                                            @if($user->shop && $user->shop->is_suspended)
                                                <span class="badge bg-warning">Shop Suspended</span>
                                            @endif
                                        </div>
                                        
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" 
                                                    class="btn btn-{{ $user->is_active ? 'danger' : 'success' }} btn-sm toggle-status-btn" 
                                                    data-seller-id="{{ $user->id }}"
                                                    data-current-status="{{ $user->is_active ? 'active' : 'inactive' }}">
                                                <i class="ri-{{ $user->is_active ? 'close' : 'check' }}-line"></i>
                                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                            
                                            @if($user->shop)
                                                <a href="{{ route('admin.sellers.shop', $user) }}" class="btn btn-info btn-sm">
                                                    <i class="ri-store-line"></i> View Shop
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-medium">Phone:</td>
                                                    <td>{{ $user->phone ?? 'Not provided' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Joined:</td>
                                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Last Login:</td>
                                                    <td>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Email Verified:</td>
                                                    <td>
                                                        @if($user->email_verified_at)
                                                            <span class="badge bg-success">Verified</span>
                                                        @else
                                                            <span class="badge bg-warning">Pending</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- KYC Status Card -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">KYC Status</h6>
                                </div>
                                <div class="card-body">
                                    @if($user->kycApplications->isNotEmpty())
                                        @php $latestKyc = $user->kycApplications->first(); @endphp
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Status:</span>
                                            <span class="badge bg-{{ $latestKyc->status === 'approved' ? 'success' : ($latestKyc->status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($latestKyc->status) }}
                                            </span>
                                        </div>
                                        <hr>
                                        <small class="text-muted">
                                            Applied: {{ $latestKyc->created_at->format('M d, Y') }}
                                        </small>
                                        @if($latestKyc->reviewed_at)
                                            <br>
                                            <small class="text-muted">
                                                Reviewed: {{ $latestKyc->reviewed_at->format('M d, Y') }}
                                            </small>
                                        @endif
                                    @else
                                        <p class="text-muted mb-0">No KYC application submitted</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Statistics and Activities -->
                        <div class="col-xl-8">
                            <!-- Statistics Cards -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="text-primary mb-1">{{ $stats['total_products'] }}</h4>
                                            <p class="text-muted mb-0">Total Products</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="text-success mb-1">{{ $stats['active_products'] }}</h4>
                                            <p class="text-muted mb-0">Active Products</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="text-info mb-1">{{ $stats['total_orders'] }}</h4>
                                            <p class="text-muted mb-0">Total Orders</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="text-warning mb-1">{{ number_format($stats['total_revenue'] / 1000, 1) }}K</h4>
                                            <p class="text-muted mb-0">Revenue (IDR)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Products -->
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0">Recent Products</h6>
                                    <a href="#" class="text-muted">View All</a>
                                </div>
                                <div class="card-body">
                                    @if($user->products->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Category</th>
                                                        <th>Price</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($user->products as $product)
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
                                                        <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                                                        <td>IDR {{ number_format($product->price) }}</td>
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

                            <!-- Recent Orders -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0">Recent Orders</h6>
                                    <a href="#" class="text-muted">View All</a>
                                </div>
                                <div class="card-body">
                                    @if($user->orders->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Customer</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($user->orders as $order)
                                                    <tr>
                                                        <td>
                                                            <span class="font-monospace">#{{ $order->order_number }}</span>
                                                        </td>
                                                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                                                        <td>IDR {{ number_format($order->total_amount) }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $order->created_at->format('M d') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="ri-shopping-cart-line fs-1 text-muted"></i>
                                            <p class="text-muted mt-2">No orders found</p>
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
    // Handle seller status toggle
    $('.toggle-status-btn').on('click', function() {
        const sellerId = $(this).data('seller-id');
        const currentStatus = $(this).data('current-status');
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        
        if (confirm(`Are you sure you want to ${newStatus === 'active' ? 'activate' : 'deactivate'} this seller?`)) {
            $.ajax({
                url: `/admin/sellers/${sellerId}/toggle-status`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while updating seller status.'
                    });
                }
            });
        }
    });
});
</script>
@endpush
