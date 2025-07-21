@extends('layouts.landing.component.app')

@section('content')
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ !isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] === 'dashboard') ? 'active' : '' }}" 
                                            id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false">
                                                <i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ isset($_GET['page']) && $_GET['page'] === 'orders' ? 'active' : '' }}" 
                                            id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">
                                            <i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ isset($_GET['page']) && $_GET['page'] === 'tracking' ? 'active' : '' }}" 
                                            id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false">
                                            <i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ isset($_GET['page']) && $_GET['page'] === 'address' ? 'active' : '' }}" 
                                            id="address-tab" data-bs-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">
                                            <i class="fi-rs-marker mr-10"></i>My Address</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ isset($_GET['page']) && $_GET['page'] === 'account' ? 'active' : '' }}" 
                                            id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="false">
                                            <i class="fi-rs-user mr-10"></i>Account details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" onclick="document.getElementById('form-logout').submit()"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content pl-50">
                                    <div class="tab-pane fade {{ !isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] === 'dashboard') ? 'active show' : '' }}" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Hello {{ $currentUser['name'] }}!</h3>
                                            </div>
                                            <div class="card-body">
                                                <p>
                                                    From your account dashboard. you can easily check &amp; view your <a href="#">recent orders</a>,<br />
                                                    manage your <a href="#">shipping and billing addresses</a> and <a href="#">edit your password and account details.</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ isset($_GET['page']) && $_GET['page'] === 'orders' ? 'active show' : '' }}" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Your Orders</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>Order</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>#1357</td>
                                                            <td>March 45, 2020</td>
                                                            <td>Processing</td>
                                                            <td>$125.00 for 2 item</td>
                                                            <td><a href="#" class="btn-small d-block">View</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>#2468</td>
                                                            <td>June 29, 2020</td>
                                                            <td>Completed</td>
                                                            <td>$364.00 for 5 item</td>
                                                            <td><a href="#" class="btn-small d-block">View</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>#2366</td>
                                                            <td>August 02, 2020</td>
                                                            <td>Completed</td>
                                                            <td>$280.00 for 3 item</td>
                                                            <td><a href="#" class="btn-small d-block">View</a></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ isset($_GET['page']) && $_GET['page'] === 'tracking' ? 'active show' : '' }}" id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Orders tracking</h3>
                                            </div>
                                            <div class="card-body contact-from-area">
                                                <p>To track your order please enter your OrderID in the box below and press "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <form class="contact-form-style mt-30 mb-50" action="#" method="post">
                                                            <div class="input-style mb-20">
                                                                <label>Order ID</label>
                                                                <input name="order-id" placeholder="Found in your order confirmation email" type="text" />
                                                            </div>
                                                            <div class="input-style mb-20">
                                                                <label>Billing email</label>
                                                                <input name="billing-email" placeholder="Email you used during checkout" type="email" />
                                                            </div>
                                                            <button class="submit submit-auto-width" type="submit">Track</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ isset($_GET['page']) && $_GET['page'] === 'address' ? 'active show' : '' }}" id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h3 class="mb-0">My Addresses</h3>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                                    <i class="fi-rs-plus mr-5"></i>Add New Address
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <!-- Success/Error Messages -->
                                                @if(session('success'))
                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        {{ session('success') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                    </div>
                                                @endif

                                                @if($errors->any())
                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        <ul class="mb-0">
                                                            @foreach($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                    </div>
                                                @endif

                                                <!-- Addresses List -->
                                                @if(!empty($addresses))
                                                    <div class="row">
                                                        @foreach($addresses as $address)
                                                            <div class="col-md-6 mb-3">
                                                                <div class="card address-card {{ isset($address['is_primary']) && $address['is_primary'] ? 'border-primary' : '' }}">
                                                                    <div class="card-body">
                                                                        @if(isset($address['is_primary']) && $address['is_primary'])
                                                                            <span class="badge bg-primary mb-2">Primary Address</span>
                                                                        @endif
                                                                        <h6 class="card-title">{{ $address['label'] ?? 'Address' }}</h6>
                                                                        <p class="card-text mb-2">
                                                                            <strong>{{ $address['name'] ?? '' }}</strong><br>
                                                                            {{ $address['address_line_1'] ?? '' }}<br>
                                                                            @if(!empty($address['address_line_2']))
                                                                                {{ $address['address_line_2'] }}<br>
                                                                            @endif
                                                                            {{ $address['city'] ?? '' }}, {{ $address['state'] ?? '' }} {{ $address['postal_code'] ?? '' }}<br>
                                                                            {{ $address['country'] ?? '' }}<br>
                                                                            <small class="text-muted">{{ $address['phone'] ?? '' }}</small>
                                                                        </p>
                                                                        
                                                                        <div class="btn-group btn-group-sm">
                                                                            @if(!isset($address['is_primary']) || !$address['is_primary'])
                                                                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="setPrimary('{{ $address['id'] }}')">
                                                                                    Set as Primary
                                                                                </button>
                                                                            @endif
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="editAddress('{{ $address['id'] }}')">
                                                                                Edit
                                                                            </button>
                                                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteAddress('{{ $address['id'] }}')">
                                                                                Delete
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="text-center py-5">
                                                        <i class="fi-rs-marker display-1 text-muted"></i>
                                                        <h4 class="mt-3">No addresses added yet</h4>
                                                        <p class="text-muted">Add your first address to get started with deliveries.</p>
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                                            <i class="fi-rs-plus mr-5"></i>Add Your First Address
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ isset($_GET['page']) && $_GET['page'] === 'account ' ? 'active show' : '' }}" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Account Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <p>Already have an account? <a href="page-login.html">Log in instead!</a></p>
                                                <form method="post" name="enq">
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label>Name <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="name" value="{{ $currentUser['name'] }}" type="text" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Phone <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="phone" value="{{ $currentUser['phone'] }}" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Email Address <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="email" type="email" value="{{ $currentUser['email'] }}" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Current Password <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="password" type="password" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>New Password <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="npassword" type="password" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Confirm Password <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="cpassword" type="password" />
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('addresses.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="label" class="form-label">Address Label</label>
                                <input type="text" class="form-control" id="label" name="label" placeholder="e.g., Home, Office" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $currentUser['name'] }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $currentUser['phone'] }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address_line_1" class="form-label">Address Line 1</label>
                                <input type="text" class="form-control" id="address_line_1" name="address_line_1" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address_line_2" class="form-label">Address Line 2 (Optional)</label>
                                <input type="text" class="form-control" id="address_line_2" name="address_line_2">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State/Province</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country" value="Indonesia" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_primary" name="is_primary" value="1">
                                    <label class="form-check-label" for="is_primary">
                                        Set as primary address
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Address Modal -->
    <div class="modal fade" id="editAddressModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="editAddressForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_label" class="form-label">Address Label</label>
                                <input type="text" class="form-control" id="edit_label" name="label" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="edit_phone" name="phone" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="edit_address_line_1" class="form-label">Address Line 1</label>
                                <input type="text" class="form-control" id="edit_address_line_1" name="address_line_1" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="edit_address_line_2" class="form-label">Address Line 2 (Optional)</label>
                                <input type="text" class="form-control" id="edit_address_line_2" name="address_line_2">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_city" class="form-label">City</label>
                                <input type="text" class="form-control" id="edit_city" name="city" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_state" class="form-label">State/Province</label>
                                <input type="text" class="form-control" id="edit_state" name="state" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_postal_code" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="edit_postal_code" name="postal_code" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="edit_country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="edit_country" name="country" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="edit_is_primary" name="is_primary" value="1">
                                    <label class="form-check-label" for="edit_is_primary">
                                        Set as primary address
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form style="display: none" id="form-logout" action="/logout" method="POST">
        @csrf
    </form>
@endsection

@push('script')
<script>
    // Address data from PHP
    const addresses = @json($addresses);
    console.log('Addresses loaded:', addresses);
    
    function setPrimary(addressId) {
        console.log('Setting primary address:', addressId);
        
        fetch('{{ route("addresses.setPrimary") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ address_id: addressId })
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                if (typeof toastr !== 'undefined') {
                    toastr.success('Primary address updated successfully!');
                } else {
                    alert('Primary address updated successfully!');
                }
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                if (typeof toastr !== 'undefined') {
                    toastr.error(data.error || 'Failed to set primary address');
                } else {
                    alert(data.error || 'Failed to set primary address');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof toastr !== 'undefined') {
                toastr.error('An error occurred');
            } else {
                alert('An error occurred');
            }
        });
    }
    
    function editAddress(addressId) {
        console.log('Editing address:', addressId);
        
        const address = addresses.find(a => a.id === addressId);
        if (!address) {
            console.error('Address not found:', addressId);
            return;
        }
        
        // Populate form
        document.getElementById('edit_label').value = address.label || '';
        document.getElementById('edit_name').value = address.name || '';
        document.getElementById('edit_phone').value = address.phone || '';
        document.getElementById('edit_address_line_1').value = address.address_line_1 || '';
        document.getElementById('edit_address_line_2').value = address.address_line_2 || '';
        document.getElementById('edit_city').value = address.city || '';
        document.getElementById('edit_state').value = address.state || '';
        document.getElementById('edit_postal_code').value = address.postal_code || '';
        document.getElementById('edit_country').value = address.country || '';
        document.getElementById('edit_is_primary').checked = address.is_primary || false;
        
        // Set form action
        document.getElementById('editAddressForm').action = `{{ route('addresses.update', '') }}/${addressId}`;
        
        // Show modal
        new bootstrap.Modal(document.getElementById('editAddressModal')).show();
    }
    
    function deleteAddress(addressId) {
        console.log('Deleting address:', addressId);
        
        if (!confirm('Are you sure you want to delete this address?')) {
            return;
        }
        
        fetch(`{{ route('addresses.destroy', '') }}/${addressId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            console.log('Delete response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Delete response data:', data);
            if (data.success) {
                if (typeof toastr !== 'undefined') {
                    toastr.success('Address deleted successfully!');
                } else {
                    alert('Address deleted successfully!');
                }
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                if (typeof toastr !== 'undefined') {
                    toastr.error(data.error || 'Failed to delete address');
                } else {
                    alert(data.error || 'Failed to delete address');
                }
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            if (typeof toastr !== 'undefined') {
                toastr.error('An error occurred');
            } else {
                alert('An error occurred');
            }
        });
    }
</script>
@endpush
