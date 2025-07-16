<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandarKms extends Model
{
    //
    protected $table = 'standar_kms';

    protected $fillable = [
        'jenis_kelamin',
        'umur_bulan',
        'berat_minimal',
        'berat_minimal_2sd',
        'berat_minimal_1sd',
        'berat_ideal',
        'berat_maksimal_1sd',
        'berat_maksimal_2sd',
        'berat_maksimal',
        'tinggi_minimal',
        'tinggi_ideal',
        'lingkar_kepala_minimal',
        'lingkar_kepala_ideal',
        'kenaikan_minimal',
    ];


    public static function getStandar($jenisKelamin, $umurBulan)
    {
        return self::where('jenis_kelamin', $jenisKelamin)
            ->where('umur_bulan', $umurBulan)
            ->first();
    }

    // public static function getKbm($jenisKelamin, $umurBulan)
    // {
    //     return self::where('jenis_kelamin', $jenisKelamin)
    //         ->where('umur_bulan', $umurBulan)
    //         ->value('kenaikan_minimal');
    // }

    public static function getStatusGizi($jenisKelamin, $umurBulan, $beratBadan)
    {
        // Ambil data standar dari database
        $standar = self::where('jenis_kelamin', $jenisKelamin)
            ->where('umur_bulan', $umurBulan)
            ->first();

        if (!$standar) {
            return 'Data Standar Tidak Ditemukan';
        }

        // Tentukan status gizi berdasarkan berat badan
        if ($beratBadan < $standar->berat_minimal) {
            return 'Sangat Kurang';
        } elseif ($beratBadan < $standar->berat_minimal_2sd) {
            return 'Kurang';
        } elseif ($beratBadan <= $standar->berat_maksimal_1sd) {
            return 'Normal';
        } elseif ($beratBadan <= $standar->berat_maksimal_2sd) {
            return 'Lebih';
        } else {
            return 'Obesitas';
        }
    }


    public static function getKbm($jenisKelamin, $umurBulan, $kategori = '0-24')
    {
        return self::where('jenis_kelamin', $jenisKelamin)
            ->where('umur_bulan', $umurBulan)
            ->where('kategori', $kategori)
            ->value('kenaikan_minimal');
    }
}
