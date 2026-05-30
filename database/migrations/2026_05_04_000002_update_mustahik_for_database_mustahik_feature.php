<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mustahik', function (Blueprint $table) {
            if (! Schema::hasColumn('mustahik', 'kontak')) {
                $table->string('kontak')->nullable()->after('kategori_asnaf');
            }

            if (! Schema::hasColumn('mustahik', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('kontak');
            }
        });

        DB::table('mustahik')->where('kategori_asnaf', 'gharimin')->update(['kategori_asnaf' => 'gharim']);
        DB::table('mustahik')->where('kategori_asnaf', 'ibnu sabil')->update(['kategori_asnaf' => 'ibnu_sabil']);
        DB::table('mustahik')->whereIn('status', ['pending', 'verified'])->update(['status' => 'aktif']);
        DB::table('mustahik')->where('status', 'rejected')->update(['status' => 'tidak_aktif']);

        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE mustahik MODIFY status ENUM('aktif', 'tidak_aktif') NOT NULL DEFAULT 'aktif'");
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE mustahik MODIFY status ENUM('pending', 'verified', 'rejected', 'aktif', 'tidak_aktif') NOT NULL DEFAULT 'pending'");
        }

        DB::table('mustahik')->where('status', 'aktif')->update(['status' => 'verified']);
        DB::table('mustahik')->where('status', 'tidak_aktif')->update(['status' => 'rejected']);

        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE mustahik MODIFY status ENUM('pending', 'verified', 'rejected') NOT NULL DEFAULT 'pending'");
        }

        Schema::table('mustahik', function (Blueprint $table) {
            if (Schema::hasColumn('mustahik', 'keterangan')) {
                $table->dropColumn('keterangan');
            }

            if (Schema::hasColumn('mustahik', 'kontak')) {
                $table->dropColumn('kontak');
            }
        });
    }
};
