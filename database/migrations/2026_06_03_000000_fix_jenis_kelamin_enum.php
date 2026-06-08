<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update data existing jika ada yang masih old format
        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::table('mustahik')->where('jenis_kelamin', 'Laki-laki')->update(['jenis_kelamin' => 'laki_laki']);
            DB::table('mustahik')->where('jenis_kelamin', 'Perempuan')->update(['jenis_kelamin' => 'perempuan']);
        }
        
        // Ubah ENUM jenis_kelamin ke nilai yang sesuai dengan form
        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE mustahik MODIFY jenis_kelamin ENUM('laki_laki', 'perempuan') NULL");
        }
    }

    public function down(): void
    {
        // Kembalikan ke ENUM original
        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE mustahik MODIFY jenis_kelamin ENUM('Laki-laki', 'Perempuan') NULL");
        }
    }
};
