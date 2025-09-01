<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingToggleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'enabled'            => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'shipping_method_id.required' => 'Shipping method ID is required.',
            'shipping_method_id.exists'   => 'Selected shipping method does not exist.',
            'enabled.required'            => 'Enabled flag is required.',
            'enabled.boolean'             => 'Enabled must be true or false.',
        ];
    }
}
