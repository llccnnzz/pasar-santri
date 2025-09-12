<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopSettingsUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $shop = $this->user()->shop;

        return [
            'name'                   => 'required|string|max:255|unique:shops,name,' . $shop->id,
            'slug'                   => 'required|string|max:255|unique:shops,slug,' . $shop->id,
            'description'            => 'nullable|string|max:1000',
            'province'               => 'required|string|max:255',
            'city'                   => 'required|string|max:255',
            'subdistrict'            => 'required|string|max:255',
            'village'                => 'required|string|max:255',
            'postal_code'            => 'required|string|max:20',
            'country'                => 'required|string|max:100',
            'address'                => 'required|string|max:500',
            'phone'                  => 'nullable|string|max:20',
            'is_open'                => 'boolean',
            'social_links'           => 'nullable|array',
            'social_links.facebook'  => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.twitter'   => 'nullable|url',
            'social_links.website'   => 'nullable|url',
            'logo'                   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'              => 'The shop name is required.',
            'name.string'                => 'The shop name must be a valid string.',
            'name.max'                   => 'The shop name may not exceed 255 characters.',
            'name.unique'                => 'This shop name is already taken.',

            'slug.required'              => 'The shop slug is required.',
            'slug.string'                => 'The shop slug must be a valid string.',
            'slug.max'                   => 'The shop slug may not exceed 255 characters.',
            'slug.unique'                => 'This shop slug is already taken.',

            'description.string'         => 'The description must be a valid string.',
            'description.max'            => 'The description may not exceed 1000 characters.',

            'province.required'          => 'The province is required.',
            'province.string'            => 'The province must be a valid string.',
            'province.max'               => 'The province may not exceed 255 characters.',

            'city.required'              => 'The city is required.',
            'city.string'                => 'The city must be a valid string.',
            'city.max'                   => 'The city may not exceed 255 characters.',

            'subdistrict.required'       => 'The subdistrict is required.',
            'subdistrict.string'         => 'The subdistrict must be a valid string.',
            'subdistrict.max'            => 'The subdistrict may not exceed 255 characters.',

            'village.required'           => 'The village is required.',
            'village.string'             => 'The village must be a valid string.',
            'village.max'                => 'The village may not exceed 255 characters.',

            'postal_code.required'       => 'The postal code is required.',
            'postal_code.string'         => 'The postal code must be a valid string.',
            'postal_code.max'            => 'The postal code may not exceed 20 characters.',

            'country.required'           => 'The country is required.',
            'country.string'             => 'The country must be a valid string.',
            'country.max'                => 'The country may not exceed 100 characters.',

            'address.required'           => 'The address is required.',
            'address.string'             => 'The address must be a valid string.',
            'address.max'                => 'The address may not exceed 500 characters.',

            'phone.string'               => 'The phone number must be a valid string.',
            'phone.max'                  => 'The phone number may not exceed 20 characters.',

            'is_open.boolean'            => 'The "is open" field must be true or false.',

            'social_links.array'         => 'The social links must be provided as an array.',
            'social_links.facebook.url'  => 'The Facebook link must be a valid URL.',
            'social_links.instagram.url' => 'The Instagram link must be a valid URL.',
            'social_links.twitter.url'   => 'The Twitter link must be a valid URL.',
            'social_links.website.url'   => 'The Website link must be a valid URL.',

            'logo.image'                 => 'The logo must be an image.',
            'logo.mimes'                 => 'The logo must be in jpeg, png, jpg, or webp format.',
            'logo.max'                   => 'The logo may not exceed 2 MB.',
        ];
    }
}
