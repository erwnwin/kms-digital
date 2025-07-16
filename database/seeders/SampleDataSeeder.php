<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('jadwal_imunisasi')->insert([
            [
                'type' => 'regular',
                'title' => 'Imunisasi Rutin',
                'description' => 'Imunisasi harian di puskesmas',
                'start_time' => '08:00:00',
                'end_time' => '12:00:00',
                'location' => 'Ruang Imunisasi',
                'day' => 'Senin',
                'category' => 'wajib',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'regular',
                'title' => 'Imunisasi Rutin',
                'description' => 'Imunisasi harian di puskesmas',
                'start_time' => '08:00:00',
                'end_time' => '12:00:00',
                'location' => 'Ruang Imunisasi',
                'day' => 'Selasa',
                'category' => 'wajib',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data lainnya...
        ]);

        DB::table('jadwal_imunisasi')->insert([
            [
                'type' => 'special',
                'title' => 'Imunisasi Campak',
                'description' => 'Imunisasi campak untuk anak usia 9 bulan',
                'start_date' => '2023-06-15',
                'end_date' => '2023-06-15',
                'start_time' => '08:00:00',
                'end_time' => '14:00:00',
                'location' => 'Aula Puskesmas',
                'day' => null,
                'category' => 'wajib',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data lainnya...
        ]);

        DB::table('faqs')->insert([
            [
                'question' => 'Apakah imunisasi di puskesmas gratis?',
                'answer' => 'Ya, semua jenis imunisasi dasar yang termasuk dalam program pemerintah disediakan secara gratis di puskesmas. Namun untuk beberapa imunisasi tambahan mungkin ada biaya tertentu.',
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data lainnya...
        ]);

        // Kontak Info
        DB::table('contact_info')->insert([
            [
                'address' => 'Jl. Kesehatan No. 123, Kota Sehat',
                'phone' => '(021) 12345678',
                'email' => 'imunisasi@puskesmassehat.id',
                'opening_hours' => "Senin-Jumat: 07.30-15.00\nSabtu: 08.00-12.00",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
