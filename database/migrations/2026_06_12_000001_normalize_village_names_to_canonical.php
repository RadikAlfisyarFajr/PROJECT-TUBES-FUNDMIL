<?php

use App\Support\OfficialVillageAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->assertNoDuplicateOfficialAccounts();

        foreach ($this->villageColumns() as $table => $columns) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            foreach ($columns as $column) {
                if (Schema::hasColumn($table, $column)) {
                    $this->normalizeColumn($table, $column);
                }
            }
        }
    }

    public function down(): void
    {
        //
    }

    private function normalizeColumn(string $table, string $column): void
    {
        foreach (OfficialVillageAccount::villages() as $village) {
            $variants = [
                $village,
                'Desa '.$village,
                'Kelurahan '.$village,
            ];

            DB::table($table)
                ->where(function ($query) use ($column, $variants) {
                    foreach ($variants as $variant) {
                        $query->orWhereRaw("LOWER(TRIM({$column})) = ?", [strtolower($variant)]);
                    }
                })
                ->update([$column => $village]);
        }
    }

    private function assertNoDuplicateOfficialAccounts(): void
    {
        if (! Schema::hasTable('instansi')) {
            return;
        }

        $duplicates = DB::table('instansi')
            ->where('tipe', OfficialVillageAccount::TYPE)
            ->whereIn('status', ['pending', 'aktif'])
            ->whereNotNull('kelurahan')
            ->get(['id', 'kelurahan'])
            ->groupBy(fn ($row) => OfficialVillageAccount::normalizeVillageName($row->kelurahan))
            ->filter(fn ($rows, $desa) => $desa !== '' && $rows->count() > 1);

        if ($duplicates->isEmpty()) {
            return;
        }

        $message = $duplicates
            ->map(fn ($rows, $desa) => "{$desa}: ID ".$rows->pluck('id')->implode(', '))
            ->implode('; ');

        throw new RuntimeException(
            'Migration dihentikan: ditemukan lebih dari satu akun resmi aktif/pending pada desa yang sama. '.
            'Nonaktifkan duplikat terlebih dahulu. Duplikat: '.$message
        );
    }

    private function villageColumns(): array
    {
        return [
            'instansi' => ['kelurahan'],
            'users' => ['desa'],
            'transaksi_zakat' => ['desa'],
            'mustahik' => ['desa_kelurahan'],
        ];
    }
};
