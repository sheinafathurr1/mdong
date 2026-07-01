<?php

namespace App\Http\Requests\Mahasiswa;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Kepemilikan project sudah dicek di controller sebelum validasi dijalankan
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_proyek' => 'required|string|max:255',
            'tipe_proyek' => 'required|in:Perancangan,Analisa',
            'teknik'      => 'nullable|string|max:255',
            'metode'      => 'nullable|string|max:255',
            'material'    => 'nullable|string|max:255',
            'narasi'      => 'required|string',
        ];
    }
}
