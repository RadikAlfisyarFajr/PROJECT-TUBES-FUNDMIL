<?php

namespace App\Support;

class OfficialVillageAccount
{
    public const TYPE = 'Akun Resmi Desa';

    public static function villages(): array
    {
        return [
            'Cingcin',
            'Soreang',
            'Pamekaran',
            'Sekarwangi',
            'Parungserab',
            'Karamatmulya',
            'Sukapura',
            'Sadu',
            'Buninagara',
            'Cahaya Maju',
        ];
    }

    public static function normalizeVillageName(?string $value): string
    {
        $normalized = strtolower(trim((string) $value));
        $normalized = (string) preg_replace('/\s+/', ' ', $normalized);
        $normalized = (string) preg_replace('/^(desa|kelurahan)\s+/i', '', $normalized);

        foreach (self::villages() as $village) {
            if ($normalized === strtolower($village)) {
                return $village;
            }
        }

        return ucwords($normalized);
    }
}
