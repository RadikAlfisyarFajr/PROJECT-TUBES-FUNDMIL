<?php

namespace App\Http\Requests;

use App\Models\Mustahik;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MustahikRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdminInstansi() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => ['nullable', 'digits:16'],
            'alamat' => ['required', 'string'],
            'kategori' => ['required', Rule::in(array_keys(Mustahik::KATEGORI))],
            'kontak' => ['nullable', 'string', 'max:30'],
            'keterangan' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['aktif', 'tidak_aktif'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_lengkap' => 'nama lengkap',
            'kategori' => 'kategori mustahik',
            'kontak' => 'nomor telepon',
        ];
    }
}
