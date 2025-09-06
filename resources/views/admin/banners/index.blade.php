@extends('layouts.admin.main')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Banner Promotion Management</h4>
                            <div class="text-muted">
                                <i class="ri-image-line"></i>
                                Manage promotional banners throughout the website
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <!-- Banner Overview Cards -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h6 class="text-white">Primary Banners</h6>
                                            <h4 class="text-white mb-0">
                                                @php
                                                    $primaryBanner = $bannerPromotions['banner_promotion_headline_primary']['value'] ?? null;
                                                    $count = 0;
                                                    if (is_array($primaryBanner)) {
                                                        $count = count($primaryBanner);
                                                    } elseif (is_string($primaryBanner) && !empty($primaryBanner)) {
                                                        $decoded = json_decode($primaryBanner, true);
                                                        $count = is_array($decoded) ? count($decoded) : 1;
                                                    }
                                                @endphp
                                                {{ $count }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h6 class="text-white">Child Banners</h6>
                                            <h4 class="text-white mb-0">3</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h6 class="text-white">Section Banners</h6>
                                            <h4 class="text-white mb-0">3</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h6 class="text-white">Total Banners</h6>
                                            <h4 class="text-white mb-0">{{ count($bannerPromotions) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Banner Configuration -->
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3">Banner Configuration</h5>
                                    <div class="row">
                                        @foreach($bannerPromotions as $key => $banner)
                                        <div class="col-lg-6 col-xl-4 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <h6 class="card-title mb-0">{{ $banner['label'] }}</h6>
                                                    @if($banner['is_multiple'])
                                                        <span class="badge bg-info">Multiple</span>
                                                    @else
                                                        <span class="badge bg-primary">Single</span>
                                                    @endif
                                                </div>
                                                <div class="card-body">
                                                    <p class="text-muted small">{{ $banner['description'] }}</p>
                                                    
                                    <!-- Current Images Display -->
                                    <div class="current-images mb-3">
                                        @if($banner['is_multiple'])
                                            @php
                                                $images = [];
                                                if (is_array($banner['value'])) {
                                                    $images = $banner['value'];
                                                } elseif (is_string($banner['value']) && !empty($banner['value'])) {
                                                    $decoded = json_decode($banner['value'], true);
                                                    $images = is_array($decoded) ? $decoded : [$banner['value']];
                                                }
                                            @endphp
                                            @if(!empty($images))
                                                <div class="row">
                                                    @foreach($images as $imagePath)
                                                    <div class="col-6 mb-2">
                                                        <div class="position-relative">
                                                            <img src="{{ $imagePath }}" 
                                                                 alt="Banner Image" 
                                                                 class="img-fluid rounded border"
                                                                 style="width: 100%; height: 80px; object-fit: cover;">
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="text-center py-3 bg-light rounded">
                                                    <i class="ri-image-line fs-1 text-muted"></i>
                                                    <p class="text-muted mb-0">No images uploaded</p>
                                                </div>
                                            @endif
                                        @else
                                            @if(!empty($banner['value']))
                                                <div class="text-center">
                                                    <img src="{{ $banner['value'] }}" 
                                                         alt="Banner Image" 
                                                         class="img-fluid rounded border"
                                                         style="max-height: 120px; object-fit: cover;">
                                                </div>
                                            @else
                                                <div class="text-center py-3 bg-light rounded">
                                                    <i class="ri-image-line fs-1 text-muted"></i>
                                                    <p class="text-muted mb-0">No image uploaded</p>
                                                </div>
                                            @endif
                                        @endif
                                    </div>                                                    <!-- Upload Button -->
                                                    <button type="button" 
                                                            class="btn btn-outline-primary btn-sm w-100 upload-banner-btn" 
                                                            data-key="{{ $key }}"
                                                            data-label="{{ $banner['label'] }}"
                                                            data-description="{{ $banner['description'] }}"
                                                            data-is-multiple="{{ $banner['is_multiple'] ? 'true' : 'false' }}"
                                                            title="Upload {{ $banner['label'] }}">
                                                        <i class="ri-upload-line"></i> 
                                                        {{ $banner['is_multiple'] ? 'Upload Images' : 'Upload Image' }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
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

<!-- Upload Banner Modal -->
<div class="modal fade" id="uploadBannerModal" tabindex="-1" aria-labelledby="uploadBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadBannerModalLabel">Upload Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadBannerForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <h6 id="bannerLabel">Banner Name</h6>
                        <p class="text-muted" id="bannerDescription">Banner description</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <span id="uploadLabel">Upload Image</span>
                            <span class="text-danger">*</span>
                        </label>
                        <div id="uploadContainer">
                            <!-- Dynamic upload input will be inserted here -->
                        </div>
                        <div class="invalid-feedback"></div>
                        <small class="text-muted">
                            Supported formats: JPEG, PNG, JPG, GIF, WebP. Maximum size: 2MB per image.
                        </small>
                    </div>

                    <!-- Preview Container -->
                    <div id="previewContainer" class="mb-3" style="display: none;">
                        <label class="form-label">Preview</label>
                        <div id="previewImages" class="row"></div>
                    </div>

                    <div class="alert alert-info">
                        <i class="ri-information-line"></i>
                        <strong>Note:</strong> 
                        <span id="uploadNote">Uploading new images will replace existing ones.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-upload-line"></i> <span id="submitText">Upload Image</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('head')
<style>
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.current-images img {
    transition: transform 0.2s;
}

.current-images img:hover {
    transform: scale(1.05);
}

.upload-preview {
    position: relative;
    margin-bottom: 10px;
}

.upload-preview img {
    width: 100%;
    height: 100px;
    object-fit: cover;
    border-radius: 0.375rem;
}

.upload-preview .remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(220, 53, 69, 0.8);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.file-drop-area {
    border: 2px dashed #dee2e6;
    border-radius: 0.375rem;
    padding: 2rem;
    text-align: center;
    transition: border-color 0.2s;
    background-color: #f8f9fa;
}

.file-drop-area.dragover {
    border-color: #0d6efd;
    background-color: #e7f1ff;
}

.file-drop-area input[type="file"] {
    display: none;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let currentBannerKey = null;
    let isMultiple = false;
    let selectedFiles = [];
    
    // Upload banner button click
    $('.upload-banner-btn').on('click', function() {
        const data = $(this).data();
        currentBannerKey = data.key;
        isMultiple = data.isMultiple === 'true';
        selectedFiles = [];
        
        $('#bannerLabel').text(data.label);
        $('#bannerDescription').text(data.description);
        
        // Update labels and note
        if (isMultiple) {
            $('#uploadLabel').text('Upload Images');
            $('#submitText').text('Upload Images');
            $('#uploadNote').text('You can upload multiple images. New images will replace existing ones.');
        } else {
            $('#uploadLabel').text('Upload Image');
            $('#submitText').text('Upload Image');
            $('#uploadNote').text('Uploading a new image will replace the existing one.');
        }
        
        // Build upload input
        buildUploadInput();
        
        // Clear preview
        $('#previewContainer').hide();
        $('#previewImages').empty();
        
        $('#uploadBannerModal').modal('show');
    });
    
    // Build upload input based on type
    function buildUploadInput() {
        let inputHtml = '';
        
        if (isMultiple) {
            inputHtml = `
                <div class="file-drop-area" id="fileDropArea">
                    <i class="ri-upload-cloud-line fs-1 text-muted"></i>
                    <p class="mb-2">Drag and drop images here or click to browse</p>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="$('#fileInput').click()">
                        Choose Images
                    </button>
                    <input type="file" id="fileInput" name="images[]" multiple accept="image/*">
                </div>
            `;
        } else {
            inputHtml = `
                <div class="file-drop-area" id="fileDropArea">
                    <i class="ri-upload-cloud-line fs-1 text-muted"></i>
                    <p class="mb-2">Drag and drop an image here or click to browse</p>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="$('#fileInput').click()">
                        Choose Image
                    </button>
                    <input type="file" id="fileInput" name="image" accept="image/*">
                </div>
            `;
        }
        
        $('#uploadContainer').html(inputHtml);
        
        // Setup drag and drop
        setupDragAndDrop();
        
        // Setup file input change
        $('#fileInput').on('change', function() {
            handleFileSelection(this.files);
        });
    }
    
    // Setup drag and drop functionality
    function setupDragAndDrop() {
        const dropArea = $('#fileDropArea')[0];
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        dropArea.addEventListener('drop', handleDrop, false);
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        function highlight() {
            dropArea.classList.add('dragover');
        }
        
        function unhighlight() {
            dropArea.classList.remove('dragover');
        }
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFileSelection(files);
        }
    }
    
    // Handle file selection
    function handleFileSelection(files) {
        selectedFiles = [];
        const fileArray = Array.from(files);
        
        // Validate file count
        if (!isMultiple && fileArray.length > 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Single Image Only',
                text: 'Please select only one image for this banner.'
            });
            return;
        }
        
        if (isMultiple && fileArray.length > 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Too Many Images',
                text: 'Please select maximum 10 images.'
            });
            return;
        }
        
        // Validate each file
        for (let file of fileArray) {
            if (!file.type.startsWith('image/')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File',
                    text: `${file.name} is not a valid image file.`
                });
                return;
            }
            
            if (file.size > 2 * 1024 * 1024) { // 2MB
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: `${file.name} is larger than 2MB.`
                });
                return;
            }
        }
        
        selectedFiles = fileArray;
        showPreview();
    }
    
    // Show preview of selected images
    function showPreview() {
        if (selectedFiles.length === 0) {
            $('#previewContainer').hide();
            return;
        }
        
        $('#previewImages').empty();
        
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const colClass = isMultiple ? 'col-md-3 col-6' : 'col-md-6 mx-auto';
                const previewHtml = `
                    <div class="${colClass} mb-3">
                        <div class="upload-preview">
                            <img src="${e.target.result}" alt="Preview">
                            <button type="button" class="remove-image" onclick="removePreview(${index})">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block text-center">${file.name}</small>
                    </div>
                `;
                $('#previewImages').append(previewHtml);
            };
            reader.readAsDataURL(file);
        });
        
        $('#previewContainer').show();
    }
    
    // Remove preview (global function)
    window.removePreview = function(index) {
        selectedFiles.splice(index, 1);
        showPreview();
        
        // Update file input
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        $('#fileInput')[0].files = dt.files;
    };
    
    // Handle form submission
    $('#uploadBannerForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!currentBannerKey || selectedFiles.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Files Selected',
                text: 'Please select at least one image to upload.'
            });
            return;
        }
        
        const formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('_method', 'PUT');
        
        if (isMultiple) {
            selectedFiles.forEach(file => {
                formData.append('images[]', file);
            });
        } else {
            formData.append('image', selectedFiles[0]);
        }
        
        $.ajax({
            url: `/admin/banners/${currentBannerKey}`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#uploadBannerForm button[type="submit"]').prop('disabled', true);
                $('#fileInput').removeClass('is-invalid');
            },
            success: function(response) {
                $('#uploadBannerModal').modal('hide');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response.errors) {
                    let errorMessage = '';
                    for (const [field, messages] of Object.entries(response.errors)) {
                        errorMessage += messages.join('\n') + '\n';
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: errorMessage
                    });
                } else if (response.message) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while uploading the banner.'
                    });
                }
            },
            complete: function() {
                $('#uploadBannerForm button[type="submit"]').prop('disabled', false);
            }
        });
    });
    
    // Clear validation errors and preview when modal closes
    $('#uploadBannerModal').on('hidden.bs.modal', function() {
        selectedFiles = [];
        $('#previewContainer').hide();
        $('#previewImages').empty();
        $('#fileInput').removeClass('is-invalid');
    });
});
</script>
@endpush
