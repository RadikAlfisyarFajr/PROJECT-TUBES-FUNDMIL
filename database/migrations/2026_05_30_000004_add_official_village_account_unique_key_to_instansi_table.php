<?php

use App\Support\OfficialVillageAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const COLUMN = 'official_village_key';
    private const INDEX = 'instansi_official_village_key_unique';

    public function up(): void
    {
        if (! in_array(DB::connection()->getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        $this->assertNoDuplicateOfficialAccounts();

        if (! Schema::hasColumn('instansi', self::COLUMN)) {
            DB::statement(
                "ALTER TABLE instansi ADD " . self::COLUMN . " VARCHAR(255) " .
                "GENERATED ALWAYS AS (CASE " .
                "WHEN tipe = '" . addslashes(OfficialVillageAccount::TYPE) . "' AND status IN ('pending', 'aktif') " .
                "THEN kelurahan ELSE NULL END) STORED"
            );
        }

        if (! $this->indexExists(self::INDEX)) {
            DB::statement('ALTER TABLE instansi ADD UNIQUE INDEX ' . self::INDEX . ' (' . self::COLUMN . ')');
        }
    }

    public function down(): void
    {
        if (! in_array(DB::connection()->getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        if ($this->indexExists(self::INDEX)) {
            DB::statement('ALTER TABLE instansi DROP INDEX ' . self::INDEX);
        }

        if (Schema::hasColumn('instansi', self::COLUMN)) {
            DB::statement('ALTER TABLE instansi DROP COLUMN ' . self::COLUMN);
        }
    }

    private function assertNoDuplicateOfficialAccounts(): void
    {
        $duplicates = DB::table('instansi')
            ->select('kelurahan', DB::raw('COUNT(*) as total'), DB::raw('GROUP_CONCAT(id ORDER BY id) as instansi_ids'))
            ->where('tipe', OfficialVillageAccount::TYPE)
            ->whereIn('status', ['pending', 'aktif'])
            ->whereNotNull('kelurahan')
            ->groupBy('kelurahan')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        if ($duplicates->isEmpty()) {
            return;
        }

        $message = $duplicates
            ->map(fn ($row) => "{$row->kelurahan}: ID {$row->instansi_ids}")
            ->implode('; ');

        throw new RuntimeException(
            'Migration dihentikan: ditemukan lebih dari satu akun resmi aktif/pending pada desa yang sama. ' .
            'Nonaktifkan duplikat terlebih dahulu. Duplikat: ' . $message
        );
    }

    private function indexExists(string $indexName): bool
    {
        return DB::table('information_schema.statistics')
            ->whereRaw('table_schema = DATABASE()')
            ->where('table_name', 'instansi')
            ->where('index_name', $indexName)
            ->exists();
    }
};
