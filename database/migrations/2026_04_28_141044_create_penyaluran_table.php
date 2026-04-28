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
        Schema::create('penyaluran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id')->constrained('instansi')->onDelete('cascade');
            $table->index(['instansi_id', 'tanggal_penyaluran']);
            $table->foreignId('program_id')->constrained('program_penyaluran')->onDelete('cascade');
            $table->date('tanggal_penyaluran');
            $table->enum('status', ['draft', 'selesai', 'dibatalkan'])->default('draft');
            $table->text('keterangan')->nullable();
            $table->string('bukti_foto')->nullable(); // path file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyaluran');
    }
};
