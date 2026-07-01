<?php

namespace App\Http\Requests\Dosen;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopikInterestRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Sudah dijaga oleh middleware role:dosen di routes/web.php
        return true;
    }

    public function rules(): array
    {
        return [
            'periode_id' => 'required|exists:periode,periode_id',
            'nama_topik' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'requirement' => 'nullable|string',
            'limit_bimbingan' => 'required|integer|min:1',
        ];
    }
}
