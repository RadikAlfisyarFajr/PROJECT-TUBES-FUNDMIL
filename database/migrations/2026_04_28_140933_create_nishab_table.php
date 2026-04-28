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
        Schema::create('nishab', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_zakat'); // zakat fitrah, zakat mal
            $table->decimal('nishab_kg', 10, 2)->nullable(); // dalam kg untuk fitrah
            $table->decimal('nishab_rupiah', 15, 2)->nullable(); // dalam rupiah untuk mal
            $table->decimal('tarif_fitrah_kg', 10, 2)->nullable(); // harga beras untuk fitrah
            $table->date('tanggal_berlaku');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nishab');
    }
};
