@extends('layouts.seller.main')

@section('title', 'Create Product - Seller Dashboard')

@section('content')
<!--=== Start Section Title Area ===-->
<div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
    <h4 class="text-dark mb-0">Create Product</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item fs-14">Products</li>
            <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Create Product</li>
        </ol>
    </nav>
</div>
<!--=== End Section Title Area ===-->

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6>Please fix the following errors:</h6>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!--=== Start Create Product Area ===-->
<form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
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
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" id="floatingInput" value="{{ old('name') }}" 
                                       placeholder="Enter Product Title" required>
                                <label class="text-body fs-12" for="floatingInput">Enter Product Title</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Features<span class="text-danger">*</span></label>
                            
                            <div class="wysiwyg-wrap">
                                <div class="text-wysiwyg mb-25">
                                    <div id="wysiwyg">
                                        <div class="btns">
                                            <div class="category">
                                                <button type="button" data-cmd="undo">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                                <button type="button" data-cmd="redo">
                                                    <i class="fas fa-redo"></i>
                                                </button>
                                            </div>
                                            <div class="category">
                                                <select data-cmd="formatBlock">
                                                    <option value="p">Paragraph</option>
                                                    <option value="h1">Title 1</option>
                                                    <option value="h2">Title 2</option>
                                                    <option value="h3">Title 3</option>
                                                </select>
                                                <select data-cmd="fontSize">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                                <select data-cmd="fontName">
                                                    <option value="Arial">Arial</option>
                                                    <option value="Roboto">Roboto</option>
                                                    <option value="serif">Serif</option>
                                                    <option value="sans-serif">Sans-serif</option>
                                                </select>
                                            </div>
                                            <div class="category">
                                                <button type="button" data-cmd="bold">
                                                    <i class="fas fa-bold"></i>
                                                </button>
                                                <button type="button" data-cmd="italic">
                                                    <i class="fas fa-italic"></i>
                                                </button>
                                                <button type="button" data-cmd="underline">
                                                    <i class="fas fa-underline"></i>
                                                </button>
                                            </div>
                                            <div class="category">
                                                <input data-cmd="forecolor" type="color" value="#000000">
                                                <input data-cmd="backcolor" type="color" value="#FFFFFF">
                                            </div>
                                            <div class="category">
                                                <button type="button" data-cmd="justifyLeft">
                                                    <i class="fas fa-align-left"></i>
                                                </button>
                                                <button type="button" data-cmd="justifyCenter">
                                                    <i class="fas fa-align-center"></i>
                                                </button>
                                                <button type="button" data-cmd="justifyRight">
                                                    <i class="fas fa-align-right"></i>
                                                </button>
                                                <button type="button" data-cmd="justifyFull">
                                                    <i class="fas fa-align-justify"></i>
                                                </button>
                                            </div>
                                            <div class="category">
                                                <button type="button" data-cmd="indent">
                                                    <i class="fas fa-indent"></i>
                                                </button>
                                                <button type="button" data-cmd="outdent">
                                                    <i class="fas fa-outdent"></i>
                                                </button>
                                            </div>
                                            <div class="category">
                                                <button type="button" data-cmd="insertUnorderedList">
                                                    <i class="fas fa-list-ul"></i>
                                                </button>
                                                <button type="button" data-cmd="insertOrderedList">
                                                    <i class="fas fa-list-ol"></i>
                                                </button>
                                            </div>
                                            <div class="category">
                                                <button type="button" data-cmd="createlink" class="prompt">
                                                    <i class="fas fa-link"></i>
                                                </button>
                                                <button type="button" data-cmd="insertimage" class="prompt">
                                                    <i class="fas fa-image"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="editor" contentEditable>
                                            <p>{{ old('description', 'Type product description') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <textarea name="description" id="hiddenDescription" style="display: none;" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Product Image<span class="text-danger">*</span></label>
                            
                            <div class="file-upload-wrap border-1 rounded-3 mb-10">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' name="product_image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="avatar-upload">
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url('/admin-assets/assets/images/products/product-11.jpg');"></div>
                                </div>
                            </div>
                            @error('product_image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Product Gallery</label>
                            
                            <div class="file-upload-wrap border-1 rounded-3 mb-10">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' name="product_gallery[]" id="imageUpload2" accept=".png, .jpg, .jpeg" multiple />
                                        <label for="imageUpload2"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="avatar-upload d-flex">
                                <div class="avatar-preview mb-2 mb-sm-0">
                                    <div id="imagePreview2" style="background-image: url('/admin-assets/assets/images/products/product-13.jpg');"></div>
                                </div>
                                <div class="avatar-preview ms-2 mb-2 mb-sm-0">
                                    <div id="imagePreview3" style="background-image: url('/admin-assets/assets/images/products/product-12.jpg');"></div>
                                </div>
                                <div class="avatar-preview ms-2 mb-2 mb-sm-0">
                                    <div id="imagePreview4" style="background-image: url('/admin-assets/assets/images/products/product-11.jpg');"></div>
                                </div>
                            </div>
                            @error('product_gallery')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Product Price<span class="text-danger">*</span></label>
                            <div class="form-floating">
                                <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" 
                                       name="price" id="floatingInput2" value="{{ old('price') }}" 
                                       placeholder="Enter Product Price" required>
                                <label class="text-body fs-12" for="floatingInput2">Enter Product Price</label>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Sale Price</label>
                            <div class="form-floating">
                                <input type="number" step="0.01" min="0" class="form-control @error('final_price') is-invalid @enderror" 
                                       name="final_price" id="finalPrice" value="{{ old('final_price') }}" 
                                       placeholder="Enter Sale Price">
                                <label class="text-body fs-12" for="finalPrice">Enter Sale Price</label>
                                @error('final_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Product SKU Number</label>
                            <div class="form-floating">
                                <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                                       name="sku" id="floatingInput3" value="{{ old('sku') }}" 
                                       placeholder="Enter SKU">
                                <label class="text-body fs-12" for="floatingInput3">Enter SKU Number</label>
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Product Brand</label>
                            <div class="form-floating">
                                <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                       name="brand" id="brandInput" value="{{ old('brand') }}" 
                                       placeholder="Enter Brand">
                                <label class="text-body fs-12" for="brandInput">Enter Brand</label>
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Product Weight (kg)</label>
                            <div class="form-floating">
                                <input type="number" step="0.01" min="0" class="form-control @error('weight') is-invalid @enderror" 
                                       name="weight" id="weightInput" value="{{ old('weight') }}" 
                                       placeholder="Enter Weight">
                                <label class="text-body fs-12" for="weightInput">Enter Weight</label>
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Product In Stocks<span class="text-danger">*</span></label>
                            <div class="form-floating">
                                <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" 
                                       name="stock" id="floatingInput4" value="{{ old('stock') }}" 
                                       placeholder="Enter Stocks Number" required>
                                <label class="text-body fs-12" for="floatingInput4">Enter Stocks Number</label>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-25">
                            <label class="fw-semibold fs-14 text-dark mb-2">Product Long Description</label>
                            <div class="form-floating">
                                <textarea class="form-control text-area @error('long_description') is-invalid @enderror" 
                                          name="long_description" id="floatingInput7" 
                                          placeholder="Enter Product Long Description" cols="30" rows="10">{{ old('long_description') }}</textarea>
                                <label class="text-body fs-12" for="floatingInput7">Enter Product Long Description</label>
                                @error('long_description')
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
                                    <input class="form-check-input" type="radio" name="status" value="active" 
                                           id="flexRadioDefault1" {{ old('status') == 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label position-relative fs-14 fw-medium ms-2" for="flexRadioDefault1" style="top: 1px;">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check d-flex align-items-center me-4">
                                    <input class="form-check-input" type="radio" name="status" value="inactive" 
                                           id="flexRadioDefault2" {{ old('status') == 'inactive' ? 'checked' : 'checked' }}>
                                    <label class="form-check-label position-relative fs-14 fw-medium ms-2" for="flexRadioDefault2" style="top: 1px;">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-25">
                            <div class="d-flex align-items-center">
                                <div class="form-check d-flex align-items-center me-4">
                                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" 
                                           id="isFeatured" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label position-relative fs-14 fw-medium ms-2" for="isFeatured" style="top: 1px;">
                                        Featured Product
                                    </label>
                                </div>
                                <div class="form-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" name="is_popular" value="1" 
                                           id="isPopular" {{ old('is_popular') ? 'checked' : '' }}>
                                    <label class="form-check-label position-relative fs-14 fw-medium ms-2" for="isPopular" style="top: 1px;">
                                        Popular Product
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="d-sm-flex justify-content-end text-center">
                            <button type="submit" class="btn btn-primary">Create Product</button>
                            <a href="{{ route('seller.products.index') }}" class="btn btn-danger ms-2">Cancel</a>
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
                    <h4 class="mb-2 mb-sm-0">Product Categories & Tags</h4>
                </div>

                <div class="form-group mb-25">
                    <label class="fw-semibold fs-14 text-dark mb-2">Global Categories<span class="text-danger">*</span></label>
                    <div class="form-text mb-2">Select at least one global category</div>
                    <div style="max-height: 200px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 10px;">
                        @foreach($globalCategories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="global_categories[]" 
                                       value="{{ $category->id }}" id="global_cat_{{ $category->id }}"
                                       {{ in_array($category->id, old('global_categories', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" style="margin-top: 5px; margin-left: 10px" for="global_cat_{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('global_categories')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                @if($localCategories->count() > 0)
                <div class="form-group mb-25">
                    <label class="fw-semibold fs-14 text-dark mb-2">Your Shop Categories</label>
                    <div class="form-text mb-2">Select your internal categories (optional)</div>
                    <div style="max-height: 200px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 10px;">
                        @foreach($localCategories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="local_categories[]" 
                                       value="{{ $category->id }}" id="local_cat_{{ $category->id }}"
                                       {{ in_array($category->id, old('local_categories', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" style="margin-top: 5px; margin-left: 10px" for="local_cat_{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('local_categories')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                @else
                <div class="form-group mb-25">
                    <label class="fw-semibold fs-14 text-dark mb-2">Your Shop Categories</label>
                    <p class="text-muted">
                        No shop categories yet. 
                        <a href="{{ route('seller.categories.create') }}" target="_blank">Create one</a>
                    </p>
                </div>
                @endif

                <div class="form-group">
                    <label class="fw-semibold fs-14 text-dark mb-2">Tags</label>
                    <div class="form-floating">
                        <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                               name="tags" id="tagsInput" value="{{ old('tags') }}" 
                               placeholder="tag1, tag2, tag3">
                        <label class="text-body fs-12" for="tagsInput">Enter tags separated by commas</label>
                        @error('tags')
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
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                               name="meta_title" id="floatingInput8" value="{{ old('meta_title') }}" 
                               placeholder="Enter Product Meta Title">
                        <label class="text-body fs-12" for="floatingInput8">Enter Product Meta Title</label>
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-25">
                    <label class="fw-semibold fs-14 text-dark mb-2">Product Meta Keywords</label>
                    <div class="form-floating">
                        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                               name="meta_keywords" id="floatingInput9" value="{{ old('meta_keywords') }}" 
                               placeholder="Enter Product Meta Keywords">
                        <label class="text-body fs-12" for="floatingInput9">Enter Product Meta Keywords</label>
                        @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="fw-semibold fs-14 text-dark mb-2">Product Meta Description</label>
                    <div class="form-floating">
                        <textarea class="form-control text-area @error('meta_description') is-invalid @enderror" 
                                  name="meta_description" id="floatingInput10" 
                                  placeholder="Enter Product Meta Description" cols="30" rows="10">{{ old('meta_description') }}</textarea>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // WYSIWYG Editor functionality
    const editor = document.getElementById('editor');
    const hiddenDescription = document.getElementById('hiddenDescription');
    
    // Update hidden textarea when editor content changes
    editor.addEventListener('input', function() {
        hiddenDescription.value = editor.innerHTML;
    });
    
    // Initialize hidden textarea with editor content
    if (editor.innerHTML.trim() !== '') {
        hiddenDescription.value = editor.innerHTML;
    }
    
    // WYSIWYG commands
    document.querySelectorAll('[data-cmd]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const cmd = this.getAttribute('data-cmd');
            
            if (cmd === 'createlink' || cmd === 'insertimage') {
                const url = prompt(`Please enter the ${cmd === 'createlink' ? 'link URL' : 'image URL'}:`);
                if (url) {
                    document.execCommand(cmd, false, url);
                }
            } else if (cmd === 'forecolor' || cmd === 'backcolor') {
                document.execCommand(cmd, false, this.value);
            } else if (cmd === 'formatBlock' || cmd === 'fontName' || cmd === 'fontSize') {
                document.execCommand(cmd, false, this.value);
            } else {
                document.execCommand(cmd, false, null);
            }
            
            // Update hidden textarea
            hiddenDescription.value = editor.innerHTML;
        });
    });
    
    // Image preview functionality
    function readURL(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).style.backgroundImage = `url('${e.target.result}')`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    document.getElementById('imageUpload').addEventListener('change', function() {
        readURL(this, 'imagePreview');
    });
    
    // Form validation
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const globalCategories = document.querySelectorAll('input[name="global_categories[]"]:checked');
        
        if (globalCategories.length === 0) {
            e.preventDefault();
            alert('Please select at least one global category.');
            return false;
        }
        
        // Update description from editor before submit
        const editor = document.getElementById('editor');
        const hiddenDescription = document.getElementById('hiddenDescription');
        hiddenDescription.value = editor.innerHTML;
        
        if (!hiddenDescription.value.trim() || hiddenDescription.value.trim() === '<p>Type product description</p>') {
            e.preventDefault();
            alert('Please enter product description.');
            editor.focus();
            return false;
        }
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            if (alert.classList.contains('show')) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        });
    }, 5000);
});
</script>
@endpush
@endsection
                                              