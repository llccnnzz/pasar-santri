<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletWithdrawRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:10000|max:50000000',
            'shop_bank_id' => 'required|exists:shop_banks,id',
            'note' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Withdrawal amount is required.',
            'amount.numeric' => 'Withdrawal amount must be a valid number.',
            'amount.min' => 'Minimum withdrawal is 10,000 IDR.',
            'amount.max' => 'Maximum withdrawal is 50,000,000 IDR.',
            'shop_bank_id.required' => 'Please select a valid bank account.',
            'shop_bank_id.exists' => 'The selected bank account does not exist.',
            'note.max' => 'Note cannot exceed 255 characters.',
        ];
    }
}
