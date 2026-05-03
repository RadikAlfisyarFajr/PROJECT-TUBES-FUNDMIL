<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mustahik', function (Blueprint $table) {
            $table->string('no_kk', 16)->nullable()->after('nik');
            $table->string('tempat_lahir')->nullable()->after('no_kk');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('tanggal_lahir');
            $table->string('desa_kelurahan')->nullable()->after('jenis_kelamin');
            $table->string('rw', 3)->nullable()->after('desa_kelurahan');
            $table->string('rt', 3)->nullable()->after('rw');
            $table->string('foto_ktp')->nullable()->after('tanggal_verifikasi');
            $table->string('foto_kk')->nullable()->after('foto_ktp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mustahik', function (Blueprint $table) {
            $table->dropColumn([
                'no_kk',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'desa_kelurahan',
                'rw',
                'rt',
                'foto_ktp',
                'foto_kk',
            ]);
        });
    }
};
