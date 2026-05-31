<?php

namespace Database\Seeders;

use App\Models\Instansi;
use App\Models\User;
use App\Support\OfficialVillageAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstansiSeeder extends Seeder
{
    /**
     * Seed data awal master instansi.
     */
    public function run(): void
    {
        $instansi = Instansi::updateOrCreate([
            'email' => 'radikalfisyar7867@gmail.com',
        ], [
            'nama' => 'RadikAmanah',
            'tipe' => 'Masjid',
            'kelurahan' => 'RadikAmanah',
            'alamat' => 'RadikAmanah',
            'status' => 'aktif',
        ]);

        User::updateOrCreate([
            'email' => 'radikalfisyar7867@gmail.com',
        ], [
            'name' => 'RadikAmanah',
            'nama_instansi' => 'RadikAmanah',
            'username' => 'radikamanah',
            'password' => Hash::make('12345678'),
            'role' => User::ROLE_ADMIN_INSTANSI,
            'status' => 'active',
            'instansi_id' => $instansi->id,
        ]);

        $desaInstansi = Instansi::updateOrCreate([
            'email' => 'kepaladesa@example.com',
        ], [
            'nama' => 'Pemerintah Desa Cingcin',
            'tipe' => OfficialVillageAccount::TYPE,
            'kelurahan' => OfficialVillageAccount::villages()[0],
            'alamat' => 'Kantor Desa Cingcin',
            'status' => 'aktif',
            'nama_pimpinan' => 'Kepala Desa Cingcin',
        ]);

        User::updateOrCreate([
            'email' => 'kepaladesa@example.com',
        ], [
            'name' => 'Kepala Desa Cingcin',
            'nama_instansi' => 'Pemerintah Desa Cingcin',
            'desa' => OfficialVillageAccount::villages()[0],
            'username' => 'kepaladesa',
            'password' => Hash::make('KepalaDesa123'),
            'role' => User::ROLE_ADMIN_KEPALA_DESA,
            'status' => 'active',
            'instansi_id' => $desaInstansi->id,
        ]);
    }
}
