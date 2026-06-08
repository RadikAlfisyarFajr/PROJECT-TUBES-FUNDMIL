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
        Schema::create('transaksi_zakat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id')->constrained('instansi')->onDelete('cascade');
            $table->index(['instansi_id', 'tanggal']);
            $table->foreignId('kategori_id')->constrained('kategori_dana')->onDelete('cascade');
            $table->string('nomor_kuitansi')->unique();
            $table->string('nama_muzakki');
            $table->string('jenis'); // zakat, infak, sedekah
            $table->string('sub_jenis')->nullable(); // beras, uang
            $table->decimal('jumlah', 15, 2);
            $table->decimal('harga_beras_snapshot', 10, 2)->nullable();
            $table->enum('jenis_pembayaran', ['tunai', 'non_tunai'])->default('tunai');
            $table->string('bukti_pembayaran')->nullable(); // path file
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_zakat');
    }
};
