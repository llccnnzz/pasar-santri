@extends('layouts.seller.main')

@section('title', 'Edit Profile - Seller Dashboard')

@section('content')
<!--=== Start Section Title Area ===-->
<div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
    <h4 class="text-dark mb-0">Edit Profile</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('seller.profile.index') }}">Profile</a></li>
            <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Edit Profile</li>
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

<form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card rounded-3 border-0 mb-24">
                <div class="card-body p-25">
                    <div class="card-title mb-20 pb-20 border-bottom border-color">
                        <h4 class="mb-2 mb-sm-0">Basic Information</h4>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-25">
                                <label class="fw-semibold fs-14 text-dark mb-2">Full Name<span class="text-danger">*</span></label>
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" id="name" value="{{ old('name', $user->name) }}" 
                                           placeholder="Enter Full Name" required>
                                    <label class="text-body fs-12" for="name">Enter Full Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-25">
                                <label class="fw-semibold fs-14 text-dark mb-2">Email Address<span class="text-danger">*</span></label>
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" id="email" value="{{ old('email', $user->email) }}" 
                                           placeholder="Enter Email Address" required>
                                    <label class="text-body fs-12" for="email">Enter Email Address</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-25">
                                <label class="fw-semibold fs-14 text-dark mb-2">Phone Number</label>
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                                           placeholder="Enter Phone Number">
                                    <label class="text-body fs-12" for="phone">Enter Phone Number</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-25">
                                <label class="fw-semibold fs-14 text-dark mb-2">Date of Birth</label>
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                           name="date_of_birth" id="date_of_birth" 
                                           value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}">
                                    <label class="text-body fs-12" for="date_of_birth">Select Date of Birth</label>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mb-25">
                                <label class="fw-semibold fs-14 text-dark mb-2">Gender</label>
                                <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-25">
                                <label class="fw-semibold fs-14 text-dark mb-2">Bio</label>
                                <div class="form-floating">
                                    <textarea class="form-control text-area @error('bio') is-invalid @enderror" 
                                              name="bio" id="bio" 
                                              placeholder="Tell us about yourself" rows="4">{{ old('bio', $user->bio) }}</textarea>
                                    <label class="text-body fs-12" for="bio">Tell us about yourself</label>
                                    @error('bio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="d-sm-flex justify-content-end text-center">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                <a href="{{ route('seller.profile.index') }}" class="btn btn-danger ms-2">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card rounded-3 border-0 mb-24">
                <div class="card-body p-25">
                    <div class="card-title mb-20 pb-20 border-bottom border-color">
                        <h4 class="mb-2 mb-sm-0">Profile Photo</h4>
                    </div>

                    <div class="text-center">
                        <div class="avatar-upload mb-20">
                            <div class="avatar-edit">
                                <input type='file' name="profile_photo" id="profilePhotoUpload" accept=".png, .jpg, .jpeg" />
                                <label for="profilePhotoUpload"></label>
                            </div>
                            <div class="avatar-preview-lg">
                                @if($user->profile_photo)
                                    <div id="profilePhotoPreview" style="background-image: url('{{ Storage::url($user->profile_photo) }}');"></div>
                                @else
                                    <div id="profilePhotoPreview" style="background-image: url('/admin-assets/assets/images/user/user.png');"></div>
                                @endif
                            </div>
                        </div>
                        
                        @if($user->profile_photo)
                            <p class="text-success fs-14 mb-3">
                                <i data-feather="check-circle" class="me-1"></i>
                                Profile photo uploaded
                            </p>
                        @else
                            <p class="text-muted fs-14 mb-3">
                                <i data-feather="upload" class="me-1"></i>
                                Click to upload profile photo
                            </p>
                        @endif
                        
                        @error('profile_photo')
                            <div class="text-danger fs-14">{{ $message }}</div>
                        @enderror
                        
                        <small class="text-muted">
                            Supported formats: JPEG, PNG, JPG<br>
                            Maximum size: 2MB
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile photo preview
    const profilePhotoUpload = document.getElementById('profilePhotoUpload');
    const profilePhotoPreview = document.getElementById('profilePhotoPreview');

    if (profilePhotoUpload) {
        profilePhotoUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePhotoPreview.style.backgroundImage = `url(${e.target.result})`;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush
@endsection
