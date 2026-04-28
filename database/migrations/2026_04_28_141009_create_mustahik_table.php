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
        Schema::create('mustahik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id')->constrained('instansi')->onDelete('cascade');
            $table->index('instansi_id');
            $table->string('nama');
            $table->string('nik', 16)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kategori_asnaf'); // fakir, miskin, amil, muallaf, riqab, gharimin, fisabilillah, ibnu sabil
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mustahik');
    }
};
