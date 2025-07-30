@extends('layouts.seller.main')

@section('title', 'Create Category')

@section('content')
    <!--=== Start Section Title Area ===-->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">Create Category</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Create Category</li>
            </ol>
        </nav>
    </div>
    <!--=== End Section Title Area ===-->

    <form action="{{ route('seller.categories.store') }}" method="POST">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card rounded-3 border-0 create-product-card mb-24">
                    <div class="card-body p-25">
                        <div class="card-title mb-20 pb-20 border-bottom border-color">
                            <h4 class="mb-2 mb-sm-0">Create Category</h4>
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
                                           value="{{ old('name') }}"
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
                                           value="{{ old('slug') }}"
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
                                        <i class="bx bx-check me-1"></i>Create Category
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
                            <h4 class="mb-2 mb-sm-0">About Categories</h4>
                        </div>

                        <div class="form-group mb-25">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-primary">Internal Categories</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-check text-success"></i> Shop-specific categories</li>
                                                <li><i class="fa fa-check text-success"></i> Full CRUD control</li>
                                                <li><i class="fa fa-check text-success"></i> Custom organization</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-info">Global Categories</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-check text-success"></i> Platform-wide categories</li>
                                                <li><i class="fa fa-check text-success"></i> Available to all sellers</li>
                                                <li><i class="fa fa-check text-success"></i> Used when creating products</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        <strong>Note:</strong> This creates an internal category specific to your shop.
                                        You can also use global categories when managing your products.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    // Auto-generate slug from name if slug is empty
    nameInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.autoGenerated) {
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
        if (this.value) {
            delete this.dataset.autoGenerated;
        }
    });
});
</script>
@endpush
