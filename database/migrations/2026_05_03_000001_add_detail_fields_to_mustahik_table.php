<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('mustahik', 'no_kk')) {
            Schema::table('mustahik', function (Blueprint $table) {
                $table->string('no_kk', 16)->nullable()->after('nik');
            });
        }

        if (! Schema::hasColumn('mustahik', 'tempat_lahir')) {
            Schema::table('mustahik', function (Blueprint $table) {
                $table->string('tempat_lahir')->nullable()->after('no_kk');
            });
        }

        if (! Schema::hasColumn('mustahik', 'tanggal_lahir')) {
            Schema::table('mustahik', function (Blueprint $table) {
                $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            });
        }

        if (! Schema::hasColumn('mustahik', 'jenis_kelamin')) {
            Schema::table('mustahik', function (Blueprint $table) {
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('tanggal_lahir');
            });
        }

        if (! Schema::hasColumn('mustahik', 'desa_kelurahan')) {
            Schema::table('mustahik', function (Blueprint $table) {
                $table->string('desa_kelurahan')->nullable()->after('jenis_kelamin');
            });
        }

        if (! Schema::hasColumn('mustahik', 'rw')) {
            Schema::table('mustahik', function (Blueprint $table) {
                $table->string('rw', 3)->nullable()->after('desa_kelurahan');
            });
        }

        if (! Schema::hasColumn('mustahik', 'rt')) {
            Schema::table('mustahik', function (Blueprint $table) {
                $table->string('rt', 3)->nullable()->after('rw');
            });
        }

        if (! Schema::hasColumn('mustahik', 'foto_ktp')) {
            Schema::table('mustahik', function (Blueprint $table) {
                $table->string('foto_ktp')->nullable()->after('tanggal_verifikasi');
            });
        }

        if (! Schema::hasColumn('mustahik', 'foto_kk')) {
            Schema::table('mustahik', function (Blueprint $table) {
                $table->string('foto_kk')->nullable()->after('foto_ktp');
            });
        }

        DB::statement("ALTER TABLE mustahik MODIFY status VARCHAR(32) NOT NULL DEFAULT 'pending'");
        DB::table('mustahik')->where('status', 'aktif')->update(['status' => 'verified']);
        DB::table('mustahik')->where('status', 'tidak_aktif')->update(['status' => 'rejected']);
        DB::statement("ALTER TABLE mustahik MODIFY status ENUM('pending', 'verified', 'rejected') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE mustahik MODIFY status VARCHAR(32) NOT NULL DEFAULT 'aktif'");
        DB::table('mustahik')->where('status', 'verified')->update(['status' => 'aktif']);
        DB::table('mustahik')->whereIn('status', ['pending', 'rejected'])->update(['status' => 'tidak_aktif']);
        DB::statement("ALTER TABLE mustahik MODIFY status ENUM('aktif', 'tidak_aktif') NOT NULL DEFAULT 'aktif'");

        Schema::table('mustahik', function (Blueprint $table) {
            $columns = [
                'no_kk',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'desa_kelurahan',
                'rw',
                'rt',
                'foto_ktp',
                'foto_kk',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('mustahik', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
