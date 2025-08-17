<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')->id ?? null;

        return [
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'price'             => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'global_categories' => 'required|array|min:1',
            'global_categories.*' => 'exists:categories,id',
            'local_categories'  => 'nullable|array',
            'local_categories.*'=> 'exists:categories,id',
            'sku'               => 'nullable|string|max:100|unique:products,sku,' . $productId,
            'default_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hover_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title'        => 'nullable|string|max:255',
            'meta_keywords'     => 'nullable|string',
            'meta_description'  => 'nullable|string',
            'long_description'  => 'nullable|string',
            'status'            => 'required|in:active,inactive',
            'weight'            => 'nullable|numeric|min:0',
            'dimensions'        => 'nullable|string',
            'brand'             => 'nullable|string|max:100',
        ];
    }
}
