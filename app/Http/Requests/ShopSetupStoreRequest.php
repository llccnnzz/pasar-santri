<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopSetupStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255|unique:shops,name',
            'slug'         => 'required|string|max:255|unique:shops,slug',
            'description'  => 'nullable|string|max:1000',
            'province'     => 'required|string|max:255',
            'city'         => 'required|string|max:255',
            'subdistrict'  => 'required|string|max:255',
            'postal_code'  => 'required|string|max:20',
            'country'      => 'required|string|max:100',
            'street_address' => 'required|string|max:500',
            'phone'        => 'nullable|string|max:20',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
