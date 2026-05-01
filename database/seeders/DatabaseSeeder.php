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
        User::factory()->create([
            'name' => 'Super Admin',
            'nama_instansi' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'username' => 'superadmin',
            'password' => Hash::make('SuperAdmin123'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);
    }
}
