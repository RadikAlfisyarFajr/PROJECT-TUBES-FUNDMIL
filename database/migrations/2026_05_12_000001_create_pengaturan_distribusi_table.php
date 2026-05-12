<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_distribusi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id')->constrained('instansi')->onDelete('cascade');
            $table->foreignId('program_penyaluran_id')->constrained('program_penyaluran')->onDelete('cascade');
            $table->string('kode_rencana')->unique();
            $table->string('tipe_penerima');
            $table->decimal('nominal_per_penerima', 15, 2);
            $table->unsignedInteger('jumlah_penerima');
            $table->decimal('total_alokasi', 15, 2);
            $table->decimal('saldo_awal', 15, 2);
            $table->decimal('estimasi_sisa_saldo', 15, 2);
            $table->json('sumber_dana');
            $table->json('penerima');
            $table->string('status')->default('siap');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['instansi_id', 'status']);
            $table->index(['program_penyaluran_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_distribusi');
    }
};
