<?php

namespace App\Http\Requests\Mahasiswa;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'teknik'      => ['nullable', Rule::in(Project::TEKNIK_OPTIONS)],
            'metode'      => ['nullable', Rule::in(Project::SKILL_SET_OPTIONS)],
            'material'    => ['nullable', Rule::in(Project::MATERIAL_OPTIONS)],
            'narasi'      => 'required|string',
        ];
    }
}
