<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyaluran_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyaluran_id')->constrained('penyaluran')->onDelete('cascade');
            $table->string('jenis_penerima'); // individu, keluarga, lembaga
            $table->foreignId('mustahik_id')->nullable()->constrained('mustahik')->onDelete('set null');
            $table->string('nama_penerima')->nullable();
            $table->decimal('jumlah_diterima', 15, 2);
            $table->enum('status_penerimaan', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamp('tanggal_diterima')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyaluran_detail');
    }
};
