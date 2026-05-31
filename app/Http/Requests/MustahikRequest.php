<?php

namespace App\Http\Requests;

use App\Models\Mustahik;
use App\Support\OfficialVillageAccount;
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
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'desa_kelurahan' => ['required', Rule::in($this->desaOptions())],
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
            'jenis_kelamin' => 'jenis kelamin',
            'desa_kelurahan' => 'desa/kelurahan',
            'kategori' => 'kategori mustahik',
            'kontak' => 'nomor telepon',
        ];
    }

    private function desaOptions(): array
    {
        return OfficialVillageAccount::villages();
    }
}
