@extends('layouts.seller.main')

@section('title', $product->name . ' - Product Details')

@section('content')
<div class="container-fluid">
    <!--=== Start Section Title Area ===-->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">Product Details</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.products.index') }}">Products</a></li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
    <!--=== End Section Title Area ===-->

    <!--=== Start Product Details Area ===-->
    <div class="card rounded-3 border-0 product-details-card mb-24">
        <div class="card-body p-25">
            <div class="card-title d-flex justify-content-between align-items-center mb-20 pb-20 border-bottom border-color">
                <h4 class="mb-0">Product Details</h4>
                <div>
                    <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-success btn-sm me-2">
                        <i data-feather="edit" style="width: 16px; height: 16px;"></i>
                        Edit Product
                    </a>
                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="row align-items-start">
                <div class="col-xl-5">
                    @php
                        $images = json_decode($product->images, true);
                    @endphp
                    
                    @if($images && count($images) > 0)
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="product-gallery">
                                        <img class="rounded-3 w-100" src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if(count($images) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                            @endif
                        </div>
                        
                        @if(count($images) > 1)
                        <div class="row mt-3">
                            @foreach($images as $index => $image)
                            <div class="col-3">
                                <img class="rounded-3 w-100 thumbnail {{ $index === 0 ? 'active' : '' }}" 
                                     src="{{ asset('storage/' . $image) }}" 
                                     alt="{{ $product->name }}"
                                     onclick="goToSlide({{ $index }})"
                                     style="cursor: pointer; opacity: {{ $index === 0 ? '1' : '0.6' }};">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    @else
                        <div class="product-gallery">
                            <img class="rounded-3 w-100" src="{{ asset('admin-assets/assets/images/products/product-1.jpg') }}" alt="{{ $product->name }}">
                        </div>
                    @endif
                </div>

                <div class="col-xl-7">
                    <div class="product-details-main-content ms-xxl-4 mt-4 mt-xl-0">
                        <h3>{{ $product->name }}</h3>
                        
                        <div class="old-recent-price mb-3">
                            <span class="fs-24 fw-bold text-primary">Rp {{ number_format($product->price) }}</span>
                        </div>

                        <div class="mb-3">
                            <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} fs-14 py-2 px-3">
                                {{ $product->stock > 0 ? 'In Stock (' . $product->stock . ')' : 'Out of Stock' }}
                            </span>
                            <span class="badge {{ $product->status === 'active' ? 'bg-primary' : 'bg-secondary' }} fs-14 py-2 px-3 ms-2">
                                {{ ucfirst($product->status) }}
                            </span>
                        </div>

                        <p class="mb-4">{{ $product->description }}</p>

                        <ul class="features-list ps-0 list-unstyled mb-4">
                            <li><span class="fw-semibold">SKU:</span> {{ $product->sku }}</li>
                            <li><span class="fw-semibold">Category:</span> {{ $product->primary_category_name }}</li>
                            @if($product->brand)
                                <li><span class="fw-semibold">Brand:</span> {{ $product->brand }}</li>
                            @endif
                            @if($product->weight)
                                <li><span class="fw-semibold">Weight:</span> {{ $product->weight }} kg</li>
                            @endif
                            @if($product->dimensions)
                                <li><span class="fw-semibold">Dimensions:</span> {{ $product->dimensions }}</li>
                            @endif
                            <li><span class="fw-semibold">Created:</span> {{ $product->created_at->format('d M Y, H:i') }}</li>
                            <li><span class="fw-semibold">Last Updated:</span> {{ $product->updated_at->format('d M Y, H:i') }}</li>
                        </ul>

                        @if($product->meta_title || $product->meta_keywords || $product->meta_description)
                        <div class="card border rounded-3 p-3 mb-4">
                            <h5 class="mb-3">SEO Information</h5>
                            @if($product->meta_title)
                                <p><span class="fw-semibold">Meta Title:</span> {{ $product->meta_title }}</p>
                            @endif
                            @if($product->meta_keywords)
                                <p><span class="fw-semibold">Meta Keywords:</span> {{ $product->meta_keywords }}</p>
                            @endif
                            @if($product->meta_description)
                                <p class="mb-0"><span class="fw-semibold">Meta Description:</span> {{ $product->meta_description }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($product->variants && $product->variants->count() > 0)
    <div class="card rounded-3 border-0 product-details-card mb-24">
        <div class="card-body p-25">
            <div class="card-title d-flex justify-content-between align-items-center mb-20 pb-20 border-bottom border-color">
                <h4 class="mb-0">Product Variants</h4>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                    <i data-feather="plus" style="width: 16px; height: 16px;"></i>
                    Add Variant
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Attributes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->variants as $variant)
                        <tr>
                            <td>{{ $variant->name }}</td>
                            <td>{{ $variant->sku }}</td>
                            <td>Rp {{ number_format($variant->price) }}</td>
                            <td>{{ $variant->stock }}</td>
                            <td>
                                @php
                                    $attributes = json_decode($variant->attributes, true);
                                @endphp
                                @if($attributes)
                                    @foreach($attributes as $key => $value)
                                        <span class="badge bg-light text-dark">{{ $key }}: {{ $value }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No attributes</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('seller.products.variants.destroy', $variant) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    <!--=== End Product Details Area ===-->
</div>

<!-- Add Variant Modal -->
<div class="modal fade" id="addVariantModal" tabindex="-1" aria-labelledby="addVariantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('seller.products.variants.store', $product) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addVariantModalLabel">Add Product Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="variantName" class="form-label">Variant Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="variantName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="variantSku" class="form-label">SKU</label>
                        <input type="text" class="form-control" id="variantSku" name="sku" placeholder="Auto-generated if empty">
                    </div>
                    <div class="mb-3">
                        <label for="variantPrice" class="form-label">Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="variantPrice" name="price" step="0.01" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="variantStock" class="form-label">Stock <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="variantStock" name="stock" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Attributes</label>
                        <div id="attributesContainer">
                            <div class="row mb-2">
                                <div class="col-5">
                                    <input type="text" class="form-control" name="attributes[size]" placeholder="Attribute name (e.g., Size)">
                                </div>
                                <div class="col-5">
                                    <input type="text" class="form-control" name="attributes[color]" placeholder="Attribute value (e.g., Large)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Variant</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function goToSlide(index) {
    const carousel = document.getElementById('productCarousel');
    const thumbnails = document.querySelectorAll('.thumbnail');
    
    // Update carousel
    const carouselInstance = bootstrap.Carousel.getInstance(carousel) || new bootstrap.Carousel(carousel);
    carouselInstance.to(index);
    
    // Update thumbnail opacity
    thumbnails.forEach((thumb, i) => {
        thumb.style.opacity = i === index ? '1' : '0.6';
    });
}

// Listen for carousel slide events to update thumbnails
document.getElementById('productCarousel')?.addEventListener('slide.bs.carousel', function (event) {
    const thumbnails = document.querySelectorAll('.thumbnail');
    thumbnails.forEach((thumb, i) => {
        thumb.style.opacity = i === event.to ? '1' : '0.6';
    });
});
</script>
@endpush
