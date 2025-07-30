@extends('layouts.seller.main')

@section('title', 'Edit Category')

@section('content')
<!--=== Start Section Title Area ===-->
<div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
    <h4 class="text-dark mb-0">Edit Category</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Edit Category</li>
        </ol>
    </nav>
</div>
<!--=== End Section Title Area ===-->

<form action="{{ route('seller.categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card rounded-3 border-0 create-product-card mb-24">
                <div class="card-body p-25">
                    <div class="card-title mb-20 pb-20 border-bottom border-color">
                        <h4 class="mb-2 mb-sm-0">Edit Category</h4>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Category Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $category->name) }}"
                                       placeholder="Enter category name"
                                       required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    A descriptive name for your category (e.g., "Electronics", "Clothing")
                                </div>
                            </div>

                            <!-- Category Slug -->
                            <div class="mb-3">
                                <label for="slug" class="form-label">Category Slug</label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       id="slug"
                                       name="slug"
                                       value="{{ old('slug', $category->slug) }}"
                                       placeholder="Auto-generated from name">
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    URL-friendly version of the name. Leave blank to auto-generate from the category name.
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('seller.categories.index') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-check me-1"></i>Update Category
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card rounded-3 border-0 create-product-card mb-24">
                <div class="card-body p-25">
                    <div class="card-title mb-20 pb-20 border-bottom border-color">
                        <h4 class="mb-2 mb-sm-0">Category Information</h4>
                    </div>

                    <div class="form-group mb-25">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="mb-2">
                                    <strong>Created:</strong> {{ $category->created_at->format('M d, Y \a\t H:i') }}
                                </p>
                                <p class="mb-2">
                                    <strong>Last Updated:</strong> {{ $category->updated_at->format('M d, Y \a\t H:i') }}
                                </p>
                                <p class="mb-2">
                                    <strong>Current Slug:</strong> <code>{{ $category->slug }}</code>
                                </p>
                                <p class="mb-2">
                                    <strong>Products Using:</strong>
                                    <span class="badge bg-info">
                                    {{ $category->products()->where('shop_id', auth()->user()->shop->id)->count() }} products
                                </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row justify-content-center">
    <div class="col-lg-12">
        @if($category->products()->where('shop_id', auth()->user()->shop->id)->count() == 0)
            <div class="card rounded-3 border-2 create-product-card mb-24 border-danger">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">
                        <i class="bx bx-error-circle me-1"></i>Danger Zone
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        This category has no products associated with it. You can safely delete it if it's no longer needed.
                    </p>
                    <form action="{{ route('seller.categories.destroy', $category) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')"
                          style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bx bx-trash me-1"></i>Delete Category
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const originalName = "{{ $category->name }}";
    const originalSlug = "{{ $category->slug }}";

    // Auto-generate slug from name if name changes and slug hasn't been manually edited
    nameInput.addEventListener('input', function() {
        // Only auto-generate if current slug matches the original or is auto-generated
        if (slugInput.value === originalSlug || slugInput.dataset.autoGenerated) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');

            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });

    // Mark slug as manually edited if user types in it
    slugInput.addEventListener('input', function() {
        if (this.value !== originalSlug) {
            delete this.dataset.autoGenerated;
        }
    });
});
</script>
@endpush
