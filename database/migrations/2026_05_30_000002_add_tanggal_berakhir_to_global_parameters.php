<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('harga_beras', function (Blueprint $table) {
            if (! Schema::hasColumn('harga_beras', 'tanggal_berakhir')) {
                $table->date('tanggal_berakhir')->nullable()->after('tanggal_berlaku');
            }
        });

        Schema::table('nishab', function (Blueprint $table) {
            if (! Schema::hasColumn('nishab', 'tanggal_berakhir')) {
                $table->date('tanggal_berakhir')->nullable()->after('tanggal_berlaku');
            }
        });
    }

    public function down(): void
    {
        Schema::table('harga_beras', function (Blueprint $table) {
            if (Schema::hasColumn('harga_beras', 'tanggal_berakhir')) {
                $table->dropColumn('tanggal_berakhir');
            }
        });

        Schema::table('nishab', function (Blueprint $table) {
            if (Schema::hasColumn('nishab', 'tanggal_berakhir')) {
                $table->dropColumn('tanggal_berakhir');
            }
        });
    }
};
