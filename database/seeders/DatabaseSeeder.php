<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\WilayahSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            StandarKmsSeeder::class,
            StandarKmsV2Seeder::class,
            JenisImunisasiSeeder::class,
            AnakVitaminSeeder::class,
            AnakPerempuanSeeder::class,
            SampleDataSeeder::class,
            WilayahSeeder::class,
        ]);
    }
}
