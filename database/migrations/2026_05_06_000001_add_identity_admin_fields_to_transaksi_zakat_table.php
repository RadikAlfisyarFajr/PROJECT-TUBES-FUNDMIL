<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_zakat', function (Blueprint $table) {
            try {
                $table->dropUnique('transaksi_zakat_nomor_kuitansi_unique');
            } catch (\Throwable) {
                // The index may already have been removed in some local databases.
            }

            if (! Schema::hasColumn('transaksi_zakat', 'admin_id')) {
                $table->foreignId('admin_id')
                    ->nullable()
                    ->after('instansi_id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('transaksi_zakat', 'nomor_wa')) {
                $table->string('nomor_wa')->nullable()->after('nama_muzakki');
            }

            if (! Schema::hasColumn('transaksi_zakat', 'desa')) {
                $table->string('desa')->nullable()->after('nomor_wa');
            }

            $table->index(['instansi_id', 'nomor_kuitansi'], 'transaksi_zakat_instansi_kuitansi_index');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_zakat', function (Blueprint $table) {
            try {
                $table->dropIndex('transaksi_zakat_instansi_kuitansi_index');
            } catch (\Throwable) {
                // Ignore if the index is not present.
            }

            if (Schema::hasColumn('transaksi_zakat', 'admin_id')) {
                $table->dropConstrainedForeignId('admin_id');
            }

            if (Schema::hasColumn('transaksi_zakat', 'desa')) {
                $table->dropColumn('desa');
            }

            if (Schema::hasColumn('transaksi_zakat', 'nomor_wa')) {
                $table->dropColumn('nomor_wa');
            }

            try {
                $table->unique('nomor_kuitansi', 'transaksi_zakat_nomor_kuitansi_unique');
            } catch (\Throwable) {
                // Ignore if duplicate historical kuitansi prevent recreating the old constraint.
            }
        });
    }
};
