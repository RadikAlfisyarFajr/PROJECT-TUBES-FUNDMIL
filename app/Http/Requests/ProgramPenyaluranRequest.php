<?php

namespace App\Http\Requests;

use App\Models\Mustahik;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgramPenyaluranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdminInstansi() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_program' => ['required', 'string', 'max:255'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'target_asnaf' => ['required', 'array', 'min:1'],
            'target_asnaf.*' => [
                'string',
                Rule::in(array_keys(Mustahik::KATEGORI)),
            ],
            'deskripsi' => ['nullable', 'string'],
            'total_dana' => ['nullable', 'numeric', 'min:0'],
            'target_mustahik' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['aktif', 'selesai'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_program' => 'nama program',
            'tanggal_mulai' => 'tanggal mulai',
            'tanggal_selesai' => 'tanggal selesai',
            'target_asnaf' => 'target asnaf',
            'total_dana' => 'total dana',
            'target_mustahik' => 'jumlah mustahik',
        ];
    }
}
