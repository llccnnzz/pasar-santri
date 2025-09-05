<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address_id'         => 'required',
            'shipping'           => 'required|array',
            'shipping.*.courier' => 'required|string',
        ];
    }
}
