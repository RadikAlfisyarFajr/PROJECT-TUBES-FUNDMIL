<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiZakat extends Model
{
    protected $table = 'transaksi_zakat';
    protected $fillable = [
        'instansi_id',
        'admin_id',
        'kategori_id',
        'nomor_kuitansi',
        'nama_muzakki',
        'nomor_wa',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'alamat_detail',
        'jenis',
        'sub_jenis',
        'jumlah',
        'harga_beras_snapshot',
        'jenis_pembayaran',
        'bukti_pembayaran',
        'keterangan',
        'tanggal'
    ];

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriDana::class, 'kategori_id');
    }
}
