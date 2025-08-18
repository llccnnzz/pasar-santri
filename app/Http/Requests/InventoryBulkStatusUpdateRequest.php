<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryBulkStatusUpdateRequest extends FormRequest
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
            'status'        => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'product_ids.required' => 'Product IDs are required.',
            'product_ids.array'    => 'Product IDs must be an array.',
            'product_ids.*.exists' => 'Some product IDs are invalid.',
            'status.required'      => 'Status is required.',
            'status.in'            => 'Status must be either active or inactive.',
        ];
    }
}
