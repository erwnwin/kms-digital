<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisImunisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataImunisasi = [
            // Format: kode, nama, deskripsi, usia_minimal_bulan, usia_maksimal_bulan, dosis_ke, interval_dosis_bulan, wajib, warna, warna_background
            ['HB0', 'Hepatitis B-0', 'Vaksin Hepatitis B dosis pertama diberikan saat lahir', 0, 0, 1, null, true, '#FFFFFF', '#E9ECEF'],
            ['BCG', 'BCG', 'Vaksin untuk mencegah tuberkulosis', 1, 1, 1, null, true, '#FFFFFF', '#FFEEBA'],
            ['POLIO1', 'Polio Tetes 1', 'Vaksin polio tetes dosis pertama', 0, 1, 1, null, true, '#FFFFFF', '#FFEEBA'],
            ['DPT-HB-HIB1', 'DPT-HB-HiB 1', 'Vaksin kombinasi difteri, pertusis, tetanus, hepatitis B, dan Haemophilus influenzae tipe b dosis pertama', 2, 2, 1, null, true, '#FFFFFF', '#FFEEBA'],
            ['POLIO2', 'Polio Tetes 2', 'Vaksin polio tetes dosis kedua', 2, 2, 2, 2, true, '#FFFFFF', '#FFEEBA'],
            ['RV1', 'Rotavirus 1', 'Vaksin rotavirus dosis pertama', 2, 2, 1, null, true, '#FFFFFF', '#FFEEBA'],
            ['PCV1', 'PCV 1', 'Vaksin pneumokokus dosis pertama', 2, 2, 1, null, true, '#FFFFFF', '#FFEEBA'],
            ['DPT-HB-HIB2', 'DPT-HB-HiB 2', 'Vaksin kombinasi difteri, pertusis, tetanus, hepatitis B, dan Haemophilus influenzae tipe b dosis kedua', 3, 3, 2, 1, true, '#FFFFFF', '#FFEEBA'],
            ['POLIO3', 'Polio Tetes 3', 'Vaksin polio tetes dosis ketiga', 3, 3, 3, 1, true, '#FFFFFF', '#FFEEBA'],
            ['RV2', 'Rotavirus 2', 'Vaksin rotavirus dosis kedua', 3, 3, 2, 1, true, '#FFFFFF', '#FFEEBA'],
            ['PCV2', 'PCV 2', 'Vaksin pneumokokus dosis kedua', 3, 3, 2, 1, true, '#FFFFFF', '#FFEEBA'],
            ['DPT-HB-HIB3', 'DPT-HB-HiB 3', 'Vaksin kombinasi difteri, pertusis, tetanus, hepatitis B, dan Haemophilus influenzae tipe b dosis ketiga', 4, 4, 3, 1, true, '#FFFFFF', '#FFEEBA'],
            ['POLIO4', 'Polio Tetes 4', 'Vaksin polio tetes dosis keempat', 4, 4, 4, 1, true, '#FFFFFF', '#FFEEBA'],
            ['IPV1', 'Polio Suntik (IPV) 1', 'Vaksin polio suntik dosis pertama', 4, 4, 1, null, true, '#FFFFFF', '#FFEEBA'],
            ['RV3', 'Rotavirus 3', 'Vaksin rotavirus dosis ketiga (jika diperlukan)', 4, 4, 3, 1, true, '#FFFFFF', '#FFEEBA'],
            ['MR1', 'Campak Rubella (MR) 1', 'Vaksin campak dan rubella dosis pertama', 9, 9, 1, null, true, '#FFFFFF', '#FFEEBA'],
            ['IPV2', 'Polio Suntik (IPV) 2', 'Vaksin polio suntik dosis kedua', 9, 9, 2, 5, true, '#FFFFFF', '#FFEEBA'],
            ['JE', 'Japanese Encephalitis (JE)', 'Vaksin Japanese Encephalitis', 10, 10, 1, null, true, '#FFFFFF', '#FFEEBA'],
            ['PCV3', 'PCV 3', 'Vaksin pneumokokus dosis ketiga', 12, 12, 3, 9, true, '#FFFFFF', '#FFEEBA'],
            ['DPT-HB-HIB-BOOSTER', 'DPT-HB-HiB Lanjutan', 'Vaksin booster difteri, pertusis, tetanus, hepatitis B, dan Haemophilus influenzae tipe b', 13, 13, 4, 9, true, '#FFFFFF', '#FFEEBA'],
            ['MR2', 'Campak Rubella (MR) 2', 'Vaksin campak dan rubella dosis kedua', 13, 13, 2, 4, true, '#FFFFFF', '#FFEEBA'],
        ];

        foreach ($dataImunisasi as $imunisasi) {
            DB::table('jenis_imunisasi')->insert([
                'kode' => $imunisasi[0],
                'nama' => $imunisasi[1],
                'deskripsi' => $imunisasi[2],
                'usia_minimal_bulan' => $imunisasi[3],
                'usia_maksimal_bulan' => $imunisasi[4],
                'dosis_ke' => $imunisasi[5],
                'interval_dosis_bulan' => $imunisasi[6],
                'wajib' => $imunisasi[7],
                'warna' => $imunisasi[8],
                'warna_background' => $imunisasi[9],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
