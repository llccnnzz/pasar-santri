@extends('layouts.seller.main')

@section('title', 'Setup Your Shop')

@section('content')
    <!--=== Start Section Title Area ===-->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">Setup Your Shop</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Shop Setup</li>
            </ol>
        </nav>
    </div>
    <!--=== End Section Title Area ===-->

    <form action="{{ route('seller.shop.setup.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card rounded-3 border-0 create-product-card mb-24">
                    <div class="card-body p-25">
                        <div class="card-title mb-20 pb-20 border-bottom border-color">
                            <h4 class="mb-2 mb-sm-0">Basic Shop Information</h4>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Shop Logo -->
                                <div class="mb-3">
                                    <label class="form-label">Shop Logo</label>
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="text-center">
                                            <div class="mb-2">
                                                <div class="logo-preview bg-light border rounded d-flex align-items-center justify-content-center"
                                                     style="width: 80px; height: 80px;">
                                                    <i data-feather="image" style="width: 24px; height: 24px;" class="text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="logo" class="form-control" accept="image/*">
                                            <div class="form-text">
                                                Upload your shop logo. Max: 2MB (jpeg, png, jpg, webp)
                                            </div>
                                            @error('logo')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Shop Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Shop Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required
                                           placeholder="Enter your shop name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Choose a memorable name that represents your business
                                    </div>
                                </div>

                                <!-- Shop Slug -->
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Shop URL Slug <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ url('/shop/') }}/</span>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                               id="slug" name="slug" value="{{ old('slug') }}" required
                                               placeholder="your-shop-name">
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        This will be your shop's public URL. Use lowercase letters, numbers, and hyphens only.
                                    </div>
                                </div>

                                <!-- Shop Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Shop Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4" 
                                              placeholder="Tell customers about your shop, what you sell, and what makes you special...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        A good description helps customers understand what you offer
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" value="{{ old('phone') }}"
                                                   placeholder="+1 234 567 8900">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                Customer contact number
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Shop Address</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                                      id="address" name="address" rows="2" 
                                                      placeholder="Enter your shop's address...">{{ old('address') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                Your business location
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i data-feather="check" class="me-1" style="width: 16px;"></i>Create My Shop
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
                            <h4 class="mb-2 mb-sm-0">Getting Started</h4>
                        </div>

                        <div class="form-group mb-25">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-primary">Required Info</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-check text-success"></i> Shop name</li>
                                                <li><i class="fa fa-check text-success"></i> Unique URL</li>
                                                <li><i class="fa fa-check text-muted"></i> Logo (optional)</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-info">Next Steps</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-check text-muted"></i> Add products</li>
                                                <li><i class="fa fa-check text-muted"></i> Setup payments</li>
                                                <li><i class="fa fa-check text-muted"></i> Configure shipping</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        <strong>Note:</strong> You can always update your shop information later in the settings page.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card rounded-3 border-0 create-product-card mb-24">
                    <div class="card-body p-25">
                        <div class="card-title mb-20 pb-20 border-bottom border-color">
                            <h4 class="mb-2 mb-sm-0">Tips for Success</h4>
                        </div>

                        <div class="form-group">
                            <div class="mb-3">
                                <h6 class="text-success">
                                    <i data-feather="lightbulb" class="me-1" style="width: 16px; height: 16px;"></i>
                                    Pro Tips
                                </h6>
                                <ul class="list-unstyled text-muted small">
                                    <li class="mb-1">• Use a professional logo to build trust</li>
                                    <li class="mb-1">• Write a clear, engaging description</li>
                                    <li class="mb-1">• Choose a memorable shop name</li>
                                    <li class="mb-1">• Keep your URL simple and clean</li>
                                </ul>
                            </div>
                            <hr class="border-color">
                            <p class="text-muted small mb-0">
                                <i data-feather="info" class="me-1" style="width: 14px; height: 14px;"></i>
                                Your shop will be automatically set to "Open" status after creation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
            preview.innerHTML = `<img src="${e.target.result}" class="rounded border" style="width: 80px; height: 80px; object-fit: cover;">`;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
@endsection
