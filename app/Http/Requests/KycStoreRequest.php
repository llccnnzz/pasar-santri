<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KycStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'              => 'required|string|max:255',
            'last_name'               => 'required|string|max:255',
            'date_of_birth'           => 'required|date|before:today|after:1900-01-01',
            'gender'                  => 'required|in:male,female,other',
            'nationality'             => 'required|string|max:100',
            'address'                 => 'required|string|max:500',
            'province'                => 'required|string|max:100',
            'city'                    => 'required|string|max:100',
            'subdistrict'             => 'required|string|max:100',
            'village'                 => 'required|string|max:100',
            'postal_code'             => 'required|string|max:20',
            'country'                 => 'required|string|max:100',
            'phone'                   => 'required|string|max:20',
            'document_type'           => 'required|in:national_id,passport,driving_license',
            'document_number'         => 'required|string|max:100',
            'document_expiry_date'    => 'nullable|date|after:today',
            'document_issued_country' => 'required|string|max:100',
            'document_front'          => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'selfie'                  => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'additional_docs.*'       => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'terms_accepted'          => 'required|accepted',
            'privacy_accepted'        => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'              => 'First name is required.',
            'first_name.string'                => 'First name must be a valid string.',
            'first_name.max'                   => 'First name may not be longer than 255 characters.',

            'last_name.required'               => 'Last name is required.',
            'last_name.string'                 => 'Last name must be a valid string.',
            'last_name.max'                    => 'Last name may not be longer than 255 characters.',

            'date_of_birth.required'           => 'Date of birth is required.',
            'date_of_birth.date'               => 'Date of birth must be a valid date.',
            'date_of_birth.before'             => 'Date of birth must be before today.',
            'date_of_birth.after'              => 'Date of birth must be after January 1, 1900.',

            'gender.required'                  => 'Gender is required.',
            'gender.in'                        => 'Gender must be either male, female, or other.',

            'nationality.required'             => 'Nationality is required.',
            'nationality.string'               => 'Nationality must be a valid string.',
            'nationality.max'                  => 'Nationality may not be longer than 100 characters.',

            'address.required'                 => 'Address is required.',
            'address.string'                   => 'Address must be a valid string.',
            'address.max'                      => 'Address may not be longer than 500 characters.',

            'province.required'                => 'Province is required.',
            'province.string'                  => 'Province must be a valid string.',
            'province.max'                     => 'Province may not be longer than 100 characters.',

            'city.required'                    => 'City is required.',
            'city.string'                      => 'City must be a valid string.',
            'city.max'                         => 'City may not be longer than 100 characters.',

            'province.required'                => 'Province is required.',
            'province.string'                  => 'Province must be a valid string.',
            'province.max'                     => 'Province may not be longer than 100 characters.',

            'subdistrict.required'             => 'Subdistrict is required.',
            'subdistrict.string'               => 'Subdistrict must be a valid string.',
            'subdistrict.max'                  => 'Subdistrict may not be longer than 100 characters.',

            'village.required'                 => 'Village is required.',
            'village.string'                   => 'Village must be a valid string.',
            'village.max'                      => 'Village may not be longer than 100 characters.',

            'postal_code.required'             => 'Postal code is required.',
            'postal_code.string'               => 'Postal code must be a valid string.',
            'postal_code.max'                  => 'Postal code may not be longer than 20 characters.',

            'country.required'                 => 'Country is required.',
            'country.string'                   => 'Country must be a valid string.',
            'country.max'                      => 'Country may not be longer than 100 characters.',

            'phone.required'                   => 'Phone number is required.',
            'phone.string'                     => 'Phone number must be a valid string.',
            'phone.max'                        => 'Phone number may not be longer than 20 characters.',

            'document_type.required'           => 'Document type is required.',
            'document_type.in'                 => 'Document type must be national_id, passport, or driving_license.',

            'document_number.required'         => 'Document number is required.',
            'document_number.string'           => 'Document number must be a valid string.',
            'document_number.max'              => 'Document number may not be longer than 100 characters.',

            'document_expiry_date.date'        => 'Document expiry date must be a valid date.',
            'document_expiry_date.after'       => 'Document expiry date must be a future date.',

            'document_issued_country.required' => 'Document issued country is required.',
            'document_issued_country.string'   => 'Document issued country must be a valid string.',
            'document_issued_country.max'      => 'Document issued country may not be longer than 100 characters.',

            'document_front.required'          => 'Front side of the document is required.',
            'document_front.image'             => 'Front side of the document must be an image.',
            'document_front.mimes'             => 'Front side of the document must be a file of type: jpeg, png, jpg, webp.',
            'document_front.max'               => 'Front side of the document may not be larger than 5MB.',

            'selfie.required'                  => 'A selfie is required.',
            'selfie.image'                     => 'Selfie must be an image.',
            'selfie.mimes'                     => 'Selfie must be a file of type: jpeg, png, jpg, webp.',
            'selfie.max'                       => 'Selfie may not be larger than 5MB.',

            'additional_docs.*.file'           => 'Each additional document must be a valid file.',
            'additional_docs.*.mimes'          => 'Additional documents must be of type: jpeg, png, jpg, webp, pdf.',
            'additional_docs.*.max'            => 'Each additional document may not be larger than 10MB.',

            'terms_accepted.required'          => 'You must accept the terms and conditions.',
            'terms_accepted.accepted'          => 'You must accept the terms and conditions.',

            'privacy_accepted.required'        => 'You must accept the privacy policy.',
            'privacy_accepted.accepted'        => 'You must accept the privacy policy.',
        ];
    }
}
