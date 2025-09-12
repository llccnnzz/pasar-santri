<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopBankUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $shop = $this->user()->shop;
        $bankAccountId = $this->route('bankAccount')->id;

        return [
            'bank_code' => 'required|string|max:10',
            'bank_name' => 'required|string|max:255',
            'account_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('shop_banks')->where(function ($query) use ($shop) {
                    return $query->where('shop_id', $shop->id);
                })->ignore($bankAccountId),
            ],
            'account_name' => 'required|string|max:255',
            'is_default' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'bank_code.required' => 'Kode bank wajib diisi.',
            'bank_name.required' => 'Nama bank wajib diisi.',
            'account_number.required' => 'Nomor rekening wajib diisi.',
            'account_number.unique' => 'Nomor rekening ini sudah terdaftar di toko Anda.',
            'account_name.required' => 'Nama pemilik rekening wajib diisi.',
        ];
    }
}
