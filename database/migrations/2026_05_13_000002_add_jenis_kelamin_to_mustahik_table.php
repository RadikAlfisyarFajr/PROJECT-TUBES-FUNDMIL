<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mustahik', function (Blueprint $table) {
            if (! Schema::hasColumn('mustahik', 'jenis_kelamin')) {
                $table->string('jenis_kelamin')->nullable()->after('nik');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mustahik', function (Blueprint $table) {
            if (Schema::hasColumn('mustahik', 'jenis_kelamin')) {
                $table->dropColumn('jenis_kelamin');
            }
        });
    }
};
