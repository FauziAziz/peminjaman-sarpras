<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RuangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $ruangId = $this->route('ruang')?->id_ruang;

        return [
            'nama_ruang' => ['required', 'string', 'max:255', Rule::unique('ruang', 'nama_ruang')->ignore($ruangId, 'id_ruang')],
            'kode_ruang' => ['required', 'string', 'max:50', Rule::unique('ruang', 'kode_ruang')->ignore($ruangId, 'id_ruang')],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
