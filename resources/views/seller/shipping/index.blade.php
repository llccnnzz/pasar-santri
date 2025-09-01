@extends('layouts.seller.main')

@section('title', 'Shipping Methods')

@section('content')
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">Shipping Methods</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14">
                    <a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Shipping Methods</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Sidebar Kiri: Available Couriers -->
        <div class="col-lg-6">
            <div class="card rounded-3 border-0 mb-24">
                <div class="card-body p-25">
                    <h5 class="mb-3">Available Couriers</h5>
                    <div id="available-couriers">
                        @forelse ($inactiveGlobal as $method)
                            <div class="card shadow-sm border rounded mb-2 p-3" id="available-{{ $method->id }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $method->courier_name }} - {{ $method->service_name }}</h6>
                                        <small class="text-muted">{{ strtoupper($method->courier_code) }} /
                                            {{ strtoupper($method->service_code) }}</small>
                                    </div>
                                    <button class="btn btn-sm btn-success add-courier" data-id="{{ $method->id }}"
                                        data-name="{{ $method->courier_name }} - {{ $method->service_name }}"
                                        data-description="{{ $method->description }}"
                                        data-courier-code="{{ strtoupper($method->courier_code) }}"
                                        data-service-code="{{ strtoupper($method->service_code) }}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small">Semua kurir sudah dipilih.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Kanan: Active & Inactive Couriers -->
        <div class="col-lg-6">
            <div class="card rounded-3 border-0 mb-24">
                <div class="card-body p-25">
                    <h5 class="mb-3">Your Couriers</h5>
                    <div id="your-couriers">
                        @foreach ($enabledMethods as $method)
                            <div class="card shadow-sm border rounded mb-2 p-3" id="courier-{{ $method->id }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 text-success">{{ $method->courier_name }} -
                                            {{ $method->service_name }}</h6>
                                        <small class="text-muted">{{ strtoupper($method->courier_code) }} /
                                            {{ strtoupper($method->service_code) }}</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check form-switch me-2">
                                            <input class="form-check-input shipping-toggle" type="checkbox"
                                                data-id="{{ $method->id }}" checked>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger shipping-delete"
                                            data-id="{{ $method->id }}"
                                            data-name="{{ $method->courier_name }} - {{ $method->service_name }}"
                                            data-courier-code="{{ strtoupper($method->courier_code) }}"
                                            data-service-code="{{ strtoupper($method->service_code) }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @if ($method->description)
                                    <p class="text-muted small mb-0">{{ $method->description }}</p>
                                @else
                                    <p class="text-muted small mb-0 fst-italic">No description available.</p>
                                @endif
                            </div>
                        @endforeach

                        @foreach ($disabledMethods as $method)
                            <div class="card shadow-sm border rounded mb-2 p-3" id="courier-{{ $method->id }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $method->courier_name }} - {{ $method->service_name }}</h6>
                                        <small class="text-muted">{{ strtoupper($method->courier_code) }} /
                                            {{ strtoupper($method->service_code) }}</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check form-switch me-2">
                                            <input class="form-check-input shipping-toggle" type="checkbox"
                                                data-id="{{ $method->id }}">
                                        </div>
                                        <button class="btn btn-sm btn-outline-danger shipping-delete"
                                            data-id="{{ $method->id }}"
                                            data-name="{{ $method->courier_name }} - {{ $method->service_name }}"
                                            data-courier-code="{{ strtoupper($method->courier_code) }}"
                                            data-service-code="{{ strtoupper($method->service_code) }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @if ($method->description)
                                    <p class="text-muted small mb-0">{{ $method->description }}</p>
                                @else
                                    <p class="text-muted small mb-0 fst-italic">No description available.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel"><i class="fa fa-exclamation-triangle me-2"></i>Confirm
                        Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Apakah Anda yakin ingin menghapus <strong id="method-name"></strong> dari daftar
                        kurir?</p>
                    <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
        <div id="toast-container"></div>
    </div>
@endsection

@push('scripts')
    <script>
        let deleteId = null;
        let deleteData = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showToast(message, type = 'success') {
            let toastId = 'toast-' + Date.now();
            let toastHtml = `
<div id="${toastId}" class="toast align-items-center text-bg-${type} border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">${message}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
</div>`;
            document.getElementById('toast-container').insertAdjacentHTML('beforeend', toastHtml);
            let toastEl = document.getElementById(toastId);
            let toast = new bootstrap.Toast(toastEl, {
                delay: 2500
            });
            toast.show();
            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
        }

        // Add Courier (left → right)
        document.addEventListener('click', function(e) {
            if (e.target.closest('.add-courier')) {
                let btn = e.target.closest('.add-courier');
                let courierData = {
                    id: btn.dataset.id,
                    name: btn.dataset.name,
                    description: btn.dataset.description,
                    courier_code: btn.dataset.courierCode,
                    service_code: btn.dataset.serviceCode
                };

                fetch("{{ route('seller.shipping.toggle') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            shipping_method_id: courierData.id,
                            enabled: 1
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('available-' + courierData.id)?.remove();

                            // Append to right sidebar
                            let html = `
<div class="card shadow-sm border rounded mb-2 p-3" id="courier-${courierData.id}">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h6 class="mb-1 text-success">${courierData.name}</h6>
            <small class="text-muted mb-1">${courierData.courier_code} / ${courierData.service_code}</small>
        </div>
        <div class="d-flex align-items-center">
            <div class="form-check form-switch me-2">
                <input class="form-check-input shipping-toggle" type="checkbox" data-id="${courierData.id}" checked>
            </div>
            <button class="btn btn-sm btn-outline-danger shipping-delete"
                    data-id="${courierData.id}"
                    data-name="${courierData.name}"
                    data-description="${courierData.description}"
                    data-courier-code="${courierData.courier_code}"
                    data-service-code="${courierData.service_code}">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </div>
</div>`;
                            document.getElementById('your-couriers').insertAdjacentHTML('beforeend', html);
                        }
                        showToast(data.message, data.success ? 'success' : 'danger');
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('Terjadi kesalahan.', 'danger');
                    });
            }
        });

        // Toggle Enable/Disable
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('shipping-toggle')) {
                let methodId = e.target.dataset.id;
                let enabled = e.target.checked ? 1 : 0;
                fetch("{{ route('seller.shipping.toggle') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            shipping_method_id: methodId,
                            enabled: enabled
                        })
                    })
                    .then(res => res.json())
                    .then(data => showToast(data.message, data.success ? 'success' : 'danger'))
                    .catch(err => {
                        console.error(err);
                        showToast('Terjadi kesalahan.', 'danger');
                    });
            }
        });

        // Delete Courier
        document.addEventListener('click', function(e) {
            if (e.target.closest('.shipping-delete')) {
                let btn = e.target.closest('.shipping-delete');
                deleteId = btn.dataset.id;
                deleteData = {
                    id: btn.dataset.id,
                    name: btn.dataset.name,
                    description: btn.dataset.description,
                    courier_code: btn.dataset.courierCode,
                    service_code: btn.dataset.serviceCode
                };
                document.getElementById('method-name').textContent = deleteData.name;
                new bootstrap.Modal(document.getElementById('deleteModal')).show();
            }
        });

        // Confirm Delete
        document.getElementById('confirm-delete').addEventListener('click', function() {
            fetch("{{ url('/seller/shipping') }}/" + deleteId, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('courier-' + deleteId)?.remove();

                        // Tambah kembali ke sidebar kiri
                        let html = `
<div class="card shadow-sm border rounded mb-2 p-3" id="available-${deleteData.id}">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-1">${deleteData.name}</h6>
            <small class="text-muted mb-1">${deleteData.courier_code} / ${deleteData.service_code}</small>
        </div>
        <button class="btn btn-sm btn-success add-courier"
                data-id="${deleteData.id}"
                data-name="${deleteData.name}"
                data-description="${deleteData.description}"
                data-courier-code="${deleteData.courier_code}"
                data-service-code="${deleteData.service_code}">
            <i class="fa fa-plus"></i>
        </button>
    </div>
</div>`;
                        document.getElementById('available-couriers').insertAdjacentHTML('afterbegin', html);
                    }
                    bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
                    showToast(data.message, data.success ? 'success' : 'danger');
                })
                .catch(err => {
                    console.error(err);
                    showToast('Terjadi kesalahan saat menghapus.', 'danger');
                });
        });
    </script>
@endpush
