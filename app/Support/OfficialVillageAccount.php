<?php

namespace App\Support;

class OfficialVillageAccount
{
    public const TYPE = 'Akun Resmi Desa';

    public static function villages(): array
    {
        return [
            'Desa Cingcin',
            'Desa Soreang',
            'Desa Pamekaran',
            'Desa Sekarwangi',
            'Desa Parungserab',
            'Desa Karamatmulya',
            'Desa Sukapura',
            'Desa Sadu',
            'Desa Buninagara',
            'Desa Cahaya Maju',
        ];
    }
}
