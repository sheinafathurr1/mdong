<?php

namespace App\Http\Requests\Mahasiswa;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'teknik.*'      => ['nullable', Rule::in(Project::TEKNIK_OPTIONS)],
            'metode'        => 'nullable|array',
            'metode.*'      => ['nullable', Rule::in(Project::SKILL_SET_OPTIONS)],
            'material'      => 'nullable|array',
            'material.*'    => ['nullable', Rule::in(Project::MATERIAL_OPTIONS)],
            'narasi'        => 'required|array',
            'narasi.*'      => 'required|string',
        ];
    }
}
