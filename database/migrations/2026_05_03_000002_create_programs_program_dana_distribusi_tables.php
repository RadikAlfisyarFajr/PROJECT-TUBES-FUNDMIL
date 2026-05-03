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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id')->constrained('instansi')->onDelete('cascade');
            $table->string('nama_program');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('deskripsi')->nullable();
            $table->decimal('total_dana', 15, 2)->default(0);
            $table->unsignedInteger('target_mustahik')->default(0);
            $table->enum('status', ['draft', 'aktif', 'selesai'])->default('aktif');
            $table->timestamps();
        });

        Schema::create('program_dana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('kategori_dana_id')->constrained('kategori_dana')->onDelete('cascade');
            $table->decimal('alokasi_dana', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('distribusi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('mustahik_id')->nullable()->constrained('mustahik')->nullOnDelete();
            $table->decimal('jumlah_dana', 15, 2)->default(0);
            $table->enum('status', ['pending', 'tersalurkan', 'batal'])->default('pending');
            $table->date('tanggal_distribusi')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi');
        Schema::dropIfExists('program_dana');
        Schema::dropIfExists('programs');
    }
};
