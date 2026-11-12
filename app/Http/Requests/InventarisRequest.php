<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventarisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $inventarisId = $this->route('inventaris')?->id_inventaris;

        return [
            'kode_inventaris' => ['required', 'string', 'max:50', Rule::unique('inventaris', 'kode_inventaris')->ignore($inventarisId, 'id_inventaris')],
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('inventaris', 'nama')->where(function ($query) {
                    return $query->where('id_kategori', $this->input('id_kategori'));
                })->ignore($inventarisId, 'id_inventaris'),
            ],
            'id_kategori' => ['required', 'exists:kategori,id_kategori'],
            'id_ruang' => ['nullable', 'exists:ruang,id_ruang'],
            'jumlah' => ['required', 'integer', 'min:0'],
            'kondisi' => ['required', 'string', 'in:baik,rusak ringan,rusak berat'],
            'keterangan' => ['nullable', 'string'],
            'tanggal_register' => ['required', 'date'],
        ];
    }
}
