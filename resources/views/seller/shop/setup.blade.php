@extends('layouts.seller.main')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">Setup Your Shop</h4>
                <p class="text-muted mb-0">Let's get your shop ready for customers</p>
            </div>
            <div class="card-body p-25">
                <form action="{{ route('seller.shop.setup.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Shop Logo -->
                        <div class="col-md-12 mb-24 text-center">
                            <label class="form-label fs-14 text-theme-dark fw-bold">Shop Logo</label>
                            <div class="mb-3">
                                <div class="logo-preview bg-light border rounded d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 120px; height: 120px;">
                                    <i class="fas fa-store fa-3x text-muted"></i>
                                </div>
                            </div>
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            <small class="text-muted">Max: 2MB (jpeg, png, jpg, webp)</small>
                            @error('logo')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Shop Name -->
                        <div class="col-md-6 mb-20">
                            <label for="name" class="form-label fs-14 text-theme-dark fw-bold">Shop Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror h-48" 
                                   id="name" name="name" value="{{ old('name') }}" required
                                   placeholder="Enter your shop name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Shop Slug -->
                        <div class="col-md-6 mb-20">
                            <label for="slug" class="form-label fs-14 text-theme-dark fw-bold">Shop URL Slug <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">{{ url('/shop/') }}/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror h-48" 
                                       id="slug" name="slug" value="{{ old('slug') }}" required
                                       placeholder="your-shop-name">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">This will be your shop's public URL</small>
                        </div>

                        <!-- Shop Description -->
                        <div class="col-md-12 mb-20">
                            <label for="description" class="form-label fs-14 text-theme-dark fw-bold">Shop Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Tell customers about your shop, what you sell, and what makes you special...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact Information -->
                        <div class="col-md-6 mb-20">
                            <label for="phone" class="form-label fs-14 text-theme-dark fw-bold">Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror h-48" 
                                   id="phone" name="phone" value="{{ old('phone') }}"
                                   placeholder="+1 234 567 8900">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-md-6 mb-20">
                            <label for="address" class="form-label fs-14 text-theme-dark fw-bold">Shop Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" 
                                      placeholder="Enter your shop's physical address...">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between pt-20">
                        <a href="{{ route('seller.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-store"></i> Create My Shop
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single
        .trim('-'); // Remove leading/trailing hyphens
    
    document.getElementById('slug').value = slug;
});

// Preview logo before upload
document.querySelector('input[name="logo"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.logo-preview');
            preview.innerHTML = `<img src="${e.target.result}" style="width: 120px; height: 120px; object-fit: cover;" class="rounded">`;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
@endsection
