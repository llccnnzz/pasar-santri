@extends('layouts.landing.component.app')

@section('title', 'Checkout')
@section('description', 'Checkout Page')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .courier-card {
            cursor: pointer;
            transition: all 0.2s ease;
            border: 2px solid #e9ecef !important;
        }

        .courier-card:hover {
            border-color: #dee2e6 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .courier-card.border-primary {
            border-color: #0d6efd !important;
        }

        .courier-card.bg-light {
            background-color: #f8f9fa !important;
        }

        .courier-logo {
            border-radius: 4px;
            background: #fff;
            padding: 4px;
            border: 1px solid #e9ecef;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .service-dropdown {
            animation: slideDown 0.2s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-select-sm {
            font-size: 0.875rem;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        .cache-indicator {
            font-size: 0.7rem;
            color: #6c757d;
            font-style: italic;
        }

        .rate-info {
            transition: all 0.2s ease;
        }
    </style>
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
            <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
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
                                        <div class="mb-4">
                                            <h6 class="mb-3">{{ $items[0]['shop_name'] ?? 'Toko' }}</h6>
                                            <div id="courier_options_{{ $shopId }}" class="row g-3">
                                                <div class="col-12 text-center text-muted">
                                                    <div class="spinner-border spinner-border-sm me-2" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    Memuat kurir tersedia...
                                                </div>
                                            </div>
                                            <input type="hidden" name="shipping[{{ $shopId }}][method_id]" id="shipping_method_{{ $shopId }}">
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
                                        <option value="auto">Emaal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="col-lg-4">
                        <div class="card p-3">
                            <h5 class="mb-3">Ringkasan Pesanan</h5>

                            @php
                                $grouped = collect($cartItems)->groupBy('shop_id');
                                $grandTotalInit = 0;
                            @endphp

                            @foreach ($grouped as $shopId => $items)
                                <div class="mb-4">
                                    <h6 class="mb-3">{{ $items[0]['shop_name'] ?? 'Toko' }}</h6>

                                    {{-- Produk di toko ini --}}
                                    @php $shopSubtotal = 0; @endphp
                                    @foreach ($items as $item)
                                        @php
                                            $qty = $item['available_quantity'];
                                            $subtotal = $qty * $item['price'];
                                            $shopSubtotal += $subtotal;
                                            $shopPaymentFee = ($paymentFeeConfig['type'] === 'fixed')
                                                ? $paymentFeeConfig['fixed']
                                                : max(($paymentFeeConfig['percent'] / 100) * $shopSubtotal, $paymentFeeConfig['percent_min_value']);
                                        @endphp

                                        <div class="d-flex mb-3">
                                            {{-- Gambar 50% --}}
                                            <div style="width: 50%; height: 120px; overflow: hidden; border-radius: 10px; background:#f9f9f9;"
                                                class="me-3">
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                    class="img-fluid h-100 w-100" style="object-fit: cover;">
                                            </div>

                                            {{-- Informasi 50% --}}
                                            <div class="flex-grow-1 small">
                                                <p class="mb-2 fw-bold">{{ $item['name'] }}</p>
                                                <p class="mb-1">Price: Rp{{ number_format($item['price'], 0, ',', '.') }}
                                                </p>
                                                <p class="mb-1">Qty: {{ $qty }}</p>
                                                <p class="mb-0">Subtotal: Rp{{ number_format($subtotal, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Total (subtotal semua produk per shop) --}}
                                    <div class="d-flex justify-content-between fw-bold fs-6 mt-2">
                                        <span>Total:</span>
                                        <span id="total_shop_{{ $shopId }}">
                                            Rp{{ number_format($shopSubtotal, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between fw-bold fs-6 mt-2">
                                        <span>Payment fee:<br>{{ $paymentFeeConfig['type'] === 'fixed' ? 'Rp. '.$paymentFeeConfig['fixed'] : $paymentFeeConfig['percent'].'%, minimum Rp. '.$paymentFeeConfig['percent_min_value'] }}</span>
                                        <span id="total_payment_fee_{{ $shopId }}">
                                            Rp{{ number_format($shopPaymentFee, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    {{-- Ongkir per shop --}}
                                    <div class="d-flex justify-content-between fs-6 mt-1">
                                        <span>Ongkir:</span>
                                        <span id="shipping_shop_{{ $shopId }}">Rp0</span>
                                    </div>
                                </div>

                                @php
                                    $grandTotalInit += ($shopSubtotal + $shopPaymentFee);
                                @endphp
                            @endforeach

                            <hr>

                            {{-- Promo Code Section --}}
                            <div class="mb-4">
                                <div id="promo_form_section">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="promo_code_input"
                                               placeholder="Masukkan kode promo">
                                        <button class="btn btn-outline-primary" type="button" id="apply_promo_btn">
                                            <span class="apply-text">Terapkan</span>
                                            <span class="spinner-border spinner-border-sm d-none" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>

                                {{-- Applied Promo Display --}}
                                <div id="applied_promo_section" class="d-none">
                                    <div class="card border-success">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1 text-success">
                                                        <i class="fa fa-tags me-1"></i>
                                                        <span id="applied_promo_name"></span>
                                                    </h6>
                                                    <small class="text-muted">Kode: <span id="applied_promo_code"></span></small>
                                                </div>
                                                <div class="text-end">
                                                    <div class="text-success fw-bold">
                                                        -Rp<span id="applied_promo_amount"></span>
                                                    </div>
                                                    <button class="btn btn-sm btn-outline-danger mt-1" type="button" id="remove_promo_btn">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Discount Row --}}
                            <div class="d-flex justify-content-between fs-6 mb-2" id="discount_row" style="display: none !important;">
                                <span class="text-success">Diskon:</span>
                                <span id="total_discount" class="text-success">-Rp0</span>
                            </div>

                            {{-- Grand Total --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold" style="font-size: 1.5rem;">Grand Total:</span>
                                <span id="grand_total_all" class="fw-bold" style="font-size: 1.5rem;">
                                    Rp{{ number_format($grandTotalInit, 0, ',', '.') }}
                                </span>
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
        // Cache for shipping rates to avoid redundant API calls
        let shippingRatesCache = {};
        let currentAddressId = null;

        document.addEventListener("DOMContentLoaded", function() {
            const addressId = document.getElementById('address_id').value;
            if (addressId) {
                currentAddressId = addressId;
                loadShippingMethods(addressId);
            }

            // ganti address
            document.querySelectorAll('.address-card').forEach(card => {
                card.addEventListener('click', function() {
                    document.getElementById('selected_address').innerHTML = this.innerHTML;
                    document.getElementById('address_id').value = this.dataset.id;

                    bootstrap.Modal.getInstance(document.getElementById('addressModal')).hide();

                    // Clear cache when address changes
                    const newAddressId = this.dataset.id;
                    if (currentAddressId !== newAddressId) {
                        clearShippingRatesCache();
                        currentAddressId = newAddressId;
                    }

                    loadShippingMethods(this.dataset.id);
                });
            });

            // Form validation before submission
            document.getElementById('checkoutForm').addEventListener('submit', function(e) {
                e.preventDefault();

                if (validateForm()) {
                    this.submit();
                }
            });
        });

        function clearShippingRatesCache() {
            shippingRatesCache = {};
            console.log('Shipping rates cache cleared due to address change');
        }

        function getCacheKey(addressId, methodId, shopId) {
            return `${addressId}_${methodId}_${shopId}`;
        }

        function getCachedRate(addressId, methodId, shopId) {
            const cacheKey = getCacheKey(addressId, methodId, shopId);
            return shippingRatesCache[cacheKey] || null;
        }

        function setCachedRate(addressId, methodId, shopId, rateData) {
            const cacheKey = getCacheKey(addressId, methodId, shopId);
            shippingRatesCache[cacheKey] = {
                data: rateData,
                timestamp: Date.now()
            };
            console.log(`Cached rate for ${cacheKey}:`, rateData);
        }

        // Debug function to view cache status
        function getCacheStats() {
            const cacheSize = Object.keys(shippingRatesCache).length;
            console.log(`Shipping rates cache contains ${cacheSize} entries:`, shippingRatesCache);
            return {
                size: cacheSize,
                entries: Object.keys(shippingRatesCache),
                data: shippingRatesCache
            };
        }

        // Function to manually clear cache (for debugging)
        function clearCache() {
            clearShippingRatesCache();
            console.log('Cache manually cleared');
        }

        function validateForm() {
            const shippingInputs = document.querySelectorAll('input[name*="shipping"][name*="method_id"]');
            let allValid = true;
            let missingShops = [];

            shippingInputs.forEach(input => {
                const shopId = input.id.replace('shipping_method_', '');
                const shopName = document.querySelector(`#courier_options_${shopId}`).closest('.mb-4').querySelector('h6').textContent;

                if (!input.value) {
                    allValid = false;
                    missingShops.push(shopName);
                }
            });

            if (!allValid) {
                alert(`Silakan pilih kurir untuk: ${missingShops.join(', ')}`);
                return false;
            }

            return true;
        }

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
                        const methods = data[shopId];
                        renderCourierOptions(shopId, methods);
                    }
                })
                .catch(err => {
                    console.error("Error loading shipping methods:", err);
                    // Show error state for all shops
                    document.querySelectorAll("[id^='courier_options_']").forEach(container => {
                        container.innerHTML = `
                            <div class="col-12 text-center text-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Gagal memuat kurir. Silakan refresh halaman.
                            </div>`;
                    });
                });
        }

        function renderCourierOptions(shopId, methods) {
            const container = document.getElementById('courier_options_' + shopId);
            if (!container || !methods.length) {
                container.innerHTML = `
                    <div class="col-12 text-center text-muted">
                        <i class="fas fa-info-circle me-2"></i>
                        Tidak ada kurir tersedia untuk toko ini
                    </div>`;
                return;
            }

            // Group methods by courier_code
            const groupedMethods = methods.reduce((groups, method) => {
                const key = method.courier_code;
                if (!groups[key]) {
                    groups[key] = {
                        courier_code: method.courier_code,
                        courier_name: method.courier_name,
                        logo_url: method.logo_url,
                        methods: []
                    };
                }
                groups[key].methods.push(method);
                return groups;
            }, {});

            let html = '';
            for (const courierCode in groupedMethods) {
                const courier = groupedMethods[courierCode];
                html += createCourierCard(shopId, courier);
            }

            container.innerHTML = html;

            // Bind event listeners
            bindCourierEvents(shopId);
        }

        function createCourierCard(shopId, courier) {
            const radioId = `courier_${shopId}_${courier.courier_code}`;
            const dropdownId = `methods_${shopId}_${courier.courier_code}`;

            let methodOptions = '<option value="">-- Pilih layanan --</option>';
            courier.methods.forEach(method => {
                methodOptions += `<option value="${method.shipping_method_id}" data-courier-code="${method.courier_code}" data-service-code="${method.service_code}">
                    ${method.service_name} ${method.description ? '(' + method.description + ')' : ''}
                </option>`;
            });

            return `
                <div class="col-md-6 col-lg-4">
                    <div class="card courier-card border-2" data-shop-id="${shopId}" data-courier-code="${courier.courier_code}" onclick="selectCourier('${shopId}', '${courier.courier_code}')">
                        <div class="card-body p-3">
                            <div class="form-check">
                                <input class="form-check-input courier-radio" type="radio"
                                       name="courier_${shopId}" id="${radioId}"
                                       data-shop-id="${shopId}" data-courier-code="${courier.courier_code}">
                                <label class="form-check-label w-100" for="${radioId}">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="${courier.logo_url}" alt="${courier.courier_name}"
                                             class="courier-logo me-2" style="width: 40px; height: 40px; object-fit: contain;">
                                        <div>
                                            <h6 class="mb-0">${courier.courier_name}</h6>
                                            <small class="text-muted">${courier.methods.length} layanan tersedia</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="service-dropdown" style="display: none;">
                                <select class="form-select form-select-sm mt-2 service-select"
                                        id="${dropdownId}" data-shop-id="${shopId}" onclick="event.stopPropagation();">
                                    ${methodOptions}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>`;
        }

        function selectCourier(shopId, courierCode) {
            const radio = document.querySelector(`input[name="courier_${shopId}"][data-courier-code="${courierCode}"]`);
            if (radio) {
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            }
        }

        function bindCourierEvents(shopId) {
            // Handle courier radio selection
            document.querySelectorAll(`input[name="courier_${shopId}"]`).forEach(radio => {
                radio.addEventListener('change', function() {
                    const shopId = this.dataset.shopId;
                    const courierCode = this.dataset.courierCode;

                    // Hide all dropdowns for this shop
                    document.querySelectorAll(`[data-shop-id="${shopId}"] .service-dropdown`).forEach(dropdown => {
                        dropdown.style.display = 'none';
                    });

                    // Remove selection styling from all cards
                    document.querySelectorAll(`[data-shop-id="${shopId}"] .courier-card`).forEach(card => {
                        card.classList.remove('border-primary', 'bg-light');
                    });

                    // Show dropdown for selected courier
                    const selectedCard = document.querySelector(`[data-shop-id="${shopId}"][data-courier-code="${courierCode}"]`);
                    if (selectedCard) {
                        selectedCard.classList.add('border-primary', 'bg-light');
                        const dropdown = selectedCard.querySelector('.service-dropdown');
                        dropdown.style.display = 'block';

                        // Reset shipping method selection
                        document.getElementById(`shipping_method_${shopId}`).value = '';

                        // Reset shipping cost display
                        resetShippingCost(shopId);
                    }
                });
            });

            // Handle service selection
            document.querySelectorAll(`[data-shop-id="${shopId}"] .service-select`).forEach(select => {
                select.addEventListener('change', function() {
                    const shopId = this.dataset.shopId;
                    const methodId = this.value;

                    // Update hidden input
                    document.getElementById(`shipping_method_${shopId}`).value = methodId;

                    if (methodId) {
                        const addressId = document.getElementById('address_id').value;

                        // Check cache first
                        const cachedRate = getCachedRate(addressId, methodId, shopId);
                        if (cachedRate) {
                            console.log(`Using cached rate for shop ${shopId}, method ${methodId}`);
                            applyCachedRate(shopId, cachedRate.data);
                        } else {
                            console.log(`Loading fresh rate for shop ${shopId}, method ${methodId}`);
                            loadRates(addressId, methodId, shopId);
                        }
                    } else {
                        // Reset shipping cost if no method selected
                        resetShippingCost(shopId);
                    }
                });
            });
        }

        function updateTotals() {
            let grandTotal = 0;

            document.querySelectorAll("[id^='total_shop_']").forEach(shopTotalEl => {
                const shopId = shopTotalEl.id.replace("total_shop_", "");
                const subtotal = parseInt(shopTotalEl.innerText.replace(/\D/g, "")) || 0;
                const shippingEl = document.getElementById("shipping_shop_" + shopId);
                const shipping = parseInt(shippingEl.innerText.replace(/\D/g, "")) || 0;
                const paymentFeeEl = document.getElementById("total_payment_fee_" + shopId);
                const paymentFee = parseInt(paymentFeeEl.innerText.replace(/\D/g, "")) || 0;
                grandTotal += subtotal + shipping + paymentFee;
            });

            // Apply discount if promo is applied
            if (appliedPromo) {
                grandTotal -= appliedPromo.discount_amount;
            }

            document.getElementById("grand_total_all").innerText = formatRupiah(grandTotal);
        }

        function loadRates(addressId, methodId, shopId) {
            // Show loading indicator
            showShippingLoadingState(shopId);

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
                    const rate = data[shopId] || null;
                    if (rate) {
                        // Cache the rate for future use
                        setCachedRate(addressId, methodId, shopId, rate);

                        // Apply the rate with fresh indicator
                        applyFreshRate(shopId, rate);
                    } else {
                        console.warn(`No rate found for shop ${shopId}`);
                        resetShippingCost(shopId);
                    }
                })
                .catch(err => {
                    console.error("Error loadRates:", err);
                    resetShippingCost(shopId);
                    showRateError(shopId);
                });
        }

        function applyCachedRate(shopId, rateData) {
            const shippingEl = document.getElementById("shipping_shop_" + shopId);
            if (shippingEl && rateData.price) {
                // Create rate display with cache indicator
                shippingEl.innerHTML = `
                    <div class="rate-info">
                        <div>${formatRupiah(rateData.price)}</div>
                        <div class="cache-indicator">✓ Tersimpan</div>
                    </div>
                `;

                // Add tooltip with service info
                shippingEl.title = `${rateData.courier_name} - ${rateData.courier_service_name || rateData.service_name}`;

                updateTotals();
            }
        }

        function resetShippingCost(shopId) {
            const shippingEl = document.getElementById("shipping_shop_" + shopId);
            if (shippingEl) {
                shippingEl.innerHTML = 'Rp0';
                shippingEl.title = '';
                updateTotals();
            }
        }

        function showShippingLoadingState(shopId) {
            const shippingEl = document.getElementById("shipping_shop_" + shopId);
            if (shippingEl) {
                shippingEl.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="spinner-border spinner-border-sm me-2" role="status" style="width: 0.8rem; height: 0.8rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Memuat...</span>
                    </div>
                `;
            }
        }

        function showRateError(shopId) {
            const shippingEl = document.getElementById("shipping_shop_" + shopId);
            if (shippingEl) {
                shippingEl.innerHTML = `
                    <div class="text-danger">
                        <div>Error</div>
                        <div class="cache-indicator">Gagal memuat</div>
                    </div>
                `;
                shippingEl.title = 'Gagal memuat ongkir. Silakan coba lagi.';
            }
        }

        // Apply fresh rate from API (not cached)
        function applyFreshRate(shopId, rateData) {
            const shippingEl = document.getElementById("shipping_shop_" + shopId);
            if (shippingEl && rateData.price) {
                shippingEl.innerHTML = `
                    <div class="rate-info">
                        <div>${formatRupiah(rateData.price)}</div>
                        <div class="cache-indicator">Terbaru</div>
                    </div>
                `;

                shippingEl.title = `${rateData.courier_name} - ${rateData.courier_service_name || rateData.service_name}`;

                updateTotals();

                // Remove "fresh" indicator after 2 seconds
                setTimeout(() => {
                    if (shippingEl.querySelector('.cache-indicator')) {
                        shippingEl.querySelector('.cache-indicator').textContent = '✓ Tersimpan';
                    }
                }, 2000);
            }
        }

        function formatRupiah(num) {
            return 'Rp' + new Intl.NumberFormat('id-ID').format(num);
        }

        // Promo Code Functionality
        let appliedPromo = null;

        // Load current promo on page load
        loadCurrentPromo();

        // Apply promo code
        document.getElementById('apply_promo_btn').addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const promoCode = document.getElementById('promo_code_input').value.trim();

            if (!promoCode) {
                alert('Masukkan kode promo');
                return;
            }

            const subtotal = calculateSubtotal();
            applyPromoCode(promoCode, subtotal);
        });

        // Allow enter key on promo input
        document.getElementById('promo_code_input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                e.stopPropagation();
                document.getElementById('apply_promo_btn').click();
            }
        });

        // Remove promo code
        document.getElementById('remove_promo_btn').addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            removePromoCode();
        });

        function calculateSubtotal() {
            let total = 0;
            @foreach (collect($cartItems)->groupBy('shop_id') as $shopId => $items)
                @php $shopSubtotal = collect($items)->sum(fn($item) => $item['available_quantity'] * $item['price']); @endphp
                total += {{ $shopSubtotal }};
            @endforeach
            return total;
        }

        function applyPromoCode(code, subtotal) {
            const btn = document.getElementById('apply_promo_btn');
            const spinner = btn.querySelector('.spinner-border');
            const text = btn.querySelector('.apply-text');

            // Show loading state
            spinner.classList.remove('d-none');
            text.textContent = 'Memproses...';
            btn.disabled = true;

            fetch('{{ route("checkout.applyPromo") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    promo_code: code,
                    subtotal: subtotal
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    appliedPromo = data.promo;
                    showAppliedPromo(data.promo);
                    updateTotals();
                    document.getElementById('promo_code_input').value = '';

                    // Show success message
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses kode promo');
            })
            .finally(() => {
                // Reset button state
                spinner.classList.add('d-none');
                text.textContent = 'Terapkan';
                btn.disabled = false;
            });
        }

        function removePromoCode() {
            fetch('{{ route("checkout.removePromo") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    appliedPromo = null;
                    hideAppliedPromo();
                    updateTotals();
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus kode promo');
            });
        }

        function loadCurrentPromo() {
            fetch('{{ route("checkout.currentPromo") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.promo) {
                    appliedPromo = data.promo;
                    showAppliedPromo(data.promo);
                    updateTotals();
                }
            })
            .catch(error => {
                console.error('Error loading current promo:', error);
            });
        }

        function showAppliedPromo(promo) {
            document.getElementById('promo_form_section').classList.add('d-none');
            document.getElementById('applied_promo_section').classList.remove('d-none');
            document.getElementById('applied_promo_name').textContent = promo.name;
            document.getElementById('applied_promo_code').textContent = promo.code;
            document.getElementById('applied_promo_amount').textContent = promo.discount_formatted || new Intl.NumberFormat('id-ID').format(promo.discount_amount);

            // Show discount row
            const discountRow = document.getElementById('discount_row');
            discountRow.style.display = 'flex';
            document.getElementById('total_discount').textContent = `-Rp${promo.discount_formatted || new Intl.NumberFormat('id-ID').format(promo.discount_amount)}`;
        }

        function hideAppliedPromo() {
            document.getElementById('promo_form_section').classList.remove('d-none');
            document.getElementById('applied_promo_section').classList.add('d-none');

            // Hide discount row
            const discountRow = document.getElementById('discount_row');
            discountRow.style.display = 'none';
        }
    </script>
    </script>
@endsection
