<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Facades\Schema;

class IndonesiaDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Skip if data already exists
        if (Province::count() > 0) {
            $this->command->info('Indonesia data already seeded, skipping...');
            return;
        }

        $this->command->info('Seeding Indonesia regions data...');

        // Disable foreign key constraints
        Schema::disableForeignKeyConstraints();

        // Call individual seeders from laravolt package
        $this->call([
            \Laravolt\Indonesia\Seeds\ProvincesSeeder::class,
            \Laravolt\Indonesia\Seeds\CitiesSeeder::class,
            \Laravolt\Indonesia\Seeds\DistrictsSeeder::class,
            \Laravolt\Indonesia\Seeds\VillagesSeeder::class,
        ]);

        // Re-enable foreign key constraints
        Schema::enableForeignKeyConstraints();

        $this->command->info('Indonesia data seeded successfully!');
    }
}
