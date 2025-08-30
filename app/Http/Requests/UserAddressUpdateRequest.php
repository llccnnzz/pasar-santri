<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label'          => 'required|string|max:255',
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'province'       => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'subdistrict'    => 'required|string|max:100',
            'village'        => 'required|string|max:100',
            'postal_code'    => 'required|string|max:20',
            'country'        => 'required|string|max:100',
            'is_primary'     => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'label.required'          => 'Please provide a label for this address (e.g., Home, Office).',
            'name.required'           => 'The full name is required.',
            'phone.required'          => 'The phone number is required.',
            'address_line_1.required' => 'Address Line 1 cannot be empty.',
            'city.required'           => 'City is required.',
            'subdistrict.required'    => 'Subdistrict is required.',
            'postal_code.required'    => 'Postal code is required.',
            'country.required'        => 'Country is required.',
        ];
    }
}
