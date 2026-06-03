<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE transaksi_zakat MODIFY jenis_pembayaran ENUM('tunai', 'transfer', 'qris', 'non_tunai') NOT NULL DEFAULT 'tunai'");

        DB::table('transaksi_zakat')
            ->whereIn('jenis_pembayaran', ['transfer', 'qris'])
            ->update(['jenis_pembayaran' => 'non_tunai']);

        DB::statement("ALTER TABLE transaksi_zakat MODIFY jenis_pembayaran ENUM('tunai', 'non_tunai') NOT NULL DEFAULT 'tunai'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transaksi_zakat MODIFY jenis_pembayaran ENUM('tunai', 'transfer', 'qris', 'non_tunai') NOT NULL DEFAULT 'tunai'");

        DB::table('transaksi_zakat')
            ->where('jenis_pembayaran', 'non_tunai')
            ->update(['jenis_pembayaran' => 'transfer']);

        DB::statement("ALTER TABLE transaksi_zakat MODIFY jenis_pembayaran ENUM('tunai', 'transfer', 'qris') NOT NULL DEFAULT 'tunai'");
    }
};
