<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Anak;
use App\Models\AnakVitamin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class VitaminAController extends Controller
{
    public function index(Request $request)
    {
        $anakList = Anak::orderBy('nama_lengkap')->get();
        $anakSelected = null;

        if ($request->has('anak_id')) {
            $anakSelected = Anak::with(['vitamin' => function ($query) {
                $query->orderBy('tanggal', 'desc');
            }])->findOrFail($request->anak_id);
        }

        return view('admin.vitamin-a.index', compact('anakList', 'anakSelected'));
    }

    public function show(Request $request)
    {
        return $this->index($request);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'anak_id' => 'required|exists:anak,id',
            'jenis' => 'required|in:Vitamin A,Obat Cacing',
            'warna' => 'required_if:jenis,==,Vitamin A|in:biru,merah',
            'bulan' => 'required_if:jenis,==,Vitamin A|in:feb,aug',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        try {
            // Cek duplikasi data
            $existing = AnakVitamin::where('anak_id', $request->anak_id)
                ->where('jenis', $request->jenis)
                ->when($request->jenis == 'Vitamin A', function ($q) use ($request) {
                    $q->where('warna', $request->warna)
                        ->whereMonth('tanggal', $request->bulan == 'feb' ? 2 : 8);
                })
                ->whereYear('tanggal', date('Y'))
                ->exists();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sudah ada pemberian ' . $request->jenis . ' untuk periode ini'
                ], 400);
            }

            // Simpan data
            $vitamin = AnakVitamin::create([
                'anak_id' => $request->anak_id,
                'jenis' => $request->jenis,
                'warna' => $request->jenis == 'Vitamin A' ? $request->warna : null,
                'bulan' => $request->jenis == 'Vitamin A' ? $request->bulan : null,
                'tanggal' => $request->tanggal,
                'dosis' => $request->jenis == 'Vitamin A'
                    ? ($request->warna == 'biru' ? 'Kapsul Biru (100.000 IU)' : 'Kapsul Merah (200.000 IU)')
                    : 'Obat Cacing',
                'keterangan' => $request->keterangan,
                'petugas_id' => 1 // Simpan ID petugas yang melakukan pemberian
                // 'petugas_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data pemberian berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function batalkanParaf(Request $request)
    {
        $request->validate([
            'pivot_id' => 'required|exists:anak_vitamin,id'
        ]);

        try {
            $vitamin = AnakVitamin::findOrFail($request->pivot_id);

            // Cek apakah petugas yang sama dan dalam waktu 20 menit
            if ($vitamin->petugas_id != Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya petugas yang memberikan yang bisa membatalkan'
                ], 403);
            }

            if ($vitamin->created_at->diffInMinutes(now()) > 20) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya bisa dibatalkan dalam 20 menit setelah pemberian'
                ], 400);
            }

            $vitamin->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pemberian berhasil dibatalkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportPdf($anakId)
    {
        $anak = Anak::with(['vitamin' => function ($query) {
            $query->orderBy('tanggal', 'desc');
        }])->findOrFail($anakId);

        $usiaBulan = $anak->umur_bulan;

        $ageGroups = [
            ['min' => 6, 'max' => 11, 'label' => '6 - 11 bulan'],
            ['min' => 12, 'max' => 23, 'label' => '1 - 2 tahun'],
            ['min' => 24, 'max' => 35, 'label' => '2 - 3 tahun'],
            ['min' => 36, 'max' => 47, 'label' => '3 - 4 tahun'],
            ['min' => 48, 'max' => 59, 'label' => '4 - 5 tahun'],
            ['min' => 60, 'max' => 71, 'label' => '5 - 6 tahun'],
        ];

        $pdf = PDF::loadView('admin.vitamin-a.pdf', [
            'anak' => $anak,
            'usiaBulan' => $usiaBulan,
            'ageGroups' => $ageGroups,
            'currentYear' => date('Y')
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('rekam-medis-vitamin-a-' . Str::slug($anak->nama_lengkap) . '.pdf');
    }

    public function exportPdfV2($encryptedId)
    {
        try {
            // 1. Dekripsi ID anak
            $anakId = Crypt::decrypt($encryptedId);

            // 2. Validasi ID hasil dekripsi
            if (!is_numeric($anakId)) {
                throw new \Exception('ID anak tidak valid setelah dekripsi');
            }

            // 3. Ambil data anak dengan eager loading
            $anak = Anak::with(['vitamin' => function ($query) {
                $query->orderBy('tanggal', 'desc');
            }])->findOrFail($anakId);

            // 4. Hitung usia dalam bulan
            $usiaBulan = $anak->umur_bulan;

            // 5. Definisikan kelompok usia untuk Vitamin A
            $ageGroups = [
                ['min' => 6, 'max' => 11, 'label' => '6 - 11 bulan'],
                ['min' => 12, 'max' => 23, 'label' => '1 - 2 tahun'],
                ['min' => 24, 'max' => 35, 'label' => '2 - 3 tahun'],
                ['min' => 36, 'max' => 47, 'label' => '3 - 4 tahun'],
                ['min' => 48, 'max' => 59, 'label' => '4 - 5 tahun'],
                ['min' => 60, 'max' => 71, 'label' => '5 - 6 tahun'],
            ];

            // 6. Generate PDF dengan data yang diperlukan
            $pdf = PDF::loadView('admin.vitamin-a.pdf', [
                'anak' => $anak,
                'usiaBulan' => $usiaBulan,
                'ageGroups' => $ageGroups,
                'currentYear' => date('Y'),
                'timestamp' => now()->timestamp // Untuk prevent caching
            ]);

            // 7. Return PDF stream dengan nama file yang sesuai
            return $pdf->stream('rekam-medis-vitamin-a-' . Str::slug($anak->nama_lengkap) . '.pdf');
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Handle error dekripsi
            abort(400, 'ID tidak valid atau telah kadaluarsa');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle data tidak ditemukan
            abort(404, 'Data anak tidak ditemukan');
        } catch (\Exception $e) {
            // Handle error umum
            abort(500, 'Terjadi kesalahan saat memproses PDF: ' . $e->getMessage());
        }
    }
}
