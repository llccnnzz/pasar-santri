@extends('layouts.seller.main')

@section('title', 'Edit Category')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 col-md-8 order-1 mx-auto">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Category: {{ $category->name }}</h5>
                    <a href="{{ route('seller.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Back to Categories
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('seller.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

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

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('seller.categories.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-check me-1"></i>Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Category Info -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bx bx-info-circle me-1"></i>Category Information
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Created:</strong> {{ $category->created_at->format('M d, Y \a\t H:i') }}
                            </p>
                            <p class="mb-2">
                                <strong>Last Updated:</strong> {{ $category->updated_at->format('M d, Y \a\t H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6">
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

            <!-- Danger Zone -->
            @if($category->products()->where('shop_id', auth()->user()->shop->id)->count() == 0)
            <div class="card mt-4 border-danger">
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
