<?php

namespace App\Http\Requests;

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
            'kategori_dana_ids' => ['required', 'array', 'min:1'],
            'kategori_dana_ids.*' => [
                'integer',
                Rule::exists('kategori_dana', 'id')->where('instansi_id', $this->user()?->instansi_id),
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
            'kategori_dana_ids' => 'jenis dana',
            'total_dana' => 'total dana',
            'target_mustahik' => 'jumlah mustahik',
        ];
    }
}
