<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            $table->string('tipe')->nullable()->after('nama');
            $table->string('email')->nullable()->after('kontak');
            $table->string('nomor_sk')->nullable()->after('email');
            $table->date('masa_berlaku')->nullable()->after('nomor_sk');
            $table->string('nama_pimpinan')->nullable()->after('masa_berlaku');
            $table->string('tanda_tangan')->nullable()->after('logo');
        });
    }

    public function down(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            $table->dropColumn([
                'tipe',
                'email',
                'nomor_sk',
                'masa_berlaku',
                'nama_pimpinan',
                'tanda_tangan',
            ]);
        });
    }
};
