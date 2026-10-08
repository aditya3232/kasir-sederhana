<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Checkbox yang tidak dicentang tidak terkirim,
     * jadi beri nilai default sebelum validasi.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'), // memastikan selalu boolean
            'stock' => $this->input('stock') === null || $this->input('stock') === '' ? 0 : $this->input('stock'), // default stok 0
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:product,code', // kode tidak boleh sama dengan kode milik produk manapun di tabel
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'code.required' => 'Kode produk wajib diisi.',
            'code.unique' => 'Kode produk sudah digunakan.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.integer' => 'Harga harus berupa angka bulat.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
        ];
    }

}
