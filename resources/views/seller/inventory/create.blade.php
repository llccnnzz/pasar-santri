@extends('layouts.seller.main')

@section('title', 'Create Product - Seller Dashboard')

@section('content')
<div class="container-fluid">
    <!--=== Start Section Title Area ===-->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">Create Product</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.products.index') }}">Products</a></li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Create Product</li>
            </ol>
        </nav>
    </div>
    <!--=== End Section Title Area ===-->

    <!--=== Start Create Product Area ===-->
    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card rounded-3 border-0 create-product-card mb-24">
                    <div class="card-body p-25">
                        <div class="card-title mb-20 pb-20 border-bottom border-color">
                            <h4 class="mb-2 mb-sm-0">Create Product</h4>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-25">
                                    <label class="fw-semibold fs-14 text-dark mb-2">Product Title<span class="text-danger">*</span></label>
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                               id="floatingInput" placeholder="Enter Product Title" value="{{ old('name') }}" required>
                                        <label class="text-body fs-12" for="floatingInput">Enter Product Title</label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-25">
                                    <label class="fw-semibold fs-14 text-dark mb-2">Product Description<span class="text-danger">*</span></label>
                                    <div class="form-floating">
                                        <textarea name="description" id="floatingInput7" class="form-control text-area @error('description') is-invalid @enderror" 
                                                  placeholder="Enter Product Description" cols="30" rows="10" required>{{ old('description') }}</textarea>
                                        <label class="text-body fs-12" for="floatingInput7">Enter Product Description</label>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-25">
                                    <label class="fw-semibold fs-14 text-dark mb-2">Product Images</label>
                                    <div class="file-upload-wrap border-1 rounded-3 mb-10">
                                        <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" 
                                               accept=".png,.jpg,.jpeg" multiple>
                                        @error('images.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Select multiple images (JPEG, PNG, JPG)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-25">
                                    <label class="fw-semibold fs-14 text-dark mb-2">Product Price<span class="text-danger">*</span></label>
                                    <div class="form-floating">
                                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                               id="floatingInput2" placeholder="Enter Product Price" value="{{ old('price') }}" step="0.01" min="0" required>
                                        <label class="text-body fs-12" for="floatingInput2">Enter Product Price</label>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-25">
                                    <label class="fw-semibold fs-14 text-dark mb-2">Product SKU Number</label>
                                    <div class="form-floating">
                                        <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" 
                                               id="floatingInput3" placeholder="Enter SKU" value="{{ old('sku') }}">
                                        <label class="text-body fs-12" for="floatingInput3">Enter SKU Number (Optional)</label>
                                        @error('sku')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-25">
                                    <label class="fw-semibold fs-14 text-dark mb-2">Product In Stocks<span class="text-danger">*</span></label>
                                    <div class="form-floating">
                                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                                               id="floatingInput4" placeholder="Enter Stocks Number" value="{{ old('stock') }}" min="0" required>
                                        <label class="text-body fs-12" for="floatingInput4">Enter Stocks Number</label>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-25">
                                    <label class="fw-semibold fs-14 text-dark mb-2">Weight (kg)</label>
                                    <div class="form-floating">
                                        <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" 
                                               id="floatingInput5" placeholder="Enter Weight" value="{{ old('weight') }}" step="0.01" min="0">
                                        <label class="text-body fs-12" for="floatingInput5">Enter Weight in kg</label>
                                        @error('weight')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-25">
                                    <label class="fw-semibold fs-14 text-dark mb-2">Dimensions</label>
                                    <div class="form-floating">
                                        <input type="text" name="dimensions" class="form-control @error('dimensions') is-invalid @enderror" 
                                               id="floatingInput6" placeholder="Enter Dimensions" value="{{ old('dimensions') }}">
                                        <label class="text-body fs-12" for="floatingInput6">Enter Dimensions (L x W x H)</label>
                                        @error('dimensions')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-25">
                                    <label class="fw-semibold fs-14 text-dark mb-2">Brand</label>
                                    <div class="form-floating">
                                        <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" 
                                               id="floatingInputBrand" placeholder="Enter Brand" value="{{ old('brand') }}">
                                        <label class="text-body fs-12" for="floatingInputBrand">Enter Brand Name</label>
                                        @error('brand')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-25">
                                    <label class="fw-semibold fs-14 text-dark mb-2">Status<span class="text-danger">*</span></label>
                                    
                                    <div class="d-flex align-items-center">
                                        <div class="form-check d-flex align-items-center me-4">
                                            <input class="form-check-input" type="radio" name="status" value="active" id="statusActive" 
                                                   {{ old('status') == 'active' ? 'checked' : '' }}>
                                            <label class="form-check-label position-relative fs-14 fw-medium ms-2" for="statusActive" style="top: 1px;">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input" type="radio" name="status" value="inactive" id="statusInactive" 
                                                   {{ old('status') == 'inactive' ? 'checked' : 'checked' }}>
                                            <label class="form-check-label position-relative fs-14 fw-medium ms-2" for="statusInactive" style="top: 1px;">
                                                Inactive
                                            </label>
                                        </div>
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="d-sm-flex justify-content-end text-center">
                                    <button type="submit" class="btn btn-primary">Create Product</button>
                                    <a href="{{ route('seller.products.index') }}" class="btn btn-secondary ms-2">Cancel</a>
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
                            <h4 class="mb-2 mb-sm-0">Product Category</h4>
                        </div>

                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Categories<span class="text-danger">*</span></label>
                            
                            <div class="form-floating">
                                <select name="category_id" class="form-select form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card rounded-3 border-0 create-product-card mb-24">
                    <div class="card-body p-25">
                        <div class="card-title mb-20 pb-20 border-bottom border-color">
                            <h4 class="mb-2 mb-sm-0">Product Meta Data</h4>
                        </div>
                        
                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Product Meta Title</label>
                            <div class="form-floating">
                                <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror" 
                                       id="floatingInput8" placeholder="Enter Product Meta Title" value="{{ old('meta_title') }}">
                                <label class="text-body fs-12" for="floatingInput8">Enter Product Meta Title</label>
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Product Meta Keywords</label>
                            <div class="form-floating">
                                <input type="text" name="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                       id="floatingInput9" placeholder="Enter Product Meta Keywords" value="{{ old('meta_keywords') }}">
                                <label class="text-body fs-12" for="floatingInput9">Enter Product Meta Keywords</label>
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="fw-semibold fs-14 text-dark mb-2">Product Meta Description</label>
                            <div class="form-floating">
                                <textarea name="meta_description" id="floatingInput10" class="form-control text-area @error('meta_description') is-invalid @enderror" 
                                          placeholder="Enter Product Meta Description" cols="30" rows="5">{{ old('meta_description') }}</textarea>
                                <label class="text-body fs-12" for="floatingInput10">Enter Product Meta Description</label>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--=== End Create Product Area ===-->
</div>
@endsection
