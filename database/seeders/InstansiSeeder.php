<?php

namespace Database\Seeders;

use App\Models\Instansi;
use App\Models\User;
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
    }
}
