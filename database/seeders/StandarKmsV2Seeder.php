<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\StandarKms;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StandarKmsV2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Standar untuk anak 24-60 bulan (L dan P sama)
        $standarUmum = [
            // Format: umur_bulan, berat_minimal (-3SD), berat_minimal_2sd (-2SD), berat_minimal_1sd (-1SD), 
            // berat_ideal (median), berat_maksimal_1sd (+1SD), berat_maksimal_2sd (+2SD), berat_maksimal (+3SD),
            // tinggi_minimal, tinggi_ideal, lingkar_kepala_minimal, lingkar_kepala_ideal, kenaikan_minimal (200gr)
            [24, 9.7, 10.5, 11.3, 12.2, 13.2, 14.3, 15.5, 80.0, 85.0, 45.0, 48.0, 200],
            [25, 9.8, 10.6, 11.4, 12.3, 13.3, 14.4, 15.6, 80.5, 85.5, 45.1, 48.1, 200],
            [26, 9.9, 10.7, 11.5, 12.4, 13.4, 14.5, 15.8, 81.0, 86.0, 45.2, 48.2, 200],
            [27, 10.0, 10.8, 11.6, 12.5, 13.5, 14.7, 15.9, 81.5, 86.5, 45.3, 48.3, 200],
            [28, 10.1, 10.9, 11.7, 12.6, 13.7, 14.8, 16.1, 82.0, 87.0, 45.4, 48.4, 200],
            [29, 10.2, 11.0, 11.8, 12.8, 13.8, 15.0, 16.3, 82.5, 87.5, 45.5, 48.5, 200],
            [30, 10.3, 11.1, 11.9, 12.9, 14.0, 15.2, 16.5, 83.0, 88.0, 45.6, 48.6, 200],
            [31, 10.4, 11.2, 12.0, 13.0, 14.1, 15.3, 16.7, 83.5, 88.5, 45.7, 48.7, 200],
            [32, 10.5, 11.3, 12.1, 13.1, 14.2, 15.5, 16.9, 84.0, 89.0, 45.8, 48.8, 200],
            [33, 10.6, 11.4, 12.2, 13.2, 14.4, 15.6, 17.0, 84.5, 89.5, 45.9, 48.9, 200],
            [34, 10.7, 11.5, 12.3, 13.3, 14.5, 15.8, 17.2, 85.0, 90.0, 46.0, 49.0, 200],
            [35, 10.8, 11.6, 12.4, 13.4, 14.6, 15.9, 17.4, 85.5, 90.5, 46.1, 49.1, 200],
            [36, 10.9, 11.7, 12.5, 13.6, 14.8, 16.1, 17.6, 86.0, 91.0, 46.2, 49.2, 200],
            [37, 11.0, 11.8, 12.6, 13.7, 14.9, 16.2, 17.8, 86.5, 91.5, 46.3, 49.3, 200],
            [38, 11.1, 11.9, 12.7, 13.8, 15.0, 16.4, 18.0, 87.0, 92.0, 46.4, 49.4, 200],
            [39, 11.2, 12.0, 12.8, 13.9, 15.2, 16.5, 18.2, 87.5, 92.5, 46.5, 49.5, 200],
            [40, 11.3, 12.1, 12.9, 14.0, 15.3, 16.7, 18.4, 88.0, 93.0, 46.6, 49.6, 200],
            [41, 11.4, 12.2, 13.0, 14.1, 15.4, 16.8, 18.6, 88.5, 93.5, 46.7, 49.7, 200],
            [42, 11.5, 12.3, 13.1, 14.2, 15.5, 17.0, 18.8, 89.0, 94.0, 46.8, 49.8, 200],
            [43, 11.6, 12.4, 13.2, 14.4, 15.7, 17.1, 19.0, 89.5, 94.5, 46.9, 49.9, 200],
            [44, 11.7, 12.5, 13.3, 14.5, 15.8, 17.3, 19.2, 90.0, 95.0, 47.0, 50.0, 200],
            [45, 11.8, 12.6, 13.4, 14.6, 15.9, 17.4, 19.4, 90.5, 95.5, 47.1, 50.1, 200],
            [46, 11.9, 12.7, 13.5, 14.7, 16.1, 17.6, 19.6, 91.0, 96.0, 47.2, 50.2, 200],
            [47, 12.0, 12.8, 13.6, 14.8, 16.2, 17.7, 19.8, 91.5, 96.5, 47.3, 50.3, 200],
            [48, 12.1, 12.9, 13.7, 14.9, 16.3, 17.9, 20.0, 92.0, 97.0, 47.4, 50.4, 200],
            [49, 12.2, 13.0, 13.8, 15.0, 16.4, 18.0, 20.2, 92.5, 97.5, 47.5, 50.5, 200],
            [50, 12.3, 13.1, 13.9, 15.1, 16.6, 18.2, 20.4, 93.0, 98.0, 47.6, 50.6, 200],
            [51, 12.4, 13.2, 14.0, 15.3, 16.7, 18.3, 20.6, 93.5, 98.5, 47.7, 50.7, 200],
            [52, 12.5, 13.3, 14.1, 15.4, 16.8, 18.5, 20.8, 94.0, 99.0, 47.8, 50.8, 200],
            [53, 12.6, 13.4, 14.2, 15.5, 17.0, 18.6, 21.0, 94.5, 99.5, 47.9, 50.9, 200],
            [54, 12.7, 13.5, 14.3, 15.6, 17.1, 18.8, 21.2, 95.0, 100.0, 48.0, 51.0, 200],
            [55, 12.8, 13.6, 14.4, 15.7, 17.2, 18.9, 21.4, 95.5, 100.5, 48.1, 51.1, 200],
            [56, 12.9, 13.7, 14.5, 15.8, 17.4, 19.1, 21.6, 96.0, 101.0, 48.2, 51.2, 200],
            [57, 13.0, 13.8, 14.6, 16.0, 17.5, 19.2, 21.8, 96.5, 101.5, 48.3, 51.3, 200],
            [58, 13.1, 13.9, 14.7, 16.1, 17.6, 19.4, 22.0, 97.0, 102.0, 48.4, 51.4, 200],
            [59, 13.2, 14.0, 14.8, 16.2, 17.8, 19.5, 22.2, 97.5, 102.5, 48.5, 51.5, 200],
            [60, 13.3, 14.1, 14.9, 16.3, 17.9, 19.7, 22.4, 98.0, 103.0, 48.6, 51.6, 200]
        ];

        // Insert standar untuk laki-laki
        foreach ($standarUmum as $standar) {
            StandarKms::create([
                'jenis_kelamin' => 'L',
                'umur_bulan' => $standar[0],
                'berat_minimal' => $standar[1],
                'berat_minimal_2sd' => $standar[2],
                'berat_minimal_1sd' => $standar[3],
                'berat_ideal' => $standar[4],
                'berat_maksimal_1sd' => $standar[5],
                'berat_maksimal_2sd' => $standar[6],
                'berat_maksimal' => $standar[7],
                'tinggi_minimal' => $standar[8],
                'tinggi_ideal' => $standar[9],
                'lingkar_kepala_minimal' => $standar[10],
                'lingkar_kepala_ideal' => $standar[11],
                'kenaikan_minimal' => $standar[12],
                'kategori' => '24-60',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Insert standar untuk perempuan (data sama dengan laki-laki)
        foreach ($standarUmum as $standar) {
            StandarKms::create([
                'jenis_kelamin' => 'P',
                'umur_bulan' => $standar[0],
                'berat_minimal' => $standar[1],
                'berat_minimal_2sd' => $standar[2],
                'berat_minimal_1sd' => $standar[3],
                'berat_ideal' => $standar[4],
                'berat_maksimal_1sd' => $standar[5],
                'berat_maksimal_2sd' => $standar[6],
                'berat_maksimal' => $standar[7],
                'tinggi_minimal' => $standar[8],
                'tinggi_ideal' => $standar[9],
                'lingkar_kepala_minimal' => $standar[10],
                'lingkar_kepala_ideal' => $standar[11],
                'kenaikan_minimal' => $standar[12],
                'kategori' => '24-60',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $this->command->info('Standar KMS Versi 2 (24-60 bulan) dengan kenaikan minimal 200gr berhasil ditambahkan!');
    }
}
