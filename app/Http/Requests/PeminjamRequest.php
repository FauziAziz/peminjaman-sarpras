<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PeminjamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $peminjamId = $this->route('peminjam')?->id_peminjam;

        return [
            'nama_peminjam' => [
                'required',
                'string',
                'max:255',
                Rule::unique('peminjam', 'nama_peminjam')->where(function ($query) {
                    return $query->where('jabatan', $this->input('jabatan'));
                })->ignore($peminjamId, 'id_peminjam'),
            ],
            'jabatan' => ['required', 'string', 'max:100'],
            'aktif' => ['nullable', 'boolean'],
        ];
    }
}
