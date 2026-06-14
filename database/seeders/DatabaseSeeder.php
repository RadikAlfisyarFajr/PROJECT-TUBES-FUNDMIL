<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'name' => 'Super Admin',
            'nama_instansi' => 'Super Admin',
            'username' => 'superadmin',
            'password' => Hash::make('SuperAdmin123'),
            'role' => User::ROLE_SUPER_ADMIN,
            'status' => 'active',
            'instansi_id' => null,
        ]);

        // Seed Indonesia regions data first
        $this->call([
            IndonesiaDataSeeder::class,
            InstansiSeeder::class,
            HargaBerasSeeder::class,
            NishabSeeder::class,
            ProfilInstansiSeeder::class,
            KategoriDanaSeeder::class,
            PemasukanSeeder::class,
            MustahikSeeder::class,
            ProgramPenyaluranSeeder::class,
            PengaturanDistribusiSeeder::class,
            PenyaluranSeeder::class,
            LaporanSeeder::class,
        ]);
    }
}
