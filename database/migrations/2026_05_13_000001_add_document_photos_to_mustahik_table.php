<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mustahik', function (Blueprint $table) {
            if (! Schema::hasColumn('mustahik', 'foto_ktp')) {
                $table->string('foto_ktp')->nullable()->after('keterangan');
            }

            if (! Schema::hasColumn('mustahik', 'foto_kk')) {
                $table->string('foto_kk')->nullable()->after('foto_ktp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mustahik', function (Blueprint $table) {
            if (Schema::hasColumn('mustahik', 'foto_kk')) {
                $table->dropColumn('foto_kk');
            }

            if (Schema::hasColumn('mustahik', 'foto_ktp')) {
                $table->dropColumn('foto_ktp');
            }
        });
    }
};
