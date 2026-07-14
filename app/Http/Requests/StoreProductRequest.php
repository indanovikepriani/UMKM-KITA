<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Asumsi auth di-handle middleware
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_price' => 'required|numeric|min:0',
            'price' => 'nullable|numeric|min:0|gt:discount_price',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'umkm_name' => 'nullable|string|max:255',
            'umkm_address' => 'nullable|string|max:255',
        ];
    }
}