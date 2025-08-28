@extends('layouts.seller.main')

@section('title', 'KYC Verification Application')

@section('content')
    <!--=== Start Section Title Area ===-->
    <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
        <h4 class="text-dark mb-0">KYC Verification Application</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none"
                        href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{ route('kyc.index') }}">KYC
                        Verification</a></li>
                <li class="breadcrumb-item fs-14 text-primary" aria-current="page">Apply</li>
            </ol>
        </nav>
    </div>
    <!--=== End Section Title Area ===-->

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">KYC Verification Application</h4>
                    <p class="text-muted mb-0">Complete your Know Your Customer verification to start selling</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('kyc.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Personal Information -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Personal Information</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="first_name" class="form-label">First Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                        id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="last_name" class="form-label">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                        id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="gender" class="form-label">Gender <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                        name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="nationality" class="form-label">Nationality <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nationality') is-invalid @enderror"
                                        id="nationality" name="nationality" value="{{ old('nationality') }}" required>
                                    @error('nationality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address Information -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Address Information</h5>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Street Address <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                placeholder="Jln. Nyi Ageng Serang, No. 59" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="province" class="form-label">Province <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('province') is-invalid @enderror" id="province"
                                        name="province" required>
                                        <option value="">-- Select Province --</option>
                                    </select>
                                    @error('province')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="city" class="form-label">City <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('city') is-invalid @enderror" id="city"
                                        name="city" required>
                                        <option value="">-- Select City --</option>
                                    </select>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="subdistrict" class="form-label">Subdistrict <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('subdistrict') is-invalid @enderror"
                                        id="subdistrict" name="subdistrict" required>
                                        <option value="">-- Select Subdistrict --</option>
                                    </select>
                                    @error('subdistrict')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="postal_code" class="form-label">Postal Code <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('postal_code') is-invalid @enderror"
                                        id="postal_code" name="postal_code" required>
                                        <option value="">-- Select Postal Code --</option>
                                    </select>
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="village" class="form-label">Village <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('village') is-invalid @enderror"
                                        id="village" name="village" required>
                                        <option value="">-- Select Village --</option>
                                    </select>
                                    @error('village')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="country" class="form-label">Country <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        id="country" name="country" value="{{ old('country') }}" required>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Document Information -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Identity Document</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="document_type" class="form-label">Document Type <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('document_type') is-invalid @enderror"
                                        id="document_type" name="document_type" required>
                                        <option value="">Select Document Type</option>
                                        <option value="national_id"
                                            {{ old('document_type') == 'national_id' ? 'selected' : '' }}>National ID
                                        </option>
                                        <option value="passport"
                                            {{ old('document_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                                        <option value="driving_license"
                                            {{ old('document_type') == 'driving_license' ? 'selected' : '' }}>Driving
                                            License</option>
                                    </select>
                                    @error('document_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="document_number" class="form-label">Document Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('document_number') is-invalid @enderror"
                                        id="document_number" name="document_number" value="{{ old('document_number') }}"
                                        required>
                                    @error('document_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="document_expiry_date" class="form-label">Document Expiry Date</label>
                                    <input type="date"
                                        class="form-control @error('document_expiry_date') is-invalid @enderror"
                                        id="document_expiry_date" name="document_expiry_date"
                                        value="{{ old('document_expiry_date') }}">
                                    @error('document_expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="document_issued_country" class="form-label">Document Issued Country <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('document_issued_country') is-invalid @enderror"
                                        id="document_issued_country" name="document_issued_country"
                                        value="{{ old('document_issued_country') }}" required>
                                    @error('document_issued_country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Document Upload -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Document Upload</h5>
                                <p class="text-muted">Upload clear, high-quality images of your documents. All documents
                                    must be readable and not expired.</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="document_front" class="form-label">Document Front Photo <span
                                            class="text-danger">*</span></label>
                                    <input type="file"
                                        class="form-control @error('document_front') is-invalid @enderror"
                                        id="document_front" name="document_front" accept="image/*" required>
                                    <small class="form-text text-muted">Maximum file size: 5MB. Supported formats: JPEG,
                                        PNG, JPG, WebP</small>
                                    @error('document_front')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="selfie" class="form-label">Selfie with Document <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('selfie') is-invalid @enderror"
                                id="selfie" name="selfie" accept="image/*" required>
                            <small class="form-text text-muted">Take a clear selfie holding your ID document next to your
                                face. Maximum file size: 5MB.</small>
                            @error('selfie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="additional_docs" class="form-label">Additional Documents (Optional)</label>
                            <input type="file" class="form-control @error('additional_docs.*') is-invalid @enderror"
                                id="additional_docs" name="additional_docs[]" accept="image/*,application/pdf" multiple>
                            <small class="form-text text-muted">Upload any additional supporting documents. Maximum file
                                size: 10MB per file.</small>
                            @error('additional_docs.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Terms and Conditions</h5>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input @error('terms_accepted') is-invalid @enderror"
                                id="terms_accepted" name="terms_accepted" value="1"
                                {{ old('terms_accepted') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="terms_accepted">
                                I agree to the <a href="#" target="_blank">Terms and Conditions</a> <span
                                    class="text-danger">*</span>
                            </label>
                            @error('terms_accepted')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox"
                                class="form-check-input @error('privacy_accepted') is-invalid @enderror"
                                id="privacy_accepted" name="privacy_accepted" value="1"
                                {{ old('privacy_accepted') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="privacy_accepted">
                                I agree to the <a href="#" target="_blank">Privacy Policy</a> <span
                                    class="text-danger">*</span>
                            </label>
                            @error('privacy_accepted')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kyc.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-send-plane-line"></i> Submit KYC Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            let provinces = [];
            let cities = [];
            let subdistricts = [];
            let villages = [];
            let postals = [];

            const oldProvince = "{{ old('province') }}";
            const oldCity = "{{ old('city') }}";
            const oldSubdistrict = "{{ old('subdistrict') }}";
            const oldVillage = "{{ old('village') }}";
            const oldPostal = "{{ old('postal_code') }}";

            let $province = $("#province"),
                $city = $("#city"),
                $subdistrict = $("#subdistrict"),
                $village = $("#village");
                $postal = $("#postal_code");

            $(document).ready(function() {
                // Load all JSON (update path sesuai lokasi file di public/json)
                $.getJSON("{{ asset('assets/js/provinces.json') }}", function(data) {
                    provinces = data.sort((a, b) => a.name.localeCompare(b.name));
                    $.each(provinces, function(_, prov) {
                        $province.append(`<option value="${prov.id}">${prov.name}</option>`);
                    });

                    if (oldProvince) {
                        $province.val(oldProvince).trigger('change');
                    }
                });

                $.getJSON("{{ asset('assets/js/cities.json') }}", function(data) {
                    cities = data;

                    if (oldProvince && oldCity) {
                        setTimeout(() => {
                            $city.val(oldCity).trigger('change');
                        }, 300); // kasih delay biar cities sempat di-append
                    }
                });

                $.getJSON("{{ asset('assets/js/sub_districts.json') }}", function(data) {
                    subdistricts = data;

                    if (oldCity && oldSubdistrict) {
                        setTimeout(() => {
                            $subdistrict.val(oldSubdistrict).trigger('change');
                        }, 600);
                    }
                });

                $.getJSON("{{ asset('assets/js/villages.json') }}", function(data) {
                    villages = data;

                    if (oldSubdistrict && oldVillage) {
                        setTimeout(() => {
                            $village.val(oldVillage).trigger('change');
                        }, 900);
                    }
                });

                $.getJSON("{{ asset('assets/js/postal_codes.json') }}", function(data) {
                    postals = data;

                    if (oldVillage && oldPostal) {
                        setTimeout(() => {
                            $postal.val(oldPostal);
                        }, 1200);
                    }
                });

                // Cities (urut abjad)
                $province.on('change', function() {
                    const provId = $(this).val();

                    $city.html('<option value="">-- Select City --</option>');
                    $subdistrict.html('<option value="">-- Select Subdistrict --</option>');
                    $village.html('<option value="">-- Select Village --</option>');
                    $postal.html('<option value="">-- Select Postal Code --</option>');

                    const filteredCities = cities
                        .filter(c => c.province_id == provId)
                        .sort((a, b) => a.name.localeCompare(b.name));

                    $.each(filteredCities, function(_, city) {
                        $city.append(`<option value="${city.id}">${city.name}</option>`);
                    });
                });

                $city.on('change', function() {
                    const cityId = $(this).val();

                    $subdistrict.html('<option value="">-- Select Subdistrict --</option>');
                    $village.html('<option value="">-- Select Village --</option>');
                    $postal.html('<option value="">-- Select Postal Code --</option>');

                    const filteredSubs = subdistricts
                        .filter(s => s.city_id == cityId)
                        .sort((a, b) => a.name.localeCompare(b.name));

                    $.each(filteredSubs, function(_, sub) {
                        $subdistrict.append(
                            `<option value="${sub.id}">${sub.name}</option>`
                        );
                    });
                });

                $subdistrict.on('change', function() {
                    const subdistrictId = $(this).val();

                    $village.html('<option value="">-- Select Village --</option>');
                    $postal.html('<option value="">-- Select Postal Code --</option>');

                    const filteredVillages = villages
                        .filter(p => p.subdistrict_id == subdistrictId)
                        .sort((a, b) => a.name.localeCompare(b.name));

                    $.each(filteredVillages, function(_, vill) {
                        $village.append(
                            `<option value="${vill.id}">${vill.name}</option>`
                        );
                    });
                });

                $village.on('change', function() {
                    const villageId = $(this).val();

                    $postal.html('<option value="">-- Select Postal Code --</option>');

                    const filteredPostals = postals
                        .filter(p => p.village_id == villageId)
                        .sort((a, b) => a.name.localeCompare(b.name));

                    $.each(filteredPostals, function(_, pc) {
                        $postal.append(
                            `<option value="${pc.id}">${pc.name}</option>`
                        );
                    });
                });
            });
        </script>
    @endpush
@endsection
