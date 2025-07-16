<?php

namespace App\Helpers;

class ImunisasiHelper
{
    public static function getColorRules($kodeImunisasi)
    {
        $rules = [
            'HB0' => [
                '0' => '#FFFFFF',  // Putih - usia tepat
                '1-23' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '23-39' => '#c0c0c0' // Abu-abu - tidak diperbolehkan
            ],
            'BCG' => [
                '0-1' => '#FFFFFF',  // Putih - usia tepat
                '2-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '23-39' => '#c0c0c0'  // Abu-abu - tidak diperbolehkan
            ],
            'POLIO1' => [
                '0-1' => '#FFFFFF',  // Putih - usia tepat
                '2-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'DPT-HB-HIB1' => [
                '0-1' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '2' => '#FFFFFF',    // Putih - usia tepat
                '3-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'POLIO2' => [
                '0-1' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '2' => '#FFFFFF',    // Putih - usia tepat
                '3-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'RV1' => [
                '0-1' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '2' => '#FFFFFF',   // Putih - usia tepat
                '3-6' => '#ecec53', // Kuning - masih diperbolehkan
                '7-23' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '23-39' => '#c0c0c0' // Abu-abu - tidak diperbolehkan
            ],
            'PCV1' => [
                '0-1' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '2' => '#FFFFFF',    // Putih - usia tepat
                '3-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'DPT-HB-HIB2' => [
                '0-2' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '3' => '#FFFFFF',    // Putih - usia tepat
                '4-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'POLIO3' => [
                '0-2' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '3' => '#FFFFFF',    // Putih - usia tepat
                '4-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'RV2' => [
                '0-2' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '3' => '#FFFFFF',   // Putih - usia tepat
                '4-6' => '#ecec53', // Kuning - masih diperbolehkan
                '7-23' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '23-39' => '#c0c0c0' // Abu-abu - tidak diperbolehkan
            ],
            'PCV2' => [
                '0-2' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '3' => '#FFFFFF',    // Putih - usia tepat
                '4-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'DPT-HB-HIB3' => [
                '0-3' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '4' => '#FFFFFF',   // Putih - usia tepat
                '5-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'POLIO4' => [
                '0-3' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '4' => '#FFFFFF',    // Putih - usia tepat
                '5-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'IPV1' => [
                '0-3' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '4' => '#FFFFFF',    // Putih - usia tepat
                '5-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'RV3' => [
                '0-3' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '4' => '#FFFFFF',    // Putih - usia tepat
                '5-6' => '#ecec53', // Kuning - masih diperbolehkan
                '7-23' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '23-39' => '#c0c0c0' // Abu-abu - tidak diperbolehkan
            ],
            'MR1' => [
                '0-8' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '9' => '#FFFFFF',    // Putih - usia tepat
                '10-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'IPV2' => [
                '0-8' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '9' => '#FFFFFF',    // Putih - usia tepat
                '10-11' => '#ecec53', // Kuning - masih diperbolehkan
                '12-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'JE' => [
                '0-9' => '#c0c0c0', // Abu-abu - tidak diperbolehkan
                '10' => '#FFFFFF',   // Putih - usia tepat
                '11-23' => '#ff7069', // Merah - imunisasi kejar
                '23-39' => '#ff7069'  // Merah - imunisasi kejar
            ],
            'PCV3' => [
                '0-11' => '#c0c0c0',
                '12' => '#FFFFFF',
                '18' => '#ecec53',
                '23' => '#ecec53', // Kuning untuk umur 23 bulan
                '23-39' => '#ff7069' // Merah untuk 23-39 bulan
            ],
            'DPT-HB-HIB-BOOSTER' => [
                '0-12' => '#c0c0c0',
                '18' => '#FFFFFF',
                '23' => '#ecec53', // Kuning untuk umur 23 bulan
                '23-39' => '#ff7069' // Merah untuk 23-39 bulan
            ],
            'MR2' => [
                '0-12' => '#c0c0c0',
                '18' => '#FFFFFF',
                '23' => '#ecec53', // Kuning untuk umur 23 bulan
                '23-39' => '#ff7069' // Merah untuk 23-39 bulan
            ]
        ];

        return $rules[$kodeImunisasi] ?? [];
    }

    public static function determineCellColor($kodeImunisasi, $bulan)
    {
        $rules = self::getColorRules($kodeImunisasi);

        // 1. Cek apakah bulan ada di rules sebagai key langsung (termasuk 23)
        if (array_key_exists($bulan, $rules)) {
            return $rules[$bulan];
        }

        // 2. Handle khusus untuk bulan 23 (sebelum pengecekan 23-39)
        if ($bulan == 23 && array_key_exists(23, $rules)) {
            return $rules[23];
        }

        // 3. Handle untuk range 23-39 (hanya jika bulan > 23)
        if ($bulan > 23) {
            $bulanToCheck = '23-39';
            if (array_key_exists($bulanToCheck, $rules)) {
                return $rules[$bulanToCheck];
            }
        }

        // 4. Cek untuk range lainnya
        foreach ($rules as $range => $color) {
            if (strpos($range, '-') !== false) {
                list($min, $max) = explode('-', $range);
                if ($bulan >= $min && $bulan <= $max) {
                    return $color;
                }
            }
        }

        return '#c0c0c0'; // Default abu-abu jika tidak ada rule yang cocok
    }

    public static function getColorClass($hexColor)
    {
        $colorMap = [
            '#FFFFFF' => 'bg-putih',
            '#FFEB3B' => 'bg-kuning',
            '#F44336' => 'bg-merah',
            '#9E9E9E' => 'bg-abu',
            '#c0c0c0' => 'bg-abu',
            '#ecec53' => 'bg-kuning',
            '#ff7069' => 'bg-merah'
        ];

        return $colorMap[$hexColor] ?? '';
    }
}
