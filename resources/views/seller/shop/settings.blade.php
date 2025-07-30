@extends('layouts.seller.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Shop Settings</h5>
                <span class="badge badge-{{ $shop->is_open ? 'success' : 'danger' }}">
                    {{ $shop->is_open ? 'Open' : 'Closed' }}
                </span>
            </div>
            <div class="card-body">
                <form action="{{ route('seller.shop.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Shop Logo -->
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Shop Logo</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            @if($shop->getFirstMedia('logo'))
                                                <img src="{{ $shop->getFirstMedia('logo')->getUrl() }}" 
                                                     alt="Shop Logo" 
                                                     class="img-thumbnail"
                                                     style="width: 120px; height: 120px; object-fit: cover;">
                                            @else
                                                <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                                     style="width: 120px; height: 120px;">
                                                    <i class="fas fa-store fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file" name="logo" class="form-control" accept="image/*">
                                        <small class="text-muted">Max: 2MB (jpeg, png, jpg, webp)</small>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <!-- Shop Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Shop Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $shop->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Shop Slug -->
                                        <div class="col-md-6 mb-3">
                                            <label for="slug" class="form-label">Shop URL Slug <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ url('/shop/') }}/</span>
                                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                                       id="slug" name="slug" value="{{ old('slug', $shop->slug) }}" required>
                                                @error('slug')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="text-muted">This will be your shop's public URL</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shop Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Shop Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Tell customers about your shop...">{{ old('description', $shop->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact Information -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $shop->phone) }}"
                                   placeholder="+1 234 567 8900">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Shop Status -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Shop Status</label>
                            <div class="d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_open" 
                                           id="is_open" value="1" {{ old('is_open', $shop->is_open) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_open">
                                        Shop is Open for Orders
                                    </label>
                                </div>
                            </div>
                            <small class="text-muted">When closed, customers cannot place new orders</small>
                        </div>

                        <!-- Address -->
                        <div class="col-md-12 mb-4">
                            <label for="address" class="form-label">Shop Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" 
                                      placeholder="Enter your shop's physical address...">{{ old('address', $shop->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Social Media Links -->
                        <div class="col-md-12 mb-4">
                            <h6 class="mb-3">Social Media Links</h6>
                            <div class="row">
                                <!-- Facebook -->
                                <div class="col-md-6 mb-3">
                                    <label for="facebook" class="form-label">
                                        <i class="fab fa-facebook text-primary"></i> Facebook
                                    </label>
                                    <input type="url" class="form-control @error('social_links.facebook') is-invalid @enderror" 
                                           id="facebook" name="social_links[facebook]" 
                                           value="{{ old('social_links.facebook', $shop->social_links['facebook'] ?? '') }}"
                                           placeholder="https://facebook.com/yourpage">
                                    @error('social_links.facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Instagram -->
                                <div class="col-md-6 mb-3">
                                    <label for="instagram" class="form-label">
                                        <i class="fab fa-instagram text-danger"></i> Instagram
                                    </label>
                                    <input type="url" class="form-control @error('social_links.instagram') is-invalid @enderror" 
                                           id="instagram" name="social_links[instagram]" 
                                           value="{{ old('social_links.instagram', $shop->social_links['instagram'] ?? '') }}"
                                           placeholder="https://instagram.com/youraccount">
                                    @error('social_links.instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Twitter -->
                                <div class="col-md-6 mb-3">
                                    <label for="twitter" class="form-label">
                                        <i class="fab fa-twitter text-info"></i> Twitter / X
                                    </label>
                                    <input type="url" class="form-control @error('social_links.twitter') is-invalid @enderror" 
                                           id="twitter" name="social_links[twitter]" 
                                           value="{{ old('social_links.twitter', $shop->social_links['twitter'] ?? '') }}"
                                           placeholder="https://twitter.com/youraccount">
                                    @error('social_links.twitter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Website -->
                                <div class="col-md-6 mb-3">
                                    <label for="website" class="form-label">
                                        <i class="fas fa-globe text-success"></i> Website
                                    </label>
                                    <input type="url" class="form-control @error('social_links.website') is-invalid @enderror" 
                                           id="website" name="social_links[website]" 
                                           value="{{ old('social_links.website', $shop->social_links['website'] ?? '') }}"
                                           placeholder="https://yourwebsite.com">
                                    @error('social_links.website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('seller.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Settings
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
            const img = document.querySelector('img, .bg-light');
            if (img.tagName === 'IMG') {
                img.src = e.target.result;
            } else {
                const newImg = document.createElement('img');
                newImg.src = e.target.result;
                newImg.className = 'img-thumbnail';
                newImg.style.width = '120px';
                newImg.style.height = '120px';
                newImg.style.objectFit = 'cover';
                img.parentNode.replaceChild(newImg, img);
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
@endsection
