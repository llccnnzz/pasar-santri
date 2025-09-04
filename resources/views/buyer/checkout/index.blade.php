@extends('layouts.landing.component.app')

@section('title', 'Checkout')
@section('description', 'Checkout Page')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Checkout
                </div>
            </div>
        </div>

        <div class="container mb-80 mt-50">
            <h1 class="heading-2 mb-4 px-3">Checkout</h1>
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    {{-- LEFT COLUMN --}}
                    <div class="col-lg-8">
                        <div class="px-3">
                            {{-- Alamat Pengiriman --}}
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Alamat Pengiriman</h5>
                                </div>
                                <div class="card-body p-3" id="selected_address" style="cursor: pointer;"
                                    data-bs-toggle="modal" data-bs-target="#addressModal">
                                    @php
                                        $primaryAddress =
                                            collect($addresses)->firstWhere('is_primary', true) ??
                                            ($addresses[0] ?? null);
                                    @endphp

                                    @if ($primaryAddress)
                                        <h6>{{ $primaryAddress['label'] }}</h6>
                                        <p class="mb-0">{{ $primaryAddress['name'] }} - {{ $primaryAddress['phone'] }}</p>
                                        <p class="small text-muted">{{ $primaryAddress['address_line_1'] }},
                                            {{ $primaryAddress['city'] }}</p>
                                    @else
                                        <p class="text-muted">Belum ada alamat tersedia. Tambahkan alamat terlebih dahulu.
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- hidden input untuk address_id --}}
                            <input type="hidden" id="address_id" name="address_id"
                                value="{{ $primaryAddress['id'] ?? '' }}">

                            {{-- Pilih Kurir per Shop --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Pilih Kurir</h5>
                                </div>
                                <div class="card-body">
                                    @foreach (collect($cartItems)->groupBy('shop_id') as $shopId => $items)
                                        <div class="mb-3">
                                            <label for="courier_{{ $shopId }}" class="form-label">
                                                {{ $items[0]['shop_name'] ?? 'Toko' }}
                                            </label>
                                            <select class="form-control courier-select" id="courier_{{ $shopId }}"
                                                name="shipping[{{ $shopId }}][method_id]"
                                                data-shop="{{ $shopId }}">
                                                <option value="">-- pilih kurir --</option>
                                            </select>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Pilih Metode Pembayaran --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Metode Pembayaran</h5>
                                </div>
                                <div class="card-body">
                                    <select class="form-control" name="payment_method" id="payment_method">
                                        <option value="auto">Auto Paid (sementara)</option>
                                        <option value="transfer">Transfer Bank</option>
                                        <option value="cod">COD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="col-lg-4">
                        <div class="card p-3">
                            <h5 class="mb-3">Ringkasan Pesanan</h5>

                            @foreach ($cartItems as $item)
                                <div class="d-flex mb-4">
                                    {{-- Foto produk --}}
                                    <div style="width: 100px; height: 100px; overflow: hidden; border-radius: 10px; background:#f9f9f9;"
                                        class="me-3">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid"
                                            style="object-fit: cover; width:100%; height:100%;">
                                    </div>

                                    {{-- Detail produk --}}
                                    <div class="flex-grow-1 d-flex flex-column justify-content-between">
                                        <p class="fw-bold mb-2">{{ $item['name'] }}</p>

                                        {{-- Qty + Harga --}}
                                        <div class="d-flex align-items-center mb-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary me-2 qty-minus"
                                                data-id="{{ $item['id'] }}"
                                                data-shop="{{ $item['shop_id'] }}">-</button>

                                            <input type="number" class="form-control form-control-sm text-center item-qty"
                                                style="width:70px;" value="{{ $item['quantity'] }}" min="1"
                                                max="{{ $item['stock'] ?? 0 }}" data-id="{{ $item['id'] }}"
                                                data-price="{{ $item['price'] }}" data-stock="{{ $item['stock'] ?? 0 }}"
                                                data-shop="{{ $item['shop_id'] }}">

                                            <button type="button" class="btn btn-sm btn-outline-secondary ms-2 qty-plus"
                                                data-id="{{ $item['id'] }}"
                                                data-shop="{{ $item['shop_id'] }}">+</button>

                                            <span class="ms-auto fw-bold">
                                                Rp{{ number_format($item['price'], 0, ',', '.') }}
                                            </span>
                                        </div>


                                        <div class="d-flex justify-content-between small text-muted">
                                            <span>Subtotal:</span>
                                            <span id="subtotal_{{ $item['id'] }}">
                                                Rp{{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between small text-muted">
                                            <span>Ongkir:</span>
                                            <span id="shipping_{{ $item['id'] }}">Rp0</span>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1 fw-bold">
                                            <span>Total:</span>
                                            <span id="total_{{ $item['id'] }}">
                                                Rp{{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <hr>
                            <div class="d-flex justify-content-between">
                                <span><strong>Grand Total:</strong></span>
                                <span id="grand_total" class="fw-bold">Rp0</span>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3">Buat Pesanan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    {{-- Modal Pilih Alamat --}}
    <div class="modal fade" id="addressModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Alamat</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($addresses as $index => $address)
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 address-card" data-id="{{ $address['id'] }}"
                                    data-index="{{ $index }}">
                                    <h6>{{ $address['label'] }}</h6>
                                    <p class="mb-0">{{ $address['name'] }} - {{ $address['phone'] }}</p>
                                    <p class="small text-muted">{{ $address['address_line_1'] }}, {{ $address['city'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addressId = document.getElementById('address_id').value;
            if (addressId) {
                loadShippingMethods(addressId);
            }

            // ganti address
            document.querySelectorAll('.address-card').forEach(card => {
                card.addEventListener('click', function() {
                    document.getElementById('selected_address').innerHTML = this.innerHTML;
                    document.getElementById('address_id').value = this.dataset.id;

                    bootstrap.Modal.getInstance(document.getElementById('addressModal')).hide();

                    loadShippingMethods(this.dataset.id);
                });
            });

            // qty plus
            document.querySelectorAll(".qty-plus").forEach(btn => {
                btn.addEventListener("click", function() {
                    const input = document.querySelector(".item-qty[data-id='" + this.dataset.id +
                        "']");
                    let qty = parseInt(input.value) || 0;
                    const stock = parseInt(input.dataset.stock) || 0;
                    if (qty < stock) input.value = qty + 1;
                    updateTotals();
                });
            });

            // qty minus
            document.querySelectorAll(".qty-minus").forEach(btn => {
                btn.addEventListener("click", function() {
                    const input = document.querySelector(".item-qty[data-id='" + this.dataset.id +
                        "']");
                    let qty = parseInt(input.value) || 0;
                    if (qty > 1) input.value = qty - 1;
                    updateTotals();
                });
            });

            // qty manual
            document.querySelectorAll(".item-qty").forEach(input => {
                input.addEventListener("input", function() {
                    let qty = parseInt(this.value) || 1;
                    const stock = parseInt(this.dataset.stock) || 0;
                    if (qty < 1) qty = 1;
                    if (stock > 0 && qty > stock) qty = stock;
                    this.value = qty;
                    updateTotals();
                });
            });

            updateTotals();
        });

        function loadShippingMethods(addressId) {
            fetch("{{ route('checkout.shippingMethods') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        address_id: addressId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    for (const shopId in data) {
                        const selectEl = document.getElementById('courier_' + shopId);
                        if (!selectEl) continue;
                        selectEl.innerHTML = "<option value=''>-- pilih kurir --</option>";

                        data[shopId].forEach(method => {
                            const opt = document.createElement("option");
                            opt.value = method.shipping_method_id;
                            opt.text =
                                `${method.courier_name} - ${method.service_name} (${method.description || ''})`;
                            selectEl.appendChild(opt);
                        });

                        selectEl.onchange = function() {
                            if (!this.value) return;
                            loadRates(addressId, this.value, shopId);
                        }
                    }
                });
        }

        document.querySelectorAll(".qty-plus").forEach(btn => {
            btn.addEventListener("click", function() {
                const input = document.querySelector(".item-qty[data-id='" + this.dataset.id + "']");
                let qty = parseInt(input.value) || 0;
                const stock = parseInt(input.dataset.stock) || 0;
                if (qty < stock) input.value = qty + 1;
                updateTotals(this.dataset.shop);
            });
        });

        document.querySelectorAll(".qty-minus").forEach(btn => {
            btn.addEventListener("click", function() {
                const input = document.querySelector(".item-qty[data-id='" + this.dataset.id + "']");
                let qty = parseInt(input.value) || 0;
                if (qty > 1) input.value = qty - 1;
                updateTotals(this.dataset.shop);
            });
        });

        document.querySelectorAll(".item-qty").forEach(input => {
            input.addEventListener("input", function() {
                let qty = parseInt(this.value) || 1;
                const stock = parseInt(this.dataset.stock) || 0;
                if (qty < 1) qty = 1;
                if (stock > 0 && qty > stock) qty = stock;
                this.value = qty;
                updateTotals(this.dataset.shop);
            });
        });

        function updateTotals(shopId = null) {
            let grandTotal = 0;

            document.querySelectorAll(".item-qty").forEach(input => {
                const id = input.dataset.id;
                const qty = parseInt(input.value) || 0;
                const price = parseInt(input.dataset.price) || 0;

                const subtotal = qty * price;
                document.getElementById("subtotal_" + id).innerText = formatRupiah(subtotal);

                const shipping = parseInt(document.getElementById("shipping_" + id).innerText.replace(/\D/g, "")) ||
                    0;
                const total = subtotal + shipping;

                document.getElementById("total_" + id).innerText = formatRupiah(total);

                grandTotal += total;
            });

            document.getElementById("grand_total").innerText = formatRupiah(grandTotal);
        }

        function loadRates(addressId, methodId, shopId) {
            fetch("{{ route('checkout.rates') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        address_id: addressId,
                        method_id: methodId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log("Response rates:", data);
                    console.log("ShopId:", shopId);

                    const rate = data[shopId] || null;
                    console.log("Picked rate:", rate);

                    if (!rate) return;

                    document.querySelectorAll(`.item-qty[data-shop='${shopId}']`).forEach(input => {
                        const id = input.dataset.id;
                        const qty = parseInt(input.value) || 0;
                        const price = parseInt(input.dataset.price) || 0;
                        const subtotal = qty * price;

                        console.log("Update item:", id, "Subtotal:", subtotal, "Ongkir:", rate.price);

                        document.getElementById("shipping_" + id).innerText = formatRupiah(rate.price);
                        document.getElementById("subtotal_" + id).innerText = formatRupiah(subtotal);
                        document.getElementById("total_" + id).innerText = formatRupiah(subtotal + rate.price);
                    });

                    updateTotals(shopId);
                })
                .catch(err => {
                    console.error("Error loadRates:", err);
                });
        }

        function formatRupiah(num) {
            return 'Rp' + new Intl.NumberFormat('id-ID').format(num);
        }
    </script>
@endsection
