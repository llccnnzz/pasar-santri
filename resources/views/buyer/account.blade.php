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
                                                id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab"
                                                aria-controls="dashboard" aria-selected="false">
                                                <i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ isset($_GET['page']) && $_GET['page'] === 'orders' ? 'active' : '' }}"
                                                id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab"
                                                aria-controls="orders" aria-selected="false">
                                                <i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ isset($_GET['page']) && $_GET['page'] === 'tracking' ? 'active' : '' }}"
                                                id="track-orders-tab" data-bs-toggle="tab" href="#track-orders"
                                                role="tab" aria-controls="track-orders" aria-selected="false">
                                                <i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ isset($_GET['page']) && $_GET['page'] === 'address' ? 'active' : '' }}"
                                                id="address-tab" data-bs-toggle="tab" href="#address" role="tab"
                                                aria-controls="address" aria-selected="false">
                                                <i class="fi-rs-marker mr-10"></i>My Address</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ isset($_GET['page']) && $_GET['page'] === 'account' ? 'active' : '' }}"
                                                id="account-detail-tab" data-bs-toggle="tab" href="#account-detail"
                                                role="tab" aria-controls="account-detail" aria-selected="false">
                                                <i class="fi-rs-user mr-10"></i>Account details</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content pl-50">
                                    <div class="tab-pane fade {{ !isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] === 'dashboard') ? 'active show' : '' }}"
                                        id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Hello {{ $currentUser['name'] }}!</h3>
                                            </div>
                                            <div class="card-body">
                                                <p>
                                                    From your account dashboard. you can easily check &amp; view your <a
                                                        href="#">recent orders</a>,<br />
                                                    manage your <a href="#">shipping and billing addresses</a> and <a
                                                        href="#">edit your password and account details.</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ isset($_GET['page']) && $_GET['page'] === 'orders' ? 'active show' : '' }}"
                                        id="orders" role="tabpanel" aria-labelledby="orders-tab">
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
                                                            @forelse($orders as $order)
                                                                <tr>
                                                                    {{-- Invoice --}}
                                                                    <td>{{ $order->invoice }}</td>

                                                                    {{-- Tanggal order --}}
                                                                    <td>{{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}
                                                                    </td>

                                                                    {{-- Status dengan badge --}}
                                                                    <td>
                                                                        <span class="badge bg-{{ $order->status_badge }}">
                                                                            {{ $order->status_label }}
                                                                        </span>
                                                                    </td>

                                                                    {{-- Total + jumlah item --}}
                                                                    <td>
                                                                        Rp
                                                                        {{ number_format($order->total_amount, 0, ',', '.') }}
                                                                        for {{ $order->order_items_count }}
                                                                        item{{ $order->order_items_count > 1 ? 's' : '' }}
                                                                    </td>

                                                                    {{-- Action: tombol View --}}
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-primary btn-view-order"
                                                                            data-id="{{ $order->id }}">
                                                                            <i class="fi-rs-eye"></i> View
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center text-muted">
                                                                        No orders found
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ isset($_GET['page']) && $_GET['page'] === 'tracking' ? 'active show' : '' }}"
                                        id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Orders tracking</h3>
                                            </div>
                                            <div class="card-body contact-from-area">
                                                <p>To track your order please enter your OrderID in the box below and press
                                                    "Track" button. This was given to you on your receipt and in the
                                                    confirmation email you should have received.</p>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <form class="contact-form-style mt-30 mb-50" action="#"
                                                            method="post">
                                                            <div class="input-style mb-20">
                                                                <label>Order ID</label>
                                                                <input name="order-id"
                                                                    placeholder="Found in your order confirmation email"
                                                                    type="text" />
                                                            </div>
                                                            <div class="input-style mb-20">
                                                                <label>Billing email</label>
                                                                <input name="billing-email"
                                                                    placeholder="Email you used during checkout"
                                                                    type="email" />
                                                            </div>
                                                            <button class="submit submit-auto-width"
                                                                type="submit">Track</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ isset($_GET['page']) && $_GET['page'] === 'address' ? 'active show' : '' }}"
                                        id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h3 class="mb-0">My Addresses</h3>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                                    <i class="fi-rs-plus mr-5"></i>Add New Address
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <!-- Success/Error Messages -->
                                                @if (session('success'))
                                                    <div class="alert alert-success alert-dismissible fade show"
                                                        role="alert">
                                                        {{ session('success') }}
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="alert"></button>
                                                    </div>
                                                @endif

                                                @if ($errors->any())
                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                        role="alert">
                                                        <ul class="mb-0">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="alert"></button>
                                                    </div>
                                                @endif

                                                <!-- Addresses List -->
                                                @if (!empty($addresses))
                                                    <div class="row">
                                                        @foreach ($addresses as $address)
                                                            <div class="col-md-6 mb-3">
                                                                <div
                                                                    class="card address-card {{ isset($address['is_primary']) && $address['is_primary'] ? 'border-primary' : '' }}">
                                                                    <div class="card-body">
                                                                        @if (isset($address['is_primary']) && $address['is_primary'])
                                                                            <span class="badge bg-primary mb-2">Primary
                                                                                Address</span>
                                                                        @endif
                                                                        <h6 class="card-title">
                                                                            {{ $address['label'] ?? 'Address' }}</h6>
                                                                        <p class="card-text mb-2">
                                                                            <strong>{{ $address['name'] ?? '' }}</strong><br>
                                                                            {{ $address['address_line_1'] ?? '' }}<br>
                                                                            @if (!empty($address['address_line_2']))
                                                                                {{ $address['address_line_2'] }}<br>
                                                                            @endif
                                                                            {{ $address['city'] ?? '' }},
                                                                            {{ $address['state'] ?? '' }}
                                                                            {{ $address['postal_code'] ?? '' }}<br>
                                                                            {{ $address['country'] ?? '' }}<br>
                                                                            <small
                                                                                class="text-muted">{{ $address['phone'] ?? '' }}</small>
                                                                        </p>

                                                                        <div class="btn-group btn-group-sm">
                                                                            @if (!isset($address['is_primary']) || !$address['is_primary'])
                                                                                <button type="button"
                                                                                    class="btn btn-outline-primary btn-sm"
                                                                                    onclick="setPrimary('{{ $address['id'] }}', true)">
                                                                                    Set as Primary
                                                                                </button>
                                                                            @endif
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary btn-sm"
                                                                                onclick="editAddress('{{ $address['id'] }}')">
                                                                                Edit
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn btn-outline-danger btn-sm"
                                                                                onclick="deleteAddress('{{ $address['id'] }}')">
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
                                                        <p class="text-muted">Add your first address to get started with
                                                            deliveries.</p>
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                                            <i class="fi-rs-plus mr-5"></i>Add Your First Address
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ isset($_GET['page']) && $_GET['page'] === 'account ' ? 'active show' : '' }}"
                                        id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Account Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <form method="post" name="enq">
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label>Name <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="name"
                                                                value="{{ $currentUser['name'] }}" type="text" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Phone <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="phone"
                                                                value="{{ $currentUser['phone'] }}" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Email Address <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="email"
                                                                type="email" value="{{ $currentUser['email'] }}" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Current Password <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="password"
                                                                type="password" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>New Password <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="npassword"
                                                                type="password" />
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Confirm Password <span class="required">*</span></label>
                                                            <input required="" class="form-control" name="cpassword"
                                                                type="password" />
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button type="submit"
                                                                class="btn btn-fill-out submit font-weight-bold"
                                                                name="submit" value="Submit">Save Change</button>
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

    <!-- Order Detail Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Bagian header -->
                    <div class="mb-3">
                        <strong>Invoice:</strong> <span class="order-invoice"></span><br>
                        <strong>Date:</strong> <span class="order-date"></span><br>
                        <strong>Status:</strong> <span class="order-status"></span><br>
                        <strong>Shop:</strong> <span class="order-shop"></span>
                    </div>

                    <hr>

                    <!-- Alamat -->
                    <h6>Shipping Address</h6>
                    <div class="order-address mb-3"></div>

                    <hr>

                    <!-- Items -->
                    <h6>Items</h6>
                    <table class="table table-sm order-items">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <hr>

                    <!-- Ringkasan -->
                    <h6>Payment Summary</h6>
                    <div class="order-summary"></div>

                    <hr>

                    <!-- Payment info -->
                    <h6>Latest Payment</h6>
                    <div class="order-latest-payment"></div>
                </div>
            </div>
        </div>
    </div>

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
                                <input type="text" class="form-control" id="label" name="label"
                                    placeholder="e.g., Home, Office" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $currentUser['name'] }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ $currentUser['phone'] }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address_line_1" class="form-label">Address Line 1</label>
                                <input type="text" class="form-control" id="address_line_1" name="address_line_1"
                                    required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address_line_2" class="form-label">Address Line 2 (Optional)</label>
                                <input type="text" class="form-control" id="address_line_2" name="address_line_2">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="province" class="form-label">Province</label>
                                <select class="form-control" id="province" name="province" required>
                                    <option value="">-- Select Province --</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City</label>
                                <select class="form-control" id="city" name="city" required>
                                    <option value="">-- Select City --</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subdistrict" class="form-label">Subdistrict</label>
                                <select class="form-control" id="subdistrict" name="subdistrict" required>
                                    <option value="">-- Select Subdistrict --</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="village" class="form-label">Village</label>
                                <select class="form-control" id="village" name="village" required>
                                    <option value="">-- Select Village --</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <select class="form-control" id="postal_code" name="postal_code" required>
                                    <option value="">-- Select Postal Code --</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country"
                                    value="Indonesia" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_primary" name="is_primary"
                                        value="1">
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
                                <input type="text" class="form-control" id="edit_address_line_1"
                                    name="address_line_1" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="edit_address_line_2" class="form-label">Address Line 2 (Optional)</label>
                                <input type="text" class="form-control" id="edit_address_line_2"
                                    name="address_line_2">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_province" class="form-label">Province</label>
                                <select class="form-control" id="edit_province" name="province" required>
                                    <option value="">-- Select Province --</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_city" class="form-label">City</label>
                                <select class="form-control" id="edit_city" name="city" required>
                                    <option value="">-- Select City --</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_subdistrict" class="form-label">Subdistrict</label>
                                <select class="form-control" id="edit_subdistrict" name="subdistrict" required>
                                    <option value="">-- Select Subdistrict --</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_village" class="form-label">Village</label>
                                <select class="form-control" id="edit_village" name="village" required>
                                    <option value="">-- Select Village --</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_postal_code" class="form-label">Postal Code</label>
                                <select class="form-control" id="edit_postal_code" name="postal_code" required>
                                    <option value="">-- Select Postal Code --</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="edit_country" name="country" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="edit_is_primary"
                                        name="is_primary" value="1">
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
    <script script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let provinces = [];
        let cities = [];
        let subdistricts = [];
        let villages = [];
        let postals = [];

        function initAddressDropdown(prefix = '') {
            const $province = $(`#${prefix}province`);
            const $city = $(`#${prefix}city`);
            const $subdistrict = $(`#${prefix}subdistrict`);
            const $village = $(`#${prefix}village`);
            const $postal = $(`#${prefix}postal_code`);

            // Load JSON (hanya sekali)
            if (!provinces.length) {
                $.getJSON("{{ asset('assets/js/provinces.json') }}", function(data) {
                    provinces = data.sort((a, b) => a.name.localeCompare(b.name));
                    $.each(provinces, function(_, prov) {
                        $province.append(`<option value="${prov.name}">${prov.name}</option>`);
                    });
                });
                $.getJSON("{{ asset('assets/js/cities.json') }}", function(data) {
                    cities = data;
                });
                $.getJSON("{{ asset('assets/js/sub_districts.json') }}", function(data) {
                    subdistricts = data;
                });
                $.getJSON("{{ asset('assets/js/villages.json') }}", function(data) {
                    villages = data;
                });
                $.getJSON("{{ asset('assets/js/postal_codes.json') }}", function(data) {
                    postals = data;
                });
            }

            // Province -> City
            $province.on('change', function() {
                const provName = $(this).val();

                const provObj = provinces.find(p => p.name === provName);
                const provId = provObj ? provObj.id : null;

                $city.html('<option value="">-- Select City --</option>');
                $subdistrict.html('<option value="">-- Select Subdistrict --</option>');
                $village.html('<option value="">-- Select Village --</option>');
                $postal.html('<option value="">-- Select Postal Code --</option>');

                const filteredCities = cities
                    .filter(c => c.province_id == provId)
                    .sort((a, b) => a.name.localeCompare(b.name));

                $.each(filteredCities, function(_, city) {
                    $city.append(`<option value="${city.name}">${city.name}</option>`);
                });
            });


            // City -> Subdistrict
            $city.on('change', function() {
                const cityName = $(this).val();
                const cityObj = cities.find(c => c.name === cityName);
                const cityId = cityObj ? cityObj.id : null;

                $subdistrict.html('<option value="">-- Select Subdistrict --</option>');
                $village.html('<option value="">-- Select Village --</option>');
                $postal.html('<option value="">-- Select Postal Code --</option>');

                const filteredSubs = subdistricts
                    .filter(s => s.city_id == cityId)
                    .sort((a, b) => a.name.localeCompare(b.name));

                $.each(filteredSubs, function(_, sub) {
                    $subdistrict.append(
                        `<option value="${sub.name}">${sub.name}</option>`
                    );
                });
            });

            // Subdistrict -> Village
            $subdistrict.on('change', function() {
                const subName = $(this).val();
                const subObj = subdistricts.find(s => s.name === subName);
                const subId = subObj ? subObj.id : null;

                $village.html('<option value="">-- Select Village --</option>');
                $postal.html('<option value="">-- Select Postal Code --</option>');

                const filteredVillages = villages
                    .filter(v => v.sub_district_id == subId)
                    .sort((a, b) => a.name.localeCompare(b.name));

                $.each(filteredVillages, function(_, vill) {
                    $village.append(
                        `<option value="${vill.name}">${vill.name}</option>`
                    );
                });
            });

            // Village -> Postal Code
            $village.on('change', function() {
                const villName = $(this).val();
                const subName = $subdistrict.val();

                const subObj = subdistricts.find(s => s.name === subName);
                const subId = subObj ? subObj.id : null;

                const villObj = villages.find(v => v.name === villName && v.sub_district_id == subId);
                const villId = villObj ? villObj.id : null;

                $postal.html('<option value="">-- Select Postal Code --</option>');

                const filteredPostals = postals
                    .filter(pc => Array.isArray(pc.village_id) && pc.village_id.includes(villId))
                    .sort((a, b) => a.name.localeCompare(b.name));

                $.each(filteredPostals, function(_, pc) {
                    $postal.append(
                        `<option value="${pc.name}">${pc.name}</option>`
                    );
                });
            });
        }

        $(document).ready(function() {
            // Init untuk store form
            initAddressDropdown();

            // Init untuk edit form
            initAddressDropdown('edit_');
        });

        // Address data from PHP
        const addresses = @json($addresses);
        console.log('Addresses loaded:', addresses);

        // Edit address function
        function editAddress(addressId) {
            console.log('Editing address:', addressId);

            const address = addresses.find(a => a.id === addressId);
            if (!address) {
                console.error('Address not found:', addressId);
                return;
            }

            // Populate form fields
            $('#edit_label').val(address.label || '');
            $('#edit_name').val(address.name || '');
            $('#edit_phone').val(address.phone || '');
            $('#edit_address_line_1').val(address.address_line_1 || '');
            $('#edit_address_line_2').val(address.address_line_2 || '');
            $('#edit_country').val(address.country || '');
            $('#edit_is_primary').prop('checked', address.is_primary || false);

            // Set Province first
            $('#edit_province').val(address.province).trigger('change');

            // Delay untuk memastikan city sudah terpopulate sesuai province
            setTimeout(() => {
                $('#edit_city').val(address.city).trigger('change');

                // Delay untuk subdistrict
                setTimeout(() => {
                    $('#edit_subdistrict').val(address.subdistrict).trigger('change');

                    // Delay untuk village
                    setTimeout(() => {
                        $('#edit_village').val(address.village).trigger('change');

                        // Delay untuk postal code
                        setTimeout(() => {
                            $('#edit_postal_code').val(address.postal_code).trigger(
                                'change');
                        }, 100);
                    }, 100);
                }, 100);
            }, 100);

            // Set form action
            $('#editAddressForm').attr('action', `{{ route('addresses.update', '') }}/${addressId}`);

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
        $(document).on('click', '.btn-view-order', function(e) {
            e.preventDefault();
            let orderId = $(this).data('id');

            $.get("{{ url('/me/orders') }}/" + orderId, function(res) {
                // Header
                $('#orderModal .modal-title').text('Order ' + res.invoice);
                $('#orderModal .order-invoice').text(res.invoice);
                $('#orderModal .order-date').text(res.created_at);
                $('#orderModal .order-status').html(
                    `<span class="badge bg-${res.status_badge}">${res.status}</span>`
                );
                $('#orderModal .order-shop').text(res.shop ? res.shop.name : '-');

                // Alamat
                let addr = res.address;
                if (addr) {
                    $('#orderModal .order-address').html(`
                <strong>${addr.name}</strong><br>
                ${addr.address_line_1 ?? ''}<br>
                ${addr.city ?? ''}, ${addr.province ?? ''} ${addr.postal_code ?? ''}<br>
                ${addr.country ?? ''}<br>
                Phone: ${addr.phone ?? ''}
            `);
                }

                // Items
                let itemsHtml = '';
                res.items.forEach(i => {
                    itemsHtml += `
                <tr>
                    <td><img src="${i.image}" alt="" width="40"></td>
                    <td>${i.name}</td>
                    <td>${i.quantity}</td>
                    <td>Rp ${parseInt(i.price).toLocaleString('id-ID')}</td>
                    <td>Rp ${parseInt(i.item_total).toLocaleString('id-ID')}</td>
                </tr>`;
                });
                $('#orderModal .order-items tbody').html(itemsHtml);

                // Payment summary
                let pay = res.payment;
                if (pay) {
                    $('#orderModal .order-summary').html(`
                Subtotal: Rp ${parseInt(pay.subtotal).toLocaleString('id-ID')}<br>
                Shipping: Rp ${parseInt(pay.shipping_cost).toLocaleString('id-ID')}<br>
                Discount: Rp ${parseInt(pay.discount_amount).toLocaleString('id-ID')}<br>
                Total: <strong>Rp ${parseInt(pay.total_amount).toLocaleString('id-ID')}</strong>
            `);
                }

                // Latest payment
                let lp = res.latest_payment;
                if (lp) {
                    $('#orderModal .order-latest-payment').html(`
                Method: ${lp.channel}<br>
                Status: ${lp.status}<br>
                Value: Rp ${parseInt(lp.value).toLocaleString('id-ID')}<br>
                Fee: Rp ${parseInt(lp.payment_fee).toLocaleString('id-ID')}<br>
                Total Paid: Rp ${parseInt(lp.total_amount).toLocaleString('id-ID')}
            `);
                } else {
                    $('#orderModal .order-latest-payment').html('<em>No payment recorded</em>');
                }

                // Tampilkan modal
                let modal = new bootstrap.Modal(document.getElementById('orderModal'));
                modal.show();
            });
        });
    </script>
@endpush
