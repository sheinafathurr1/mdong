<?php

namespace App\Http\Requests\Mahasiswa;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Sudah dijaga oleh middleware role:mahasiswa di routes/web.php
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_proyek'   => 'required|array',
            'nama_proyek.*' => 'required|string|max:255',
            'tipe_proyek'   => 'required|array',
            'tipe_proyek.*' => 'required|in:Perancangan,Analisa',
            'teknik'        => 'nullable|array',
            'teknik.*'      => 'nullable|string|max:255',
            'metode'        => 'nullable|array',
            'metode.*'      => 'nullable|string|max:255',
            'material'      => 'nullable|array',
            'material.*'    => 'nullable|string|max:255',
            'narasi'        => 'required|array',
            'narasi.*'      => 'required|string',
        ];
    }
}
