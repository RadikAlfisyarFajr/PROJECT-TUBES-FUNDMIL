<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilInstansiNotification extends Model
{
    protected $fillable = [
        'instansi_id',
        'title',
        'message',
        'type',
        'read_at',
    ];

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }
}
