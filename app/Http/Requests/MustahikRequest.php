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
            'jenis_kelamin' => ['nullable', Rule::in(['laki_laki', 'perempuan'])],
            'alamat' => ['required', 'string'],
            'kategori' => ['required', Rule::in(array_keys(Mustahik::KATEGORI))],
            'kontak' => ['nullable', 'string', 'max:30'],
            'keterangan' => ['nullable', 'string'],
            'foto_ktp' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'foto_kk' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', Rule::in(['aktif', 'tidak_aktif'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_lengkap' => 'nama lengkap',
            'jenis_kelamin' => 'jenis kelamin',
            'kategori' => 'kategori mustahik',
            'kontak' => 'nomor telepon',
            'foto_ktp' => 'foto KTP',
            'foto_kk' => 'foto KK',
        ];
    }
}
