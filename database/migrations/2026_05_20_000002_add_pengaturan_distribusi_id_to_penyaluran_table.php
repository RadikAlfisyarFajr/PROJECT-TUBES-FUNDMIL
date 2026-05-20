<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penyaluran', function (Blueprint $table) {
            $table->foreignId('pengaturan_distribusi_id')
                ->nullable()
                ->after('program_id')
                ->constrained('pengaturan_distribusi')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('penyaluran', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pengaturan_distribusi_id');
        });
    }
};
