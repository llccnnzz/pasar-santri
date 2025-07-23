@extends('layouts.seller.main')

@section('title', 'Category Details')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 col-md-8 order-1 mx-auto">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Category Details</h5>
                    <div>
                        <a href="{{ route('seller.categories.edit', $category) }}" class="btn btn-primary me-2">
                            <i class="bx bx-edit-alt me-1"></i>Edit
                        </a>
                        <a href="{{ route('seller.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back me-1"></i>Back to Categories
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Category Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary">Basic Information</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Slug:</strong></td>
                                    <td><code>{{ $category->slug }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Type:</strong></td>
                                    <td>
                                        <span class="badge bg-success">Internal Category</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Statistics</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Products:</strong></td>
                                    <td>
                                        <span class="badge bg-info">{{ $productsCount }} products</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $category->created_at->format('M d, Y \a\t H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated:</strong></td>
                                    <td>{{ $category->updated_at->format('M d, Y \a\t H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Products in this Category -->
                    @if($productsCount > 0)
                        <hr>
                        <h6 class="text-primary mb-3">
                            <i class="bx bx-package me-1"></i>Products in this Category ({{ $productsCount }})
                        </h6>
                        
                        <div class="row">
                            @foreach($category->products()->where('shop_id', auth()->user()->shop->id)->limit(6)->get() as $product)
                                <div class="col-md-4 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                @if($product->getFirstMediaUrl('images'))
                                                    <img src="{{ $product->getFirstMediaUrl('images') }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="rounded me-3"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="bx bx-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 text-truncate">{{ $product->name }}</h6>
                                                    <small class="text-muted">SKU: {{ $product->sku }}</small>
                                                    <br>
                                                    <small class="fw-bold text-primary">${{ number_format($product->price, 2) }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($productsCount > 6)
                            <div class="text-center mt-3">
                                <a href="{{ route('seller.inventory.index', ['category' => $category->id]) }}" 
                                   class="btn btn-outline-primary">
                                    View All {{ $productsCount }} Products
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="bx bx-info-circle me-2"></i>
                            No products are currently assigned to this category.
                            <a href="{{ route('seller.inventory.index') }}" class="alert-link">
                                Manage your products
                            </a> to assign them to this category.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bx bx-cog me-1"></i>Actions
                    </h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('seller.categories.edit', $category) }}" class="btn btn-primary">
                            <i class="bx bx-edit-alt me-1"></i>Edit Category
                        </a>
                        <a href="{{ route('seller.inventory.index', ['category' => $category->id]) }}" class="btn btn-outline-info">
                            <i class="bx bx-package me-1"></i>View Products
                        </a>
                        @if($productsCount == 0)
                            <form action="{{ route('seller.categories.destroy', $category) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bx bx-trash me-1"></i>Delete Category
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
