<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $petugasId = $this->route('petugas')?->id_petugas ?? $this->route('petuga');

        return [
            'username' => ['required', 'string', 'max:255', Rule::unique('petugas', 'username')->ignore($petugasId, 'id_petugas')],
            'password' => $this->isMethod('POST') ? ['required', 'string', 'min:6'] : ['nullable', 'string', 'min:6'],
            'nama_petugas' => ['required', 'string', 'max:255'],
            'id_level' => ['required', 'exists:level,id_level'],
        ];
    }
}
