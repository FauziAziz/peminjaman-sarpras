<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kategoriId = $this->route('kategori')?->id_kategori;

        return [
            'nama_kategori' => ['required', 'string', 'max:255', Rule::unique('kategori', 'nama_kategori')->ignore($kategoriId, 'id_kategori')],
            'kode_kategori' => ['required', 'string', 'max:50', Rule::unique('kategori', 'kode_kategori')->ignore($kategoriId, 'id_kategori')],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
