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
        $shop = Auth::user()->shop;

        return [
            'name'                   => 'required|string|max:255|unique:shops,name,' . $shop->id,
            'slug'                   => 'required|string|max:255|unique:shops,slug,' . $shop->id,
            'description'            => 'nullable|string|max:1000',
            'address'                => 'nullable|string|max:500',
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
}
