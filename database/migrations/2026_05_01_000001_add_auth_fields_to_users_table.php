<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'nama_instansi')) {
                $table->string('nama_instansi')->nullable()->after('name');
            }
            if (! Schema::hasColumn('users', 'desa')) {
                $table->string('desa')->nullable()->after('nama_instansi');
            }
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('email');
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['pending', 'active', 'blocked'])->default('pending')->after('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('users', 'username')) {
                $table->dropUnique(['username']);
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'desa')) {
                $table->dropColumn('desa');
            }
            if (Schema::hasColumn('users', 'nama_instansi')) {
                $table->dropColumn('nama_instansi');
            }
        });
    }
};
