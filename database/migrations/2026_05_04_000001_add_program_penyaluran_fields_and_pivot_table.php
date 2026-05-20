<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_penyaluran', function (Blueprint $table) {
            if (! Schema::hasColumn('program_penyaluran', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('tanggal_selesai');
            }

            if (! Schema::hasColumn('program_penyaluran', 'total_dana')) {
                $table->decimal('total_dana', 15, 2)->default(0)->after('target_dana');
            }

            if (! Schema::hasColumn('program_penyaluran', 'target_mustahik')) {
                $table->unsignedInteger('target_mustahik')->default(0)->after('total_dana');
            }
        });

        if (! Schema::hasTable('program_penyaluran_dana')) {
            Schema::create('program_penyaluran_dana', function (Blueprint $table) {
                $table->id();
                $table->foreignId('program_penyaluran_id')
                    ->constrained('program_penyaluran')
                    ->cascadeOnDelete();
                $table->foreignId('kategori_dana_id')
                    ->constrained('kategori_dana')
                    ->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['program_penyaluran_id', 'kategori_dana_id'], 'program_penyaluran_dana_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('program_penyaluran_dana');

        Schema::table('program_penyaluran', function (Blueprint $table) {
            foreach (['target_mustahik', 'total_dana', 'deskripsi'] as $column) {
                if (Schema::hasColumn('program_penyaluran', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
