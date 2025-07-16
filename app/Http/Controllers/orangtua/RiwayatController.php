<?php

namespace App\Http\Controllers\orangtua;

use App\Models\Anak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    //
    public function riwayat_kms()
    {
        return view('orangtua.riwayat.index');
    }

    public function riwayat_imunisasi()
    {
        return view('orangtua.riwayat.index');
    }

    // public function riwayat_vitamin_a()
    // {

    //     return view('orangtua.riwayat.index');
    // }

    public function riwayat_vitamin_a($anakId)
    {
        try {
            $anak = Anak::with(['orangTua', 'vitamin' => function ($query) {
                $query->orderBy('tanggal', 'desc');
            }])->findOrFail($anakId);

            // Pastikan hanya orang tua yang memiliki akses ke data anaknya
            if (Auth::user()->role === 'orang_tua' && $anak->orang_tua_id !== Auth::user()->orangTua->id) {
                abort(403, 'Anda tidak memiliki akses ke data ini');
            }

            $usiaBulan = $anak->umur_bulan;

            $ageGroups = [
                ['min' => 6, 'max' => 11, 'label' => '6 - 11 bulan'],
                ['min' => 12, 'max' => 23, 'label' => '1 - 2 tahun'],
                ['min' => 24, 'max' => 35, 'label' => '2 - 3 tahun'],
                ['min' => 36, 'max' => 47, 'label' => '3 - 4 tahun'],
                ['min' => 48, 'max' => 59, 'label' => '4 - 5 tahun'],
                ['min' => 60, 'max' => 71, 'label' => '5 - 6 tahun'],
            ];

            return view('orangtua.riwayat.pdf_vit_a_viewer', [
                'anak' => $anak,
                'pdfUrl' => route('anak.export-pdf', $anak->id),
                'ageGroups' => $ageGroups,
                'usiaBulan' => $usiaBulan
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }
}
