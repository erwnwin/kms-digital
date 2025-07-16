<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Anak;
use Illuminate\Http\Request;
use App\Models\JenisImunisasi;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class ImunisasiController extends Controller
{
    //
    public function index()
    {
        $anakList = Anak::orderBy('nama_lengkap')->get();
        return view('admin.imunisasi.index', compact('anakList'));
    }

    public function show(Request $request)
    {
        $anakList = Anak::orderBy('nama_lengkap')->get();

        if ($request->has('anak_id')) {
            $anakSelected = Anak::with(['imunisasi' => function ($query) {
                $query->withPivot('bulan', 'jenis_imunisasi_id');
            }])->findOrFail($request->anak_id);

            $jadwalImunisasi = JenisImunisasi::orderBy('id', 'asc')->get()
                ->map(function ($item) use ($anakSelected) {
                    $item->colorRules = \App\Helpers\ImunisasiHelper::getColorRules($item->kode);

                    // Ambil semua bulan yang sudah diimunisasi untuk vaksin ini
                    $completedMonths = [];
                    foreach ($anakSelected->imunisasi as $imunisasi) {
                        if ($imunisasi->pivot->jenis_imunisasi_id == $item->id) {
                            $completedMonths[] = $imunisasi->pivot->bulan;
                        }
                    }

                    $item->completedMonths = $completedMonths;
                    return $item;
                });

            return view('admin.imunisasi.index', compact('anakList', 'anakSelected', 'jadwalImunisasi'));
        }

        return view('admin.imunisasi.index', compact('anakList'));
    }


    public function toggleImunisasi(Request $request)
    {
        try {
            $anak = Anak::findOrFail($request->anak_id);
            $imunisasi = JenisImunisasi::findOrFail($request->imunisasi_id);

            if ($request->is_checked) {
                // Tambah imunisasi dengan dosis
                $anak->imunisasi()->attach($imunisasi->id, [
                    'bulan' => $request->bulan,
                    'tanggal' => $request->tanggal,
                    'dosis' => $request->dosis,
                    'petugas_id' => 1,
                    'keterangan' => 'Dosis ke-' . $request->dosis
                ]);
            } else {
                // Hapus imunisasi
                $anak->imunisasi()
                    ->wherePivot('bulan', $request->bulan)
                    ->wherePivot('jenis_imunisasi_id', $imunisasi->id)
                    ->detach();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'anak_id' => 'required|exists:anak,id',
            'jenis_imunisasi_id' => 'required|exists:jenis_imunisasi,id',
            'bulan' => 'required|numeric',
            'tanggal' => 'required|date',
            'dosis' => 'required|numeric',
            'keterangan' => 'nullable|string'
        ]);

        $anak = Anak::findOrFail($request->anak_id);

        // Cek apakah sudah ada imunisasi ini di bulan yang sama
        $existing = $anak->imunisasi()
            ->where('jenis_imunisasi_id', $request->jenis_imunisasi_id)
            ->wherePivot('bulan', $request->bulan)
            ->exists();

        if ($existing) {
            return redirect()->back()->with('error', 'Imunisasi ini sudah tercatat untuk bulan tersebut');
        }

        $anak->imunisasi()->attach($request->jenis_imunisasi_id, [
            'tanggal' => $request->tanggal,
            'dosis' => $request->dosis,
            'keterangan' => $request->keterangan,
            'bulan' => $request->bulan,
            'petugas_id' => 1
        ]);

        return redirect()->back()->with('success', 'Data imunisasi berhasil disimpan');
    }


    public function batalkanParaf(Request $request)
    {
        DB::beginTransaction();
        try {
            // Cari data pivot dengan relasi yang benar
            $pivotData = DB::table('anak_imunisasi')
                ->where('id', $request->pivot_id)
                ->where('petugas_id', 1) // Pastikan hanya pemilik yang bisa batalkan
                ->first();

            if (!$pivotData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data imunisasi tidak ditemukan atau Anda tidak memiliki akses'
                ], 404);
            }

            // Cek waktu (20 menit)
            $createdAt = Carbon::parse($pivotData->created_at);
            if ($createdAt->diffInMinutes(now()) > 20) {
                return response()->json([
                    'success' => false,
                    'message' => 'Waktu untuk membatalkan paraf sudah habis (maksimal 20 menit)'
                ], 400);
            }

            // Hapus data
            DB::table('anak_imunisasi')
                ->where('id', $request->pivot_id)
                ->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paraf berhasil dibatalkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }



    public function generatePDF(Anak $anak)
    {
        // Load data yang sama dengan view show
        $anak->load(['imunisasi' => function ($query) {
            $query->withPivot('bulan', 'jenis_imunisasi_id', 'tanggal', 'dosis');
        }]);

        $jadwalImunisasi = JenisImunisasi::orderBy('id', 'asc')->get()
            ->map(function ($item) use ($anak) {
                $item->colorRules = \App\Helpers\ImunisasiHelper::getColorRules($item->kode);

                $completedMonths = [];
                $parafData = [];

                foreach ($anak->imunisasi as $imunisasi) {
                    if ($imunisasi->pivot->jenis_imunisasi_id == $item->id) {
                        $completedMonths[] = $imunisasi->pivot->bulan;
                        $parafData[$imunisasi->pivot->bulan] = [
                            'tanggal' => $imunisasi->pivot->tanggal,
                            'dosis' => $imunisasi->pivot->dosis
                        ];
                    }
                }

                $item->completedMonths = $completedMonths;
                $item->parafData = $parafData;
                return $item;
            });

        $pdf = PDF::loadView('admin.imunisasi.pdf', [
            'anak' => $anak,
            'jadwalImunisasi' => $jadwalImunisasi
        ]);

        return $pdf->stream('jadwal-imunisasi-' . $anak->nama_lengkap . '.pdf');
    }

    // public function determineCellColor($kodeImunisasi, $bulan)
    // {
    //     // Define color rules for each vaccine type
    //     $rules = [
    //         'HB0' => [
    //             '0' => '#FFFFFF', // Putih
    //             '1-23' => '#f8f9fa', // Abu-abu
    //             '23-39' => '#f8f9fa' // Abu-abu
    //         ],
    //         'BCG' => [
    //             '0-1' => '#FFFFFF', // Putih
    //             '2-11' => '#FFF3CD', // Kuning
    //             '12-23' => '#f8f9fa', // Abu-abu
    //             '23-39' => '#f8f9fa' // Abu-abu
    //         ],
    //         'Polio1' => [
    //             '0-1' => '#FFFFFF', // Putih
    //             '2-11' => '#FFF3CD', // Kuning
    //             '12-23' => '#F5C6CB', // Merah
    //             '23-39' => '#F5C6CB' // Merah
    //         ],
    //         // Add all other vaccine rules following the same pattern
    //         // ...
    //     ];

    //     // Find the matching rule for this vaccine and month
    //     foreach ($rules[$kodeImunisasi] as $range => $color) {
    //         if (strpos($range, '-') !== false) {
    //             list($min, $max) = explode('-', $range);
    //             if ($bulan >= $min && $bulan <= $max) {
    //                 return $color;
    //             }
    //         } elseif ($bulan == $range) {
    //             return $color;
    //         }
    //     }

    //     return '#f8f9fa'; // Default gray
    // }

    // public function getColorRules($kodeImunisasi)
    // {
    //     // Return all color rules for a specific vaccine
    //     $allRules = [
    //         'HB0' => [
    //             ['months' => '0', 'color' => '#FFFFFF', 'label' => 'Usia tepat pemberian'],
    //             ['months' => '1-23', 'color' => '#f8f9fa', 'label' => 'Tidak diperbolehkan'],
    //             ['months' => '23-39', 'color' => '#f8f9fa', 'label' => 'Tidak diperbolehkan']
    //         ],
    //         'BCG' => [
    //             ['months' => '0-1', 'color' => '#FFFFFF', 'label' => 'Usia tepat pemberian'],
    //             ['months' => '2-11', 'color' => '#FFF3CD', 'label' => 'Masih diperbolehkan'],
    //             ['months' => '12-23', 'color' => '#f8f9fa', 'label' => 'Tidak diperbolehkan'],
    //             ['months' => '23-39', 'color' => '#f8f9fa', 'label' => 'Tidak diperbolehkan']
    //         ],
    //         // Add all other vaccines with their rules
    //         // ...
    //     ];

    //     return $allRules[$kodeImunisasi] ?? [];
    // }


    // public function show($anakId)
    // {
    //     $anak = Anak::findOrFail($anakId);
    //     $umurBulan = $anak->umur_bulan;
    //     $allImunisasi = JenisImunisasi::orderBy('usia_minimal_bulan')->get();
    //     $riwayat = $anak->imunisasi;

    //     return view('admin.imunisasi.show', compact('anak', 'umurBulan', 'allImunisasi', 'riwayat'));
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'anak_id' => 'required|exists:anak,id',
    //         'jenis_imunisasi_id' => 'required|exists:jenis_imunisasi,id',
    //         'tanggal' => 'required|date|before_or_equal:today',
    //         'dosis' => 'required|string',
    //         'keterangan' => 'nullable|string'
    //     ]);

    //     $validated['petugas_id'] = 2;

    //     AnakImunisasi::create($validated);

    //     return redirect()->back()->with('success', 'Data imunisasi berhasil disimpan');
    // }
}
