<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in(['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded']),
            ],
            'cancellation_reason'              => 'required_if:status,cancelled|nullable|string|max:1000',
            'tracking_details'                 => 'nullable|array',
            'tracking_details.courier'         => 'nullable|string|max:255',
            'tracking_details.tracking_number' => 'nullable|string|max:255',
            'tracking_details.notes'           => 'nullable|string|max:1000',
            'collection_method'                => 'nullable|string|max:255',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->input('status') === 'cancelled' && !$this->filled('cancellation_reason')) {
            $this->merge([
                'cancellation_reason' => 'Cancelled by seller',
            ]);
        }
    }
}
