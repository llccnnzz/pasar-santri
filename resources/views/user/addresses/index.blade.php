@extends('layouts.landing.component.app')

@section('title', 'Manage Addresses')

@section('content')
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> <a href="{{ route('account') }}">Account</a>
                <span></span> Addresses
            </div>
        </div>
    </div>
    
    <div class="page-content pt-50 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <!-- Sidebar -->
                        <div class="col-md-3">
                            <div class="dashboard-menu">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('account') }}">
                                            <i class="fi-rs-settings-sliders mr-10"></i>Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('wishlist.index') }}">
                                            <i class="fi-rs-heart mr-10"></i>Wishlist
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('addresses.index') }}">
                                            <i class="fi-rs-marker mr-10"></i>Addresses
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="col-md-9">
                            <div class="tab-content account dashboard-content pl-50">
                                <div class="tab-pane fade active show">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Manage Addresses</h3>
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

                                            <!-- Add New Address Button -->
                                            <div class="text-end mb-3">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                                    <i class="fi-rs-plus mr-5"></i>Add New Address
                                                </button>
                                            </div>

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
                                                                        <form method="POST" action="{{ route('addresses.destroy', $address['id']) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                                                        </form>
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
                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ auth()->user()->phone }}" required>
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
@endsection

@push('script')
<script>
    // Address data from PHP
    const addresses = @json($addresses);
    
    function setPrimary(addressId) {
        fetch('{{ route("addresses.setPrimary") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ address_id: addressId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.error || 'Failed to set primary address');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
        });
    }
    
    function editAddress(addressId) {
        const address = addresses.find(a => a.id === addressId);
        if (!address) return;
        
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
</script>
@endpush
