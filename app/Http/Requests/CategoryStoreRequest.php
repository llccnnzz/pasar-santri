<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CategoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $shop = $this->user()->shop;

        return [
            'name' => 'required|string|max:255|unique:categories,name,NULL,id,shop_id,' . $shop->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug',
        ];
    }
}
