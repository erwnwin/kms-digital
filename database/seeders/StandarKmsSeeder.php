<?php

namespace Database\Seeders;

use App\Models\StandarKms;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StandarKmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // WHO Standard Data
        $whoStandards = [
            'veryLow' => [
                2.1,
                2.9,
                3.8,
                4.4,
                4.9,
                5.3,
                5.7,
                6.0,
                6.3,
                6.5,
                6.7,
                6.9,
                7.0,
                7.2,
                7.3,
                7.5,
                7.6,
                7.8,
                7.9,
                8.1,
                8.2,
                8.4,
                8.5,
                8.6,
                8.8
            ],
            'low' => [
                2.5,
                3.4,
                4.3,
                5.0,
                5.6,
                6.0,
                6.4,
                6.7,
                6.9,
                7.1,
                7.4,
                7.6,
                7.7,
                7.9,
                8.1,
                8.3,
                8.4,
                8.6,
                8.8,
                8.9,
                9.1,
                9.2,
                9.4,
                9.5,
                9.7
            ],
            'normalLow' => [
                2.9,
                3.9,
                4.9,
                5.7,
                6.2,
                6.7,
                7.1,
                7.4,
                7.7,
                8.0,
                8.2,
                8.4,
                8.6,
                8.8,
                9.0,
                9.2,
                9.4,
                9.6,
                9.8,
                10.0,
                10.1,
                10.3,
                10.5,
                10.7,
                10.8
            ],
            'median' => [
                3.3,
                4.5,
                5.6,
                6.4,
                7.0,
                7.5,
                7.9,
                8.3,
                8.6,
                8.9,
                9.2,
                9.4,
                9.6,
                9.9,
                10.1,
                10.3,
                10.5,
                10.7,
                10.9,
                11.1,
                11.3,
                11.5,
                11.8,
                12.0,
                12.2
            ],
            'normalHigh' => [
                3.9,
                5.1,
                6.3,
                7.2,
                7.8,
                8.4,
                8.8,
                9.2,
                9.6,
                9.9,
                10.2,
                10.5,
                10.8,
                11.0,
                11.3,
                11.5,
                11.8,
                12.0,
                12.3,
                12.5,
                12.8,
                13.0,
                13.3,
                13.5,
                13.7
            ],
            'high' => [
                4.4,
                5.8,
                7.1,
                8.0,
                8.7,
                9.3,
                9.8,
                10.3,
                10.7,
                11.0,
                11.4,
                11.7,
                12.0,
                12.3,
                12.6,
                12.9,
                13.1,
                13.4,
                13.7,
                14.0,
                14.3,
                14.6,
                14.9,
                15.2,
                15.4
            ],
            'veryHigh' => [
                5.0,
                6.6,
                8.0,
                9.0,
                9.8,
                10.5,
                11.0,
                11.5,
                12.0,
                12.4,
                12.8,
                13.1,
                13.5,
                13.8,
                14.1,
                14.5,
                14.8,
                15.1,
                15.4,
                15.7,
                16.0,
                16.4,
                16.7,
                17.0,
                17.3
            ]
        ];

        // For both genders
        $genders = ['L', 'P'];

        foreach ($genders as $gender) {
            for ($month = 0; $month <= 24; $month++) {
                // For months 0-24 (25 data points)
                $index = $month;

                // Map WHO standards to your database columns
                $data = [
                    'jenis_kelamin' => $gender,
                    'umur_bulan' => $month,
                    'berat_minimal' => $whoStandards['veryLow'][$index],       // -3SD
                    'berat_minimal_2sd' => $whoStandards['low'][$index],       // -2SD
                    'berat_minimal_1sd' => $whoStandards['normalLow'][$index], // -1SD
                    'berat_ideal' => $whoStandards['median'][$index],          // Median (0SD)
                    'berat_maksimal_1sd' => $whoStandards['normalHigh'][$index], // +1SD
                    'berat_maksimal_2sd' => $whoStandards['high'][$index],      // +2SD
                    'berat_maksimal' => $whoStandards['veryHigh'][$index],      // +3SD

                    // For other fields, I'll use approximate values based on WHO standards
                    // You may want to adjust these with actual WHO height standards
                    'tinggi_minimal' => $this->getHeightStandard($month, 'minimal', $gender),
                    'tinggi_ideal' => $this->getHeightStandard($month, 'ideal', $gender),
                    'lingkar_kepala_minimal' => $this->getHeadCircumference($month, 'minimal', $gender),
                    'lingkar_kepala_ideal' => $this->getHeadCircumference($month, 'ideal', $gender),
                    'kenaikan_minimal' => $this->getMinimalWeightGain($month),
                    'kategori' => '0-24', // Assuming 0-24 months for first 24 entries
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                DB::table('standar_kms')->insert($data);
            }
        }
    }

    /**
     * Helper function to get height standard
     * Note: Replace with actual WHO height standards if available
     */
    private function getHeightStandard($month, $type, $gender)
    {
        // These are approximate values - replace with actual WHO standards
        $baseHeight = $gender === 'L' ? 50 : 49; // Birth length differs slightly by gender

        if ($type === 'minimal') {
            return round($baseHeight + ($month * 1.5) + rand(0, 5) / 10, 2);
        } else { // ideal
            return round($baseHeight + ($month * 2.5) + rand(0, 5) / 10, 2);
        }
    }

    /**
     * Helper function to get head circumference
     * Note: Replace with actual WHO standards if available
     */
    private function getHeadCircumference($month, $type, $gender)
    {
        // These are approximate values - replace with actual WHO standards
        $baseHC = $gender === 'L' ? 35 : 34; // Birth head circumference

        if ($type === 'minimal') {
            return round($baseHC + ($month * 0.5) + rand(0, 5) / 10, 2);
        } else { // ideal
            return round($baseHC + ($month * 1.0) + rand(0, 5) / 10, 2);
        }
    }

    /**
     * Helper function to get minimal weight gain per month
     */
    private function getMinimalWeightGain($month)
    {
        if ($month == 0) return 0;
        if ($month <= 3) return 800;  // First 3 months: ~800g/month
        if ($month <= 6) return 600;  // 4-6 months: ~600g/month
        if ($month <= 12) return 400; // 7-12 months: ~400g/month
        return 200;                  // After 1 year: ~200g/month
    }
}
