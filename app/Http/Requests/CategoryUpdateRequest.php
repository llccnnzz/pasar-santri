<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $shop = Auth::user()->shop;
        $category = $this->route('category');

        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id . ',id,shop_id,' . $shop->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
        ];
    }
}
