<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryBulkDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_ids'   => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ];
    }

    public function messages(): array
    {
        return [
            'product_ids.required'   => 'Please provide product IDs to delete.',
            'product_ids.array'      => 'Product IDs must be in an array format.',
            'product_ids.*.exists'   => 'One or more product IDs are invalid.',
        ];
    }
}
