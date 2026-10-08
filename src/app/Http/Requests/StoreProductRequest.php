<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Rule;

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
        $stock = $this->input('stock');

        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'stock' => ($stock === null || $stock === '') ? 0 : $stock,
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
            'code' => ['required', 'string', 'max:255', Rule::unique(Product::class, 'code')], // kode tidak boleh sama dengan kode milik produk manapun di tabel
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
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
            'name.max' => 'Nama produk maksimal 255 karakter.',
            'code.required' => 'Kode produk wajib diisi.',
            'code.unique' => 'Kode produk sudah digunakan.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.integer' => 'Harga harus berupa angka bulat.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
        ];
    }

}
