<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'long_description'  => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'final_price'       => 'nullable|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'global_categories' => 'required|array|min:1',
            'global_categories.*' => 'exists:categories,id',
            'local_categories'  => 'nullable|array',
            'local_categories.*'=> 'exists:categories,id',
            'sku'               => 'nullable|string|max:100|unique:products,sku',
            'default_image'     => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hover_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title'        => 'nullable|string|max:255',
            'meta_keywords'     => 'nullable|string',
            'meta_description'  => 'nullable|string',
            'status'            => 'required|in:active,inactive',
            'weight'            => 'nullable|numeric|min:0',
            'dimensions'        => 'nullable|string',
            'brand'             => 'nullable|string|max:100',
            'tags'              => 'nullable|string',
            'specification'     => 'nullable|string',
            'is_featured'       => 'boolean',
            'is_popular'        => 'boolean',
        ];
    }
}
