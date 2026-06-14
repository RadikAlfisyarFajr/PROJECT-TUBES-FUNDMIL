<?php

namespace Database\Seeders;

use App\Models\Mustahik;
use Illuminate\Database\Seeder;

class MustahikSeeder extends Seeder
{
    /**
     * Seed data awal fitur mustahik.
     */
    public function run(): void
    {
        // Desa-desa di Kecamatan Soreang
        $desaSoreang = [
            'SOREANG',
            'SADU',
            'PANYIRAPAN',
            'SUKAJADI',
            'PAMEKARAN',
            'KARAMATMULYA',
            'SUKANAGARA',
            'CINGCIN',
            'PARUNGSERAB',
            'SEKARWANGI'
        ];

        // Kategori asnaf
        $kategoriAsnaf = ['fakir', 'miskin', 'amil', 'riqab', 'gharim', 'fisabilillah', 'ibnu_sabil'];
        $jenisKelamin = ['laki_laki', 'perempuan'];

        // Buat 30 mustahik di desa-desa Soreang untuk Instansi RadikAmanah (ID: 1)
        $firstNames = ['Ahmad', 'Muhammad', 'Fatimah', 'Aisyah', 'Hassan', 'Nur', 'Rahma', 'Siti', 'Ali', 'Zahra'];
        $lastNames = ['Ridho', 'Kurniawan', 'Rahman', 'Ibrahim', 'Hidayat', 'Suryanto', 'Wijaya', 'Pratama', 'Santoso', 'Setiawan'];

        for ($i = 1; $i <= 30; $i++) {
            $desa = $desaSoreang[($i - 1) % count($desaSoreang)];
            $firstName = $firstNames[($i - 1) % count($firstNames)];
            $lastName = $lastNames[($i - 1) % count($lastNames)];
            $nama = $firstName . ' ' . $lastName . ' ' . $i;
            $nik = '3204' . str_pad($i, 7, '0', STR_PAD_LEFT);
            $noKK = '3204' . str_pad($i + 1000, 8, '0', STR_PAD_LEFT);

            Mustahik::create([
                'instansi_id' => 1,
                'nama' => $nama,
                'nik' => $nik,
                'no_kk' => $noKK,
                'tempat_lahir' => $desa,
                'tanggal_lahir' => now()->subYears(rand(25, 75))->format('Y-m-d'),
                'jenis_kelamin' => $jenisKelamin[$i % 2],
                'desa_kelurahan' => $desa,
                'rw' => str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT),
                'rt' => str_pad(rand(1, 30), 2, '0', STR_PAD_LEFT),
                'alamat' => 'Jalan Utama No. ' . $i . ', ' . $desa,
                'kategori_asnaf' => $kategoriAsnaf[$i % count($kategoriAsnaf)],
                'kontak' => '628' . str_pad(rand(1000000, 9999999), 8, '0', STR_PAD_LEFT),
                'keterangan' => 'Data mustahik dari seeder - ' . $desa,
                'status' => 'aktif',
                'tanggal_verifikasi' => now(),
                'latitude' => -7.041 + (rand(-1000, 1000) / 10000),
                'longitude' => 107.519 + (rand(-1000, 1000) / 10000),
            ]);
        }
    }
}
