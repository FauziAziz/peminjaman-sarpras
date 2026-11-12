<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_peminjam' => ['required', 'exists:peminjam,id_peminjam'],
            'tanggal_pinjam' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id_inventaris' => ['required', 'exists:inventaris,id_inventaris'],
            'items.*.jumlah' => ['required', 'integer', 'min:1'],
        ];
    }
}
