@extends('layouts.admin.main')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title mb-0">Product Ad Details</h4>
                                <nav>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.ads.index') }}">Product Ads</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('admin.ads.index', ['tab' => $productAd->category]) }}">{{ $productAd->category_name }}</a></li>
                                        <li class="breadcrumb-item active">View</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.ads.edit', $productAd) }}" class="btn btn-warning">
                                    <i class="ri-edit-line"></i> Edit
                                </a>
                                <a href="{{ route('admin.ads.index', ['tab' => $productAd->category]) }}" class="btn btn-secondary">
                                    <i class="ri-arrow-left-line"></i> Back to List
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <!-- Main Content -->
                                <div class="col-lg-8">
                                    <!-- Product Information -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Product Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    @if($productAd->product->media->isNotEmpty())
                                                        <img src="{{ $productAd->product->media->first()->getUrl() }}" 
                                                             alt="{{ $productAd->product->name }}" 
                                                             class="img-fluid rounded">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                             style="height: 200px;">
                                                            <i class="ri-image-line display-4 text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-8">
                                                    <h4 class="mb-3">{{ $productAd->product->name }}</h4>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-sm-6">
                                                            <strong>SKU:</strong><br>
                                                            <span class="text-muted">{{ $productAd->product->sku }}</span>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <strong>Category:</strong><br>
                                                            <span class="badge bg-info">{{ $productAd->category_name }}</span>
                                                        </div>
                                                    </div>

                                                    @if($productAd->product->variants->isNotEmpty())
                                                        @php
                                                            $variant = $productAd->product->variants->first();
                                                            $salePrice = $variant->sale_price ?? $variant->price;
                                                            $originalPrice = $variant->price;
                                                        @endphp
                                                        <div class="row mb-3">
                                                            <div class="col-sm-6">
                                                                <strong>Price:</strong><br>
                                                                <span class="h5 text-primary">Rp{{ number_format($salePrice, 0, ',', '.') }}</span>
                                                                @if($salePrice < $originalPrice)
                                                                    <div>
                                                                        <small class="text-muted text-decoration-line-through">
                                                                            Rp{{ number_format($originalPrice, 0, ',', '.') }}
                                                                        </small>
                                                                        <span class="badge bg-success ms-1">
                                                                            -{{ round((($originalPrice - $salePrice) / $originalPrice) * 100) }}%
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <strong>Stock:</strong><br>
                                                                <span class="text-muted">{{ $variant->stock_quantity ?? 0 }} units</span>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($productAd->product->description)
                                                        <div class="mb-3">
                                                            <strong>Description:</strong><br>
                                                            <p class="text-muted">{{ Str::limit($productAd->product->description, 200) }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ad Configuration -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Ad Configuration</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <td><strong>Category:</strong></td>
                                                                <td>
                                                                    <span class="badge bg-info">{{ $productAd->category_name }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Status:</strong></td>
                                                                <td>
                                                                    <span class="badge bg-{{ $productAd->is_active ? 'success' : 'secondary' }}">
                                                                        {{ $productAd->is_active ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Submission Type:</strong></td>
                                                                <td>
                                                                    <span class="badge bg-{{ $productAd->submission_type === 'manual' ? 'primary' : 'info' }}">
                                                                        {{ ucfirst($productAd->submission_type) }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            @if($productAd->category === 'hot_promo')
                                                            <tr>
                                                                <td><strong>Sort Order:</strong></td>
                                                                <td>{{ $productAd->sort_order ?? 0 }}</td>
                                                            </tr>
                                                            @endif
                                                            @if($productAd->category === 'flash_sale' && $productAd->valid_until)
                                                            <tr>
                                                                <td><strong>Valid Until:</strong></td>
                                                                <td>
                                                                    <div class="{{ $productAd->is_expired ? 'text-danger' : 'text-success' }}">
                                                                        {{ $productAd->valid_until->format('F d, Y H:i') }}
                                                                    </div>
                                                                    @if($productAd->is_expired)
                                                                        <small class="text-danger">
                                                                            <i class="ri-error-warning-line"></i> Expired
                                                                        </small>
                                                                    @else
                                                                        <small class="text-success">
                                                                            <i class="ri-time-line"></i> {{ $productAd->valid_until->diffForHumans() }}
                                                                        </small>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <td><strong>Created:</strong></td>
                                                                <td>{{ $productAd->created_at->format('F d, Y H:i') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Updated:</strong></td>
                                                                <td>{{ $productAd->updated_at->format('F d, Y H:i') }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    @if($productAd->admin_notes)
                                                    <div class="mt-3">
                                                        <strong>Admin Notes:</strong><br>
                                                        <div class="bg-light p-3 rounded">
                                                            {{ $productAd->admin_notes }}
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
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
                                            @switch($productAd->category)
                                                @case('flash_sale')
                                                    <div class="text-center mb-3">
                                                        <i class="ri-flashlight-line display-4 text-danger"></i>
                                                    </div>
                                                    <h6 class="text-center mb-3">Flash Sale</h6>
                                                    <p class="text-muted small">Time-limited promotional products with expiration dates.</p>
                                                    <ul class="list-unstyled small">
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Manual input by admin</li>
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Timed based validation</li>
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Valid until required</li>
                                                    </ul>
                                                    @break
                                                @case('hot_promo')
                                                    <div class="text-center mb-3">
                                                        <i class="ri-fire-line display-4 text-warning"></i>
                                                    </div>
                                                    <h6 class="text-center mb-3">Hot Promo</h6>
                                                    <p class="text-muted small">Featured promotional products ordered by priority.</p>
                                                    <ul class="list-unstyled small">
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Manual input by admin</li>
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Sort order required</li>
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Priority based</li>
                                                    </ul>
                                                    @break
                                                @case('big_discount')
                                                    <div class="text-center mb-3">
                                                        <i class="ri-percent-line display-4 text-success"></i>
                                                    </div>
                                                    <h6 class="text-center mb-3">Big Discount</h6>
                                                    <p class="text-muted small">Products with discounts more than 40%.</p>
                                                    <ul class="list-unstyled small">
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Auto-suggested products</li>
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Discount > 40%</li>
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>High savings</li>
                                                    </ul>
                                                    @break
                                                @case('new_product')
                                                    <div class="text-center mb-3">
                                                        <i class="ri-star-line display-4 text-info"></i>
                                                    </div>
                                                    <h6 class="text-center mb-3">New Product</h6>
                                                    <p class="text-muted small">Recently added products (less than 1 day old).</p>
                                                    <ul class="list-unstyled small">
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Auto-suggested products</li>
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Created < 1 day ago</li>
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Fresh arrivals</li>
                                                    </ul>
                                                    @break
                                                @case('less_than_10k')
                                                    <div class="text-center mb-3">
                                                        <i class="ri-price-tag-3-line display-4 text-secondary"></i>
                                                    </div>
                                                    <h6 class="text-center mb-3">Less Than Rp10K</h6>
                                                    <p class="text-muted small">Affordable products under Rp20,000.</p>
                                                    <ul class="list-unstyled small">
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Auto-suggested products</li>
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Price < Rp20,000</li>
                                                        <li class="mb-1"><i class="ri-check-line text-success me-2"></i>Budget friendly</li>
                                                    </ul>
                                                    @break
                                            @endswitch
                                        </div>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Quick Actions</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('admin.ads.edit', $productAd) }}" class="btn btn-warning">
                                                    <i class="ri-edit-line"></i> Edit Ad
                                                </a>
                                                
                                                @if($productAd->is_active)
                                                    <form action="{{ route('admin.ads.update', $productAd) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="is_active" value="0">
                                                        <input type="hidden" name="product_id" value="{{ $productAd->product_id }}">
                                                        <button type="submit" class="btn btn-secondary w-100" 
                                                                onclick="return confirm('Are you sure you want to deactivate this ad?')">
                                                            <i class="ri-pause-line"></i> Deactivate
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.ads.update', $productAd) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="is_active" value="1">
                                                        <input type="hidden" name="product_id" value="{{ $productAd->product_id }}">
                                                        <button type="submit" class="btn btn-success w-100">
                                                            <i class="ri-play-line"></i> Activate
                                                        </button>
                                                    </form>
                                                @endif

                                                <button type="button" class="btn btn-danger" onclick="deleteAd()">
                                                    <i class="ri-delete-bin-line"></i> Delete Ad
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Related Information -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Related Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <strong>Product Views:</strong><br>
                                                <span class="text-muted">{{ $productAd->product->view_count ?? 0 }} views</span>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <strong>Product Status:</strong><br>
                                                <span class="badge bg-{{ $productAd->product->is_active ? 'success' : 'secondary' }}">
                                                    {{ $productAd->product->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>

                                            @if($productAd->product->seller)
                                            <div class="mb-3">
                                                <strong>Seller:</strong><br>
                                                <span class="text-muted">{{ $productAd->product->seller->name }}</span>
                                            </div>
                                            @endif

                                            <hr>

                                            <div class="text-center">
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="ri-external-link-line"></i> View Product
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
function deleteAd() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
