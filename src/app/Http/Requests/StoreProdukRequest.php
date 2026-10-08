<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProdukRequest extends FormRequest
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
            'aktif' => $this->boolean('aktif'), // memastikan selalu boolean
            'stok' => $this->input('stok') === null || $this->input('stok') === '' ? 0 : $this->input('stok'), // default stok 0
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
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:255|unique:produk,kode', // kode tidak boleh sama dengan kode milik produk manapun di tabel
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'aktif' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama produk wajib diisi.',
            'kode.required' => 'Kode produk wajib diisi.',
            'kode.unique' => 'Kode produk sudah digunakan.',
            'harga.required' => 'Harga produk wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka bulat.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
        ];
    }

}
