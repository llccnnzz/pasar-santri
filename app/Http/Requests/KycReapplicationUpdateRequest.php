<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KycReapplicationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'             => 'required|string|max:255',
            'last_name'              => 'required|string|max:255',
            'date_of_birth'          => 'required|date|before:today|after:1900-01-01',
            'gender'                 => 'required|in:male,female,other',
            'nationality'            => 'required|string|max:100',
            'address'                => 'required|string|max:500',
            'city'                   => 'required|string|max:100',
            'state'                  => 'required|string|max:100',
            'postal_code'            => 'required|string|max:20',
            'country'                => 'required|string|max:100',
            'phone'                  => 'required|string|max:20',
            'document_type'          => 'required|in:national_id,passport,driving_license',
            'document_number'        => 'required|string|max:100',
            'document_expiry_date'   => 'required|date|after:today',
            'document_issued_country'=> 'required|string|max:100',
            'document_front'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'document_back'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'selfie'                 => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'additional_docs.*'      => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'terms_accepted'         => 'required|accepted',
            'privacy_accepted'       => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'terms_accepted.accepted'   => 'You must accept the terms and conditions.',
            'privacy_accepted.accepted' => 'You must accept the privacy policy.',
        ];
    }
}
