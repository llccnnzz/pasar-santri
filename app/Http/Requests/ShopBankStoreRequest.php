<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ShopBankStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $shop = Auth::user()->shop;

        return [
            'bank_code' => 'required|string|max:10',
            'bank_name' => 'required|string|max:255',
            'account_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('shop_banks')->where(function ($query) use ($shop) {
                    return $query->where('shop_id', $shop->id);
                }),
            ],
            'is_default' => 'nullable|boolean',
        ];
    }
}
