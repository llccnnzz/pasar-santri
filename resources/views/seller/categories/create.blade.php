@extends('layouts.seller.main')

@section('title', 'Create Category')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 col-md-8 order-1 mx-auto">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Create New Category</h5>
                    <a href="{{ route('seller.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Back to Categories
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('seller.categories.store') }}" method="POST">
                        @csrf

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

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('seller.categories.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-check me-1"></i>Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bx bx-info-circle me-1"></i>About Categories
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Internal Categories</h6>
                            <ul class="list-unstyled">
                                <li><i class="bx bx-check text-success me-1"></i>Shop-specific categories</li>
                                <li><i class="bx bx-check text-success me-1"></i>Full CRUD control</li>
                                <li><i class="bx bx-check text-success me-1"></i>Custom organization</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info">Global Categories</h6>
                            <ul class="list-unstyled">
                                <li><i class="bx bx-info-circle text-info me-1"></i>Platform-wide categories</li>
                                <li><i class="bx bx-info-circle text-info me-1"></i>Available to all sellers</li>
                                <li><i class="bx bx-info-circle text-info me-1"></i>Used when creating products</li>
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
