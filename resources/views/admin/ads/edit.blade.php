@extends('layouts.admin.main')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h4 class="card-title mb-0">Edit Product Ad</h4>
                                <nav>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.ads.index') }}">Product Ads</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('admin.ads.index', ['tab' => $productAd->category]) }}">{{ $productAd->category_name }}</a></li>
                                        <li class="breadcrumb-item active">Edit</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.ads.update', $productAd) }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')
                                
                                <!-- Current Product Information -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Current Product</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                @if($productAd->product->media->isNotEmpty())
                                                    <img src="{{ $productAd->product->media->first()->getUrl() }}" 
                                                         alt="{{ $productAd->product->name }}" 
                                                         class="img-fluid rounded">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                         style="height: 120px;">
                                                        <i class="ri-image-line display-6 text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-9">
                                                <h5>{{ $productAd->product->name }}</h5>
                                                <p class="text-muted mb-2">SKU: {{ $productAd->product->sku }}</p>
                                                @if($productAd->product->variants->isNotEmpty())
                                                    @php
                                                        $variant = $productAd->product->variants->first();
                                                        $salePrice = $variant->sale_price ?? $variant->price;
                                                        $originalPrice = $variant->price;
                                                    @endphp
                                                    <div class="mb-2">
                                                        <span class="h6 text-primary">Rp{{ number_format($salePrice, 0, ',', '.') }}</span>
                                                        @if($salePrice < $originalPrice)
                                                            <small class="text-muted text-decoration-line-through ms-2">
                                                                Rp{{ number_format($originalPrice, 0, ',', '.') }}
                                                            </small>
                                                            <span class="badge bg-success ms-1">
                                                                -{{ round((($originalPrice - $salePrice) / $originalPrice) * 100) }}%
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                                <span class="badge bg-info">{{ $productAd->category_name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Selection -->
                                <div class="mb-4">
                                    <label for="product_id" class="form-label">
                                        Change Product <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="product_id" name="product_id" required>
                                        <option value="{{ $productAd->product_id }}" selected>
                                            {{ $productAd->product->name }} (Current)
                                        </option>
                                    </select>
                                    <div class="form-text">Search and select a different product if needed</div>
                                    <div class="invalid-feedback">Please select a product.</div>
                                </div>

                                <!-- Category Selection -->
                                <div class="mb-4">
                                    <label for="category" class="form-label">
                                        Category <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="flash_sale" {{ $productAd->category === 'flash_sale' ? 'selected' : '' }}>
                                            Flash Sale
                                        </option>
                                        <option value="hot_promo" {{ $productAd->category === 'hot_promo' ? 'selected' : '' }}>
                                            Hot Promo
                                        </option>
                                        <option value="big_discount" {{ $productAd->category === 'big_discount' ? 'selected' : '' }}>
                                            Big Discount
                                        </option>
                                        <option value="new_product" {{ $productAd->category === 'new_product' ? 'selected' : '' }}>
                                            New Product
                                        </option>
                                        <option value="less_than_10k" {{ $productAd->category === 'less_than_10k' ? 'selected' : '' }}>
                                            Less Than Rp10K
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">Please select a category.</div>
                                </div>

                                <!-- Valid Until (for Flash Sale) -->
                                <div class="mb-4" id="valid_until_field" style="display: {{ $productAd->category === 'flash_sale' ? 'block' : 'none' }};">
                                    <label for="valid_until" class="form-label">
                                        Valid Until <span class="text-danger">*</span>
                                    </label>
                                    <input type="datetime-local" class="form-control" id="valid_until" name="valid_until" 
                                           value="{{ $productAd->valid_until ? $productAd->valid_until->format('Y-m-d\TH:i') : '' }}"
                                           min="{{ now()->format('Y-m-d\TH:i') }}">
                                    <div class="form-text">Flash sale expiration date and time</div>
                                    <div class="invalid-feedback">Please provide a valid expiration date.</div>
                                </div>

                                <!-- Sort Order (for Hot Promo) -->
                                <div class="mb-4" id="sort_order_field" style="display: {{ $productAd->category === 'hot_promo' ? 'block' : 'none' }};">
                                    <label for="sort_order" class="form-label">
                                        Sort Order <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order" 
                                           min="1" max="999" value="{{ $productAd->sort_order ?? 1 }}">
                                    <div class="form-text">Lower numbers appear first (1 = highest priority)</div>
                                    <div class="invalid-feedback">Please provide a valid sort order (1-999).</div>
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label for="is_active" class="form-label">Status</label>
                                    <select class="form-select" id="is_active" name="is_active">
                                        <option value="1" {{ $productAd->is_active ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$productAd->is_active ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <!-- Admin Notes -->
                                <div class="mb-4">
                                    <label for="admin_notes" class="form-label">Admin Notes</label>
                                    <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" 
                                              placeholder="Optional notes for this product ad">{{ $productAd->admin_notes }}</textarea>
                                    <div class="form-text">Internal notes (not visible to customers)</div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line"></i> Update Product Ad
                                    </button>
                                    <a href="{{ route('admin.ads.show', $productAd) }}" class="btn btn-secondary">
                                        <i class="ri-arrow-left-line"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Category Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Category Information</h6>
                        </div>
                        <div class="card-body">
                            <div id="category-info">
                                <!-- Dynamic content will be loaded here -->
                            </div>
                        </div>
                    </div>

                    <!-- Auto Suggestions -->
                    <div class="card" id="suggestions-card" style="display: none;">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="ri-lightbulb-line"></i> Suggested Products
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="suggested-products">
                                <!-- Auto-suggestions will be loaded here -->
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.ads.show', $productAd) }}" class="btn btn-outline-primary">
                                    <i class="ri-eye-line"></i> View Details
                                </a>
                                <a href="{{ route('admin.ads.index', ['tab' => $productAd->category]) }}" class="btn btn-outline-secondary">
                                    <i class="ri-list-check"></i> Back to {{ $productAd->category_name }}
                                </a>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteAd()">
                                    <i class="ri-delete-bin-line"></i> Delete Ad
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this product ad? This action cannot be undone.</p>
                <div class="alert alert-warning">
                    <strong>Warning:</strong> This will remove the product from the {{ $productAd->category_name }} category.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.ads.destroy', $productAd) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Category information templates
const categoryInfo = {
    flash_sale: {
        icon: 'ri-flashlight-line',
        color: 'text-danger',
        title: 'Flash Sale',
        description: 'Time-limited promotional products with expiration dates.',
        features: [
            'Manual input by admin',
            'Timed based validation',
            'Valid until required'
        ]
    },
    hot_promo: {
        icon: 'ri-fire-line',
        color: 'text-warning',
        title: 'Hot Promo',
        description: 'Featured promotional products ordered by priority.',
        features: [
            'Manual input by admin',
            'Sort order required',
            'Priority based'
        ]
    },
    big_discount: {
        icon: 'ri-percent-line',
        color: 'text-success',
        title: 'Big Discount',
        description: 'Products with discounts more than 40%.',
        features: [
            'Auto-suggested products',
            'Discount > 40%',
            'High savings'
        ]
    },
    new_product: {
        icon: 'ri-star-line',
        color: 'text-info',
        title: 'New Product',
        description: 'Recently added products (less than 1 day old).',
        features: [
            'Auto-suggested products',
            'Created < 1 day ago',
            'Fresh arrivals'
        ]
    },
    less_than_10k: {
        icon: 'ri-price-tag-3-line',
        color: 'text-secondary',
        title: 'Less Than Rp10K',
        description: 'Affordable products under Rp20,000.',
        features: [
            'Auto-suggested products',
            'Price < Rp20,000',
            'Budget friendly'
        ]
    }
};

// Initialize category info
function updateCategoryInfo(category) {
    const info = categoryInfo[category];
    if (!info) return;

    const featuresHtml = info.features.map(feature => 
        `<li class="mb-1"><i class="ri-check-line text-success me-2"></i>${feature}</li>`
    ).join('');

    document.getElementById('category-info').innerHTML = `
        <div class="text-center mb-3">
            <i class="${info.icon} display-4 ${info.color}"></i>
        </div>
        <h6 class="text-center mb-3">${info.title}</h6>
        <p class="text-muted small">${info.description}</p>
        <ul class="list-unstyled small">
            ${featuresHtml}
        </ul>
    `;

    // Show/hide conditional fields
    if (category === 'flash_sale') {
        document.getElementById('valid_until_field').style.display = 'block';
        document.getElementById('valid_until').required = true;
    } else {
        document.getElementById('valid_until_field').style.display = 'none';
        document.getElementById('valid_until').required = false;
    }

    if (category === 'hot_promo') {
        document.getElementById('sort_order_field').style.display = 'block';
        document.getElementById('sort_order').required = true;
    } else {
        document.getElementById('sort_order_field').style.display = 'none';
        document.getElementById('sort_order').required = false;
    }

    // Load auto-suggestions for applicable categories
    if (['big_discount', 'new_product', 'less_than_10k'].includes(category)) {
        loadAutoSuggestions(category);
    } else {
        document.getElementById('suggestions-card').style.display = 'none';
    }
}

// Load auto-suggestions
function loadAutoSuggestions(category) {
    fetch(`/admin/ads/auto-suggestions/${category}`)
        .then(response => response.json())
        .then(data => {
            if (data.suggestions && data.suggestions.length > 0) {
                const suggestionsHtml = data.suggestions.slice(0, 5).map(product => `
                    <div class="border rounded p-2 mb-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-2">
                                ${product.image ? 
                                    `<img src="${product.image}" alt="${product.name}" class="rounded" width="40" height="40">` :
                                    `<div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="ri-image-line text-muted"></i>
                                    </div>`
                                }
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 small">${product.name}</h6>
                                <small class="text-muted">${product.price}</small>
                                ${product.discount ? `<small class="badge bg-success ms-1">${product.discount}</small>` : ''}
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                        onclick="selectSuggestedProduct('${product.id}', '${product.name}')">
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');

                document.getElementById('suggested-products').innerHTML = suggestionsHtml;
                document.getElementById('suggestions-card').style.display = 'block';
            } else {
                document.getElementById('suggestions-card').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error loading suggestions:', error);
            document.getElementById('suggestions-card').style.display = 'none';
        });
}

// Select suggested product
function selectSuggestedProduct(productId, productName) {
    const productSelect = document.getElementById('product_id');
    
    // Check if option already exists
    let existingOption = productSelect.querySelector(`option[value="${productId}"]`);
    if (!existingOption) {
        existingOption = new Option(productName, productId);
        productSelect.add(existingOption);
    }
    
    productSelect.value = productId;
    
    // Show confirmation
    const toast = document.createElement('div');
    toast.className = 'toast position-fixed top-0 end-0 m-3';
    toast.innerHTML = `
        <div class="toast-body bg-success text-white">
            <i class="ri-check-line me-2"></i>Product selected: ${productName}
        </div>
    `;
    document.body.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    setTimeout(() => {
        document.body.removeChild(toast);
    }, 3000);
}

// Delete function
function deleteAd() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize category info
    const currentCategory = document.getElementById('category').value;
    updateCategoryInfo(currentCategory);

    // Category change handler
    document.getElementById('category').addEventListener('change', function() {
        updateCategoryInfo(this.value);
    });

    // Initialize product search
    $('#product_id').select2({
        ajax: {
            url: '/admin/products/search',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for products...',
        minimumInputLength: 2,
        templateResult: function(product) {
            if (product.loading) {
                return product.text;
            }
            
            return $(`
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                        ${product.image ? 
                            `<img src="${product.image}" alt="${product.text}" class="rounded" width="30" height="30">` :
                            `<div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                <i class="ri-image-line text-muted small"></i>
                            </div>`
                        }
                    </div>
                    <div>
                        <div class="fw-semibold">${product.text}</div>
                        <small class="text-muted">${product.sku || ''} ${product.price || ''}</small>
                    </div>
                </div>
            `);
        }
    });

    // Form validation
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
