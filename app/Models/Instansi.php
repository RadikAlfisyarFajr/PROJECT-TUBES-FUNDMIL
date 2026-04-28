<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instansi extends Model
{
    protected $table = 'instansi';
    protected $fillable = ['nama', 'kelurahan', 'alamat', 'status', 'kontak', 'logo', 'latitude', 'longitude'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function mustahik(): HasMany
    {
        return $this->hasMany(Mustahik::class);
    }
    public function transaksiZakat(): HasMany
    {
        return $this->hasMany(TransaksiZakat::class);
    }
    public function programPenyaluran(): HasMany
    {
        return $this->hasMany(ProgramPenyaluran::class);
    }
}
