@extends('layouts.seller.main')

@section('title', 'Shop Settings')

@section('content')
    <!--=== Start Section Title Area ===-->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">Shop Settings</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Shop Settings</li>
            </ol>
        </nav>
    </div>
    <!--=== End Section Title Area ===-->

    <form action="{{ route('seller.shop.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card rounded-3 border-0 create-product-card mb-24">
                    <div class="card-body p-25">
                        <div class="card-title mb-20 pb-20 border-bottom border-color d-flex justify-content-between align-items-center">
                            <h4 class="mb-2 mb-sm-0">Shop Information</h4>
                            <span class="badge badge-{{ $shop->is_open ? 'success' : 'danger' }}">
                                {{ $shop->is_open ? 'Open' : 'Closed' }}
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Shop Logo -->
                                <div class="mb-3">
                                    <label class="form-label">Shop Logo</label>
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="text-center">
                                            <div class="mb-2">
                                                @if($shop->getFirstMedia('logo'))
                                                    <img src="{{ $shop->getFirstMedia('logo')->getUrl() }}" 
                                                         alt="Shop Logo" 
                                                         class="rounded border"
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                                         style="width: 80px; height: 80px;">
                                                        <i data-feather="image" style="width: 24px; height: 24px;" class="text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="logo" class="form-control" accept="image/*">
                                            <div class="form-text">
                                                Upload your shop logo. Max: 2MB (jpeg, png, jpg, webp)
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shop Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Shop Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $shop->name) }}" required
                                           placeholder="Enter your shop name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Your shop name will be displayed to customers
                                    </div>
                                </div>

                                <!-- Shop Slug -->
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Shop URL Slug <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ url('/shop/') }}/</span>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                               id="slug" name="slug" value="{{ old('slug', $shop->slug) }}" required
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
                                              placeholder="Tell customers about your shop, what you sell, and what makes you special...">{{ old('description', $shop->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Describe your shop to help customers understand what you offer
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" value="{{ old('phone', $shop->phone) }}"
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
                                            <label class="form-label">Shop Status</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_open" 
                                                       id="is_open" value="1" {{ old('is_open', $shop->is_open) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_open">
                                                    Shop is Open for Orders
                                                </label>
                                            </div>
                                            <div class="form-text">
                                                When closed, customers cannot place new orders
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="mb-3">
                                    <label for="address" class="form-label">Shop Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" name="address" rows="3" 
                                              placeholder="Enter your shop's physical address...">{{ old('address', $shop->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Your business address for shipping and customer reference
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media Links Section -->
                <div class="card rounded-3 border-0 create-product-card mb-24">
                    <div class="card-body p-25">
                        <div class="card-title mb-20 pb-20 border-bottom border-color">
                            <h4 class="mb-2 mb-sm-0">Social Media Links</h4>
                        </div>

                        <div class="row">
                            <!-- Facebook -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="facebook" class="form-label">
                                        <i data-feather="facebook" class="me-1" style="width: 16px; height: 16px;"></i> Facebook
                                    </label>
                                    <input type="url" class="form-control @error('social_links.facebook') is-invalid @enderror" 
                                           id="facebook" name="social_links[facebook]" 
                                           value="{{ old('social_links.facebook', $shop->social_links['facebook'] ?? '') }}"
                                           placeholder="https://facebook.com/yourpage">
                                    @error('social_links.facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Your Facebook page URL
                                    </div>
                                </div>
                            </div>

                            <!-- Instagram -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="instagram" class="form-label">
                                        <i data-feather="instagram" class="me-1" style="width: 16px; height: 16px;"></i> Instagram
                                    </label>
                                    <input type="url" class="form-control @error('social_links.instagram') is-invalid @enderror" 
                                           id="instagram" name="social_links[instagram]" 
                                           value="{{ old('social_links.instagram', $shop->social_links['instagram'] ?? '') }}"
                                           placeholder="https://instagram.com/youraccount">
                                    @error('social_links.instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Your Instagram profile URL
                                    </div>
                                </div>
                            </div>

                            <!-- Twitter -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="twitter" class="form-label">
                                        <i data-feather="twitter" class="me-1" style="width: 16px; height: 16px;"></i> Twitter / X
                                    </label>
                                    <input type="url" class="form-control @error('social_links.twitter') is-invalid @enderror" 
                                           id="twitter" name="social_links[twitter]" 
                                           value="{{ old('social_links.twitter', $shop->social_links['twitter'] ?? '') }}"
                                           placeholder="https://twitter.com/youraccount">
                                    @error('social_links.twitter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Your Twitter/X profile URL
                                    </div>
                                </div>
                            </div>

                            <!-- Website -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="website" class="form-label">
                                        <i data-feather="globe" class="me-1" style="width: 16px; height: 16px;"></i> Website
                                    </label>
                                    <input type="url" class="form-control @error('social_links.website') is-invalid @enderror" 
                                           id="website" name="social_links[website]" 
                                           value="{{ old('social_links.website', $shop->social_links['website'] ?? '') }}"
                                           placeholder="https://yourwebsite.com">
                                    @error('social_links.website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Your personal or business website
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="save" class="me-1" style="width: 16px;"></i>Save Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card rounded-3 border-0 create-product-card mb-24">
                    <div class="card-body p-25">
                        <div class="card-title mb-20 pb-20 border-bottom border-color">
                            <h4 class="mb-2 mb-sm-0">Shop Settings Guide</h4>
                        </div>

                        <div class="form-group mb-25">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-primary">Shop Profile</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-check text-success"></i> Professional logo</li>
                                                <li><i class="fa fa-check text-success"></i> Clear description</li>
                                                <li><i class="fa fa-check text-success"></i> Contact information</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-info">Online Presence</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-check text-success"></i> Social media links</li>
                                                <li><i class="fa fa-check text-success"></i> SEO-friendly URL</li>
                                                <li><i class="fa fa-check text-success"></i> Business credibility</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        <strong>Tip:</strong> Complete shop information helps build customer trust and improves your shop's visibility.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card rounded-3 border-0 create-product-card mb-24">
                    <div class="card-body p-25">
                        <div class="card-title mb-20 pb-20 border-bottom border-color">
                            <h4 class="mb-2 mb-sm-0">Shop Status</h4>
                        </div>

                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-1">Current Status</h6>
                                    <p class="text-muted small mb-0">
                                        Your shop is currently <strong>{{ $shop->is_open ? 'Open' : 'Closed' }}</strong>
                                    </p>
                                </div>
                                <span class="badge badge-{{ $shop->is_open ? 'success' : 'danger' }} fs-12">
                                    {{ $shop->is_open ? 'OPEN' : 'CLOSED' }}
                                </span>
                            </div>
                            <hr class="my-3">
                            <p class="text-muted small mb-0">
                                <i data-feather="info" class="me-1" style="width: 14px; height: 14px;"></i>
                                When your shop is closed, customers can browse but cannot place new orders.
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
            const logoContainer = document.querySelector('.logo-preview, img[alt="Shop Logo"]').closest('div');
            logoContainer.innerHTML = `<img src="${e.target.result}" alt="Shop Logo" class="rounded border" style="width: 80px; height: 80px; object-fit: cover;">`;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
@endsection
