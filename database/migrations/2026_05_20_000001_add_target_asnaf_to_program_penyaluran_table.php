<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_penyaluran', function (Blueprint $table) {
            if (! Schema::hasColumn('program_penyaluran', 'target_asnaf')) {
                $table->json('target_asnaf')->nullable()->after('target_mustahik');
            }
        });
    }

    public function down(): void
    {
        Schema::table('program_penyaluran', function (Blueprint $table) {
            if (Schema::hasColumn('program_penyaluran', 'target_asnaf')) {
                $table->dropColumn('target_asnaf');
            }
        });
    }
};
