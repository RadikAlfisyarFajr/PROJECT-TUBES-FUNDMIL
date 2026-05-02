<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const UNIQUE_INDEX = 'users_instansi_id_unique';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->assertUsersAreReadyForConstraints();

        DB::table('users')
            ->where('role', 'petugas')
            ->update(['role' => 'admin_instansi']);

        $this->modifyRoleEnum("ENUM('super_admin', 'admin_instansi') NOT NULL");

        if (! $this->indexExists(self::UNIQUE_INDEX)) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('instansi_id', self::UNIQUE_INDEX);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($this->indexExists(self::UNIQUE_INDEX)) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(self::UNIQUE_INDEX);
            });
        }

        $this->modifyRoleEnum("ENUM('super_admin', 'admin_instansi', 'petugas') NOT NULL DEFAULT 'petugas'");
    }

    private function assertUsersAreReadyForConstraints(): void
    {
        $adminWithoutInstansi = DB::table('users')
            ->whereIn('role', ['admin_instansi', 'petugas'])
            ->whereNull('instansi_id')
            ->orderBy('id')
            ->pluck('id');

        if ($adminWithoutInstansi->isNotEmpty()) {
            throw new RuntimeException(
                'Migration dihentikan: user admin_instansi/petugas wajib memiliki instansi_id sebelum role petugas diubah. ' .
                'Isi instansi_id untuk user ID berikut sebelum migrate: ' .
                $adminWithoutInstansi->implode(', ')
            );
        }

        $superAdminWithInstansi = DB::table('users')
            ->where('role', 'super_admin')
            ->whereNotNull('instansi_id')
            ->orderBy('id')
            ->pluck('id');

        if ($superAdminWithInstansi->isNotEmpty()) {
            throw new RuntimeException(
                'Migration dihentikan: user super_admin sebaiknya tidak terikat ke instansi. ' .
                'Kosongkan instansi_id untuk user ID berikut sebelum migrate: ' .
                $superAdminWithInstansi->implode(', ')
            );
        }

        $duplicates = DB::table('users')
            ->select('instansi_id', DB::raw('COUNT(*) as total'), DB::raw('GROUP_CONCAT(id ORDER BY id) as user_ids'))
            ->whereIn('role', ['admin_instansi', 'petugas'])
            ->whereNotNull('instansi_id')
            ->groupBy('instansi_id')
            ->havingRaw('COUNT(*) > 1')
            ->orderBy('instansi_id')
            ->get();

        if ($duplicates->isNotEmpty()) {
            throw new RuntimeException(
                'Migration dihentikan: ditemukan lebih dari 1 admin_instansi pada instansi yang sama. ' .
                'Sisakan 1 admin per instansi terlebih dahulu. Duplikat: ' .
                $this->formatDuplicateMessage($duplicates)
            );
        }
    }

    private function formatDuplicateMessage(Collection $duplicates): string
    {
        return $duplicates
            ->map(fn ($row) => "instansi_id {$row->instansi_id} memiliki user ID {$row->user_ids}")
            ->implode('; ');
    }

    private function modifyRoleEnum(string $definition): void
    {
        DB::statement("ALTER TABLE users MODIFY role {$definition}");
    }

    private function indexExists(string $indexName): bool
    {
        return DB::table('information_schema.statistics')
            ->whereRaw('table_schema = DATABASE()')
            ->where('table_name', 'users')
            ->where('index_name', $indexName)
            ->exists();
    }
};
