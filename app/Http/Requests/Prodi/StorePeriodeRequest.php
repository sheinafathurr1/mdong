<?php

namespace App\Http\Requests\Prodi;

use Illuminate\Foundation\Http\FormRequest;

class StorePeriodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Sudah dijaga oleh middleware role:dosen + prodi di routes/web.php
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kode' => 'required|string|max:255|unique:periode,nama_kode',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }
}
