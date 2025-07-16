<?php

namespace Database\Seeders;

use App\Models\Anak;
use App\Models\User;
use App\Models\AnakVitamin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnakVitaminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $anak = Anak::first();
        $petugas = User::where('role', 'kader')->first();

        if ($anak && $petugas) {
            // Vitamin A
            AnakVitamin::create([
                'anak_id' => $anak->id,
                'jenis' => 'Vitamin A',
                'tanggal' => now()->subMonths(2),
                'dosis' => 'Kapsul Biru (100.000 IU)',
                'keterangan' => 'Pemberian pertama',
                'petugas_id' => $petugas->id
            ]);

            // Obat Cacing
            AnakVitamin::create([
                'anak_id' => $anak->id,
                'jenis' => 'Obat Cacing',
                'tanggal' => now()->subMonths(3),
                'dosis' => '400mg',
                'keterangan' => 'Pemberian rutin 6 bulan sekali',
                'petugas_id' => $petugas->id
            ]);

            // Vitamin A kedua
            AnakVitamin::create([
                'anak_id' => $anak->id,
                'jenis' => 'Vitamin A',
                'tanggal' => now()->subMonths(6),
                'dosis' => 'Kapsul Merah (200.000 IU)',
                'keterangan' => 'Pemberian kedua',
                'petugas_id' => $petugas->id
            ]);
        }
    }
}
