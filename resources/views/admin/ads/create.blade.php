@extends('layouts.admin.main')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title mb-0">Create Product Ad</h4>
                                <nav>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.ads.index') }}">Product Ads</a></li>
                                        <li class="breadcrumb-item active">Create</li>
                                    </ol>
                                </nav>
                            </div>
                            <a href="{{ route('admin.ads.index', ['tab' => $category]) }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line"></i> Back to Ads
                            </a>
                        </div>

                        <form action="{{ route('admin.ads.store') }}" method="POST" id="adForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <!-- Main Form -->
                                    <div class="col-lg-8">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">Ad Details</h6>
                                            </div>
                                            <div class="card-body">
                                                <!-- Category Selection -->
                                                <div class="mb-3">
                                                    <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                                    <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
                                                        @foreach(App\Models\ProductAd::CATEGORIES as $key => $name)
                                                            <option value="{{ $key }}" {{ $category === $key ? 'selected' : '' }}>
                                                                {{ $name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="form-text">
                                                        Select the category for this product ad.
                                                    </div>
                                                </div>

                                                <!-- Product Selection -->
                                                <div class="mb-3">
                                                    <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                                                    <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                                        <option value="">Select a product...</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                    data-name="{{ $product->name }}"
                                                                    data-sku="{{ $product->sku }}"
                                                                    data-price="{{ $product->variants->first()->price ?? 0 }}"
                                                                    data-sale-price="{{ $product->variants->first()->sale_price ?? 0 }}"
                                                                    data-image="{{ $product->defaultImage->getFullUrl() ?? '' }}"
                                                                    {{ request('product_id') === $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }} ({{ $product->sku }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('product_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Sort Order (for Hot Promo) -->
                                                <div class="mb-3" id="sortOrderGroup" style="{{ $category === 'hot_promo' ? '' : 'display: none;' }}">
                                                    <label for="sort_order" class="form-label">Sort Order <span class="text-danger">*</span></label>
                                                    <input type="number"
                                                           name="sort_order"
                                                           id="sort_order"
                                                           class="form-control @error('sort_order') is-invalid @enderror"
                                                           value="{{ old('sort_order', 0) }}"
                                                           min="0"
                                                           placeholder="0">
                                                    @error('sort_order')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="form-text">
                                                        Lower numbers appear first. Use 0 for highest priority.
                                                    </div>
                                                </div>

                                                <!-- Valid Until (for Flash Sale) -->
                                                <div class="mb-3" id="validUntilGroup" style="{{ $category === 'flash_sale' ? '' : 'display: none;' }}">
                                                    <label for="valid_until" class="form-label">Valid Until <span class="text-danger">*</span></label>
                                                    <input type="datetime-local"
                                                           name="valid_until"
                                                           id="valid_until"
                                                           class="form-control @error('valid_until') is-invalid @enderror"
                                                           value="{{ old('valid_until') }}"
                                                           min="{{ now()->format('Y-m-d\TH:i') }}">
                                                    @error('valid_until')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="form-text">
                                                        Set when this flash sale expires.
                                                    </div>
                                                </div>

                                                <!-- Submission Type -->
                                                <div class="mb-3">
                                                    <label for="submission_type" class="form-label">Submission Type <span class="text-danger">*</span></label>
                                                    <select name="submission_type" id="submission_type" class="form-select @error('submission_type') is-invalid @enderror" required>
                                                        <option value="manual" {{ old('submission_type', 'manual') === 'manual' ? 'selected' : '' }}>
                                                            Manual
                                                        </option>
                                                        <option value="auto_suggest" {{ old('submission_type') === 'auto_suggest' ? 'selected' : '' }}>
                                                            Auto Suggest
                                                        </option>
                                                    </select>
                                                    @error('submission_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Admin Notes -->
                                                <div class="mb-3">
                                                    <label for="admin_notes" class="form-label">Admin Notes</label>
                                                    <textarea name="admin_notes"
                                                              id="admin_notes"
                                                              class="form-control @error('admin_notes') is-invalid @enderror"
                                                              rows="3"
                                                              placeholder="Optional notes about this ad...">{{ old('admin_notes') }}</textarea>
                                                    @error('admin_notes')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Status -->
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                               name="is_active"
                                                               id="is_active"
                                                               class="form-check-input"
                                                               value="1"
                                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_active">
                                                            Active
                                                        </label>
                                                    </div>
                                                    <div class="form-text">
                                                        Uncheck to save as draft without publishing.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sidebar -->
                                    <div class="col-lg-4">
                                        <!-- Category Info -->
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">Category Information</h6>
                                            </div>
                                            <div class="card-body">
                                                <div id="categoryInfo">
                                                    <!-- Category info will be populated by JavaScript -->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Product Preview -->
                                        <div class="card mb-3" id="productPreview" style="display: none;">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">Product Preview</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <img id="previewImage" src="" alt="Product Image" class="img-fluid rounded mb-3" style="max-height: 200px;">
                                                    <h6 id="previewName" class="mb-1"></h6>
                                                    <p id="previewSku" class="text-muted small mb-2"></p>
                                                    <div id="previewPrice"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Auto-suggested Products -->
                                        @if(!empty($suggestedProducts) && $suggestedProducts->isNotEmpty())
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0 text-warning">
                                                    <i class="ri-lightbulb-line"></i> Suggested Products
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <p class="text-muted small mb-3">Products that match {{ App\Models\ProductAd::CATEGORIES[$category] }} criteria:</p>
                                                @foreach($suggestedProducts->take(5) as $product)
                                                <div class="d-flex align-items-center mb-3 p-2 border rounded cursor-pointer suggested-product"
                                                     data-product-id="{{ $product->id }}"
                                                     data-name="{{ $product->name }}"
                                                     data-sku="{{ $product->sku }}"
                                                     data-price="{{ $product->variants->first()->price ?? 0 }}"
                                                     data-sale-price="{{ $product->variants->first()->sale_price ?? 0 }}"
                                                     data-image="{{ $product->defaultImage->getFullUrl() ?? '' }}">
                                                    @if($product->media->isNotEmpty())
                                                    <img src="{{ $product->defaultImage->getFullUrl() }}"
                                                         alt="{{ $product->name }}"
                                                         class="rounded me-2"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                    <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                                         style="width: 40px; height: 40px;">
                                                        <i class="ri-image-line text-muted"></i>
                                                    </div>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <div class="fw-semibold small">{{ Str::limit($product->name, 25) }}</div>
                                                        <small class="text-muted">{{ $product->sku }}</small>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Action Buttons -->
                                        <div class="card">
                                            <div class="card-body">
                                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                                    <i class="ri-save-line"></i> Create Product Ad
                                                </button>
                                                <a href="{{ route('admin.ads.index', ['tab' => $category]) }}" class="btn btn-secondary w-100">
                                                    <i class="ri-close-line"></i> Cancel
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.suggested-product:hover {
    background-color: #f8f9fc;
    cursor: pointer;
}
.suggested-product.selected {
    background-color: #d1ecf1;
    border-color: #bee5eb;
}
</style>
@endpush

@push('scripts')
<script>
const categoryInfo = {
    'flash_sale': {
        title: 'Flash Sale',
        description: 'Time-limited promotional products with expiration dates.',
        icon: 'ri-flashlight-line',
        color: 'danger',
        requirements: ['Valid until date is required', 'Manual input by admin']
    },
    'hot_promo': {
        title: 'Hot Promo',
        description: 'Featured promotional products ordered by priority.',
        icon: 'ri-fire-line',
        color: 'warning',
        requirements: ['Sort order is required', 'Manual input by admin']
    },
    'big_discount': {
        title: 'Big Discount',
        description: 'Products with discounts more than 40%.',
        icon: 'ri-percent-line',
        color: 'success',
        requirements: ['Auto-suggested products', 'Discount > 40%']
    },
    'new_product': {
        title: 'New Product',
        description: 'Recently added products (less than 1 day old).',
        icon: 'ri-star-line',
        color: 'info',
        requirements: ['Auto-suggested products', 'Created < 1 day ago']
    },
    'less_than_10k': {
        title: 'Less Than Rp10K',
        description: 'Affordable products under Rp20,000.',
        icon: 'ri-price-tag-3-line',
        color: 'secondary',
        requirements: ['Auto-suggested products', 'Price < Rp20,000']
    }
};

function updateCategoryInfo() {
    const category = document.getElementById('category').value;
    const info = categoryInfo[category];

    if (info) {
        document.getElementById('categoryInfo').innerHTML = `
            <div class="text-center mb-3">
                <i class="${info.icon} display-4 text-${info.color}"></i>
            </div>
            <h6 class="text-center mb-3">${info.title}</h6>
            <p class="text-muted small">${info.description}</p>
            <ul class="list-unstyled small">
                ${info.requirements.map(req => `<li class="mb-1"><i class="ri-check-line text-success me-2"></i>${req}</li>`).join('')}
            </ul>
        `;
    }

    // Show/hide conditional fields
    document.getElementById('sortOrderGroup').style.display = category === 'hot_promo' ? 'block' : 'none';
    document.getElementById('validUntilGroup').style.display = category === 'flash_sale' ? 'block' : 'none';

    // Update form requirements
    const sortOrderInput = document.getElementById('sort_order');
    const validUntilInput = document.getElementById('valid_until');

    if (category === 'hot_promo') {
        sortOrderInput.required = true;
        validUntilInput.required = false;
    } else if (category === 'flash_sale') {
        sortOrderInput.required = false;
        validUntilInput.required = true;
    } else {
        sortOrderInput.required = false;
        validUntilInput.required = false;
    }
}

function updateProductPreview() {
    const productSelect = document.getElementById('product_id');
    const selectedOption = productSelect.options[productSelect.selectedIndex];

    if (selectedOption.value) {
        const name = selectedOption.dataset.name;
        const sku = selectedOption.dataset.sku;
        const price = parseFloat(selectedOption.dataset.price);
        const salePrice = parseFloat(selectedOption.dataset.salePrice);
        const image = selectedOption.dataset.image;

        document.getElementById('previewImage').src = image || '/placeholder-product.png';
        document.getElementById('previewName').textContent = name;
        document.getElementById('previewSku').textContent = sku;

        let priceHtml = '';
        if (salePrice > 0 && salePrice < price) {
            const discount = Math.round(((price - salePrice) / price) * 100);
            priceHtml = `
                <div class="text-primary fw-bold">Rp${salePrice.toLocaleString('id-ID')}</div>
                <div class="text-muted small"><s>Rp${price.toLocaleString('id-ID')}</s> <span class="text-success">-${discount}%</span></div>
            `;
        } else {
            priceHtml = `<div class="text-primary fw-bold">Rp${price.toLocaleString('id-ID')}</div>`;
        }

        document.getElementById('previewPrice').innerHTML = priceHtml;
        document.getElementById('productPreview').style.display = 'block';
    } else {
        document.getElementById('productPreview').style.display = 'none';
    }
}

// Event listeners
document.getElementById('category').addEventListener('change', updateCategoryInfo);
document.getElementById('product_id').addEventListener('change', updateProductPreview);

// Handle suggested product clicks
document.querySelectorAll('.suggested-product').forEach(element => {
    element.addEventListener('click', function() {
        const productId = this.dataset.productId;
        const productSelect = document.getElementById('product_id');

        // Remove selection from other suggested products
        document.querySelectorAll('.suggested-product').forEach(el => {
            el.classList.remove('selected');
        });

        // Select this product
        this.classList.add('selected');
        productSelect.value = productId;
        updateProductPreview();
    });
});

// Initialize
updateCategoryInfo();
updateProductPreview();

// Form validation
document.getElementById('adForm').addEventListener('submit', function(e) {
    const category = document.getElementById('category').value;
    const sortOrder = document.getElementById('sort_order').value;
    const validUntil = document.getElementById('valid_until').value;

    if (category === 'hot_promo' && !sortOrder) {
        e.preventDefault();
        alert('Sort order is required for Hot Promo category.');
        return false;
    }

    if (category === 'flash_sale' && !validUntil) {
        e.preventDefault();
        alert('Valid until date is required for Flash Sale category.');
        return false;
    }
});
</script>
@endpush
