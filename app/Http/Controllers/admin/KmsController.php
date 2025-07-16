<?php

namespace App\Http\Controllers\admin;

use App\Models\Anak;
use App\Models\StandarKms;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AnakTimbangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class KmsController extends Controller
{
    //

    public function index()
    {
        $anak = Anak::with(['orangTua.user', 'timbangan'])
            ->orderBy('nama_lengkap')
            ->paginate(10);
        return view('admin.kms.index', compact('anak'));
    }

    public function show($encryptedId)
    {
        try {
            $anakId = Crypt::decrypt($encryptedId);
            $anak = Anak::with(['timbangan' => function ($query) {
                $query->where('umur_bulan', '<=', 24) // Hanya ambil data 0-24 bulan
                    ->orderBy('umur_bulan');
            }])->findOrFail($anakId);

            $umurBulan = $anak->umur_bulan;

            $editableMonths = $this->getEditableMonths($umurBulan);

            // Ambil data standar pertumbuhan KMS 1 (0-24 bulan)
            $standarPertumbuhan = StandarKms::where('jenis_kelamin', $anak->jenis_kelamin)
                ->where('umur_bulan', '<=', 24)
                ->where('kategori', '0-24') // Pastikan hanya ambil standar KMS 1
                ->orderBy('umur_bulan')
                ->get();

            // Format data untuk chart
            $chartStandards = [
                'veryLow' => $standarPertumbuhan->pluck('berat_minimal')->toArray(),
                'low' => $standarPertumbuhan->pluck('berat_minimal_2sd')->toArray(),
                'normalLow' => $standarPertumbuhan->pluck('berat_minimal_1sd')->toArray(),
                'median' => $standarPertumbuhan->pluck('berat_ideal')->toArray(),
                'normalHigh' => $standarPertumbuhan->pluck('berat_maksimal_1sd')->toArray(),
                'high' => $standarPertumbuhan->pluck('berat_maksimal_2sd')->toArray(),
                'veryHigh' => $standarPertumbuhan->pluck('berat_maksimal')->toArray(),
                'umur_bulan' => $standarPertumbuhan->pluck('umur_bulan')->toArray()
            ];

            // Data untuk tabel (0-24 bulan)
            $tabelBulanan = [];
            for ($i = 0; $i <= 24; $i++) {
                $timbangan = $anak->timbangan->firstWhere('umur_bulan', $i);
                $tabelBulanan[] = [
                    'bulan' => $i,
                    'bb' => $timbangan ? $timbangan->berat : null,
                    'kbm' => $i > 0 ? StandarKms::getKbm($anak->jenis_kelamin, $i, '0-24') : null,
                    'status' => $timbangan ? $timbangan->kategori_berat : null,
                    'asi' => $timbangan ? $timbangan->asi_eksklusif : null,
                    'editable' => in_array($i, $editableMonths),
                    'status_gizi' => $timbangan->status_gizi ?? null,
                ];
            }

            return view('admin.kms.show', [
                'anak' => $anak,
                'umurBulan' => $umurBulan,
                'encryptedId' => $encryptedId,
                'standarPertumbuhan' => $chartStandards,
                'tabelBulanan' => $tabelBulanan
            ]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        }
    }

    public function generatePDF($encryptedId)
    {
        try {
            // Validasi input lebih ketat
            if (!is_string($encryptedId) || strlen($encryptedId) < 10) {
                throw new \InvalidArgumentException('Format ID tidak valid');
            }

            // Dekripsi ID dengan error handling
            try {
                $anakId = Crypt::decrypt($encryptedId);
                if (!is_numeric($anakId)) {
                    throw new \Exception('ID hasil dekripsi bukan numerik');
                }
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                throw new \Exception('Gagal mendekripsi ID: ' . $e->getMessage());
            }

            // Get child data with eager loading
            $anak = Anak::with(['timbangan' => function ($query) {
                $query->orderBy('umur_bulan', 'asc');
            }])->findOrFail($anakId);

            // Validasi data anak
            if (empty($anak->jenis_kelamin)) {
                throw new \Exception('Data jenis kelamin anak tidak valid');
            }

            // Get growth standards with fallback
            $standarPertumbuhan = StandarKms::where('jenis_kelamin', $anak->jenis_kelamin)
                ->where('umur_bulan', '<=', 24)
                ->orderBy('umur_bulan')
                ->get();

            if ($standarPertumbuhan->isEmpty()) {
                // Coba ambil standar default jika tidak ditemukan
                $standarPertumbuhan = StandarKms::where('jenis_kelamin', 'L') // Default Laki-laki
                    ->where('umur_bulan', '<=', 24)
                    ->orderBy('umur_bulan')
                    ->get();

                if ($standarPertumbuhan->isEmpty()) {
                    throw new \Exception('Tidak ada data standar pertumbuhan yang tersedia');
                }
            }

            // Siapkan data chart dengan validasi
            $chartData = [
                'labels' => $standarPertumbuhan->pluck('umur_bulan')->toArray(),
                'veryLow' => $standarPertumbuhan->pluck('berat_minimal')->toArray(),
                'low' => $standarPertumbuhan->pluck('berat_minimal_2sd')->toArray(),
                'normalLow' => $standarPertumbuhan->pluck('berat_minimal_1sd')->toArray(),
                'median' => $standarPertumbuhan->pluck('berat_ideal')->toArray(),
                'normalHigh' => $standarPertumbuhan->pluck('berat_maksimal_1sd')->toArray(),
                // 'median' => $standarPertumbuhan->pluck('berat_ideal')->toArray(),
                'high' => $standarPertumbuhan->pluck('berat_maksimal_2sd')->toArray(),
                'veryHigh' => $standarPertumbuhan->pluck('berat_maksimal')->toArray()
            ];

            // Validasi data chart
            foreach ($chartData as $key => $values) {
                if (empty($values) || !is_array($values)) {
                    throw new \Exception("Data chart $key tidak valid");
                }
            }

            // Siapkan data berat badan anak
            $bbAnak = array_fill(0, 25, null);
            foreach ($anak->timbangan as $timbangan) {
                $bulan = (int)$timbangan->umur_bulan;
                if ($bulan >= 0 && $bulan <= 24) {
                    $bbAnak[$bulan] = (float)$timbangan->berat;
                }
            }

            // Generate chart URL dengan timeout
            $chartUrl = null;
            try {
                $chartUrl = $this->generateChartUrl($chartData, $bbAnak);

                // Verifikasi URL chart
                if (!filter_var($chartUrl, FILTER_VALIDATE_URL)) {
                    throw new \Exception('URL chart tidak valid');
                }
            } catch (\Exception $e) {
                Log::warning('Gagal generate chart: ' . $e->getMessage());
                $chartUrl = null;
            }

            // Generate PDF dengan setting khusus untuk gambar
            $pdf = PDF::loadView('admin.kms.pdf-template', [
                'anak' => $anak,
                'umurBulan' => $anak->umur_bulan,
                'chartUrl' => $chartUrl,
                'timbangan' => $anak->timbangan,
                'jenisKelamin' => $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                'chartData' => $chartData,
                'bbAnak' => $bbAnak,
                'hasChart' => !empty($chartUrl)
            ]);

            // Tambahkan setting penting untuk gambar
            $pdf->setPaper('a4', 'portrait')
                ->setOption('enable_remote', true) // Izinkan gambar remote
                ->setOption('enable_javascript', true)
                ->setOption('javascript_delay', 5000) // Beri waktu render
                ->setOption('enable_smart_shrinking', true)
                ->setOption('no-stop-slow-scripts', true);

            return $pdf->stream('kms-' . Str::slug($anak->nama_lengkap) . '.pdf');
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(400, 'ID tidak valid atau telah kadaluarsa');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Data anak tidak ditemukan');
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            abort(500, 'Gagal membuat PDF. Silakan coba lagi atau hubungi administrator.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->merge([
                'anak_id' => Crypt::decrypt($request->anak_id)
            ]);

            $request->validate([
                'anak_id' => 'required|exists:anak,id',
                'bulan' => 'required|numeric|min:0|max:24',
                'bb' => 'required|numeric|min:1|max:30',
            ]);

            $anak = Anak::find($request->anak_id);
            $kbm = StandarKms::getKbm($anak->jenis_kelamin, $request->bulan);
            $statusGizi = StandarKms::getStatusGizi($anak->jenis_kelamin, $request->bulan, $request->bb);

            AnakTimbangan::create([
                'anak_id' => $request->anak_id,
                'tanggal' => now(),
                'umur_bulan' => $request->bulan,
                'berat' => $request->bb,
                'kbm' => $kbm,
                'tinggi' => 50,
                'lingkar_kepala' => 35,
                'kategori_berat' => $this->cekKenaikanBerat($anak, $request->bb, $kbm),
                'status_gizi' => $statusGizi, // Tambahkan kolom ini
                'petugas_id' => Auth::id(),
            ]);

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Data penimbangan berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal!',
                'message' => 'Data gagal disimpan: ' . $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $anakId)
    {
        try {
            $decryptedId = Crypt::decrypt($anakId);

            $request->validate([
                'bulan' => 'required|numeric|min:0|max:24',
                'bb' => 'required|numeric|min:1|max:30',
            ]);

            $anak = Anak::findOrFail($decryptedId);
            $kbm = StandarKms::getKbm($anak->jenis_kelamin, $request->bulan);
            $statusGizi = StandarKms::getStatusGizi($anak->jenis_kelamin, $request->bulan, $request->bb);

            $timbangan = AnakTimbangan::where('anak_id', $decryptedId)
                ->where('umur_bulan', $request->bulan)
                ->firstOrFail();

            $timbangan->update([

                'berat' => $request->bb,
                'kbm' => $kbm,
                'kategori_berat' => $this->cekKenaikanBerat($anak, $request->bb, $kbm, $request->bulan),
                'status_gizi' => $statusGizi, // Tambahkan kolom ini
                'petugas_id' => Auth::id(),
            ]);
            Log::info('Berat dikirim:', ['bb' => $request->bb]);
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Data penimbangan berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal!',
                'message' => 'Data gagal diperbarui: ' . $e->getMessage()
            ]);
        }
    }

    private function cekKenaikanBerat($anak, $bbBaru, $kbm, $bulanSekarang = null)
    {
        $timbangan = $anak->timbangan;

        if ($bulanSekarang !== null) {
            // Filter penimbangan sebelumnya saja
            $timbangan = $timbangan->where('umur_bulan', '<', $bulanSekarang);
        }

        $timbanganTerakhir = $timbangan->sortByDesc('umur_bulan')->first();

        if (!$timbanganTerakhir) return 'N';

        $kenaikan = $bbBaru - $timbanganTerakhir->berat;

        return ($kenaikan >= ($kbm / 1000)) ? 'N' : 'T';
    }


    // private function isWithinMonthTolerance($currentAge, $monthToCheck)
    // {
    //     $tolerance = 0.3; // toleransi 0.3 bulan (~9 hari)
    //     return ($monthToCheck >= floor($currentAge) && $monthToCheck < ceil($currentAge + $tolerance));
    // }

    // Tambahkan method baru untuk menentukan bulan yang bisa di-edit
    private function getEditableMonths($currentAge)
    {
        $floorAge = floor($currentAge);
        $editableMonths = [$floorAge]; // Bulan saat ini

        // Jika sudah mendekati bulan berikutnya (misal 5.8 bulan), bulan ke-6 juga bisa diisi
        if ($currentAge - $floorAge > 0.7) {
            $editableMonths[] = $floorAge + 1;
        }

        return $editableMonths;
    }


    private function generateChartUrl($chartData, $bbAnak)
    {
        try {
            $client = new \GuzzleHttp\Client();

            // Konfigurasi grafik sesuai standar KMS
            $config = [
                'type' => 'line',
                'data' => [
                    'labels' => array_values($chartData['labels']),
                    'datasets' => [
                        // Garis -3SD (Merah)
                        [
                            'label' => 'Sangat Rendah (-3SD)',
                            'data' => array_values($chartData['veryLow']),
                            'borderColor' => '#e74c3c',
                            'borderWidth' => 1,
                            'borderDash' => [5, 5],
                            'pointRadius' => 0
                        ],
                        // Garis -2SD (Oranye)
                        [
                            'label' => 'Rendah (-2SD)',
                            'data' => array_values($chartData['low']),
                            'borderColor' => '#e67e22',
                            'borderWidth' => 1,
                            'borderDash' => [5, 5],
                            'pointRadius' => 0
                        ],
                        // Garis -1SD (Kuning)
                        [
                            'label' => 'Batas Bawah Normal (-1SD)',
                            'data' => array_values($chartData['normalLow']),
                            'borderColor' => '#f1c40f',
                            'borderWidth' => 1,
                            'borderDash' => [3, 3],
                            'pointRadius' => 0
                        ],
                        // Garis Median (Hijau)
                        [
                            'label' => 'Median WHO',
                            'data' => array_values($chartData['median']),
                            'borderColor' => '#2ecc71',
                            'borderWidth' => 2,
                            'pointRadius' => 0
                        ],
                        // Garis +1SD (Kuning)
                        [
                            'label' => 'Batas Atas Normal (+1SD)',
                            'data' => array_values($chartData['normalHigh']),
                            'borderColor' => '#f1c40f',
                            'borderWidth' => 1,
                            'borderDash' => [3, 3],
                            'pointRadius' => 0
                        ],
                        // Garis +2SD (Biru)
                        [
                            'label' => 'Tinggi (+2SD)',
                            'data' => array_values($chartData['high']),
                            'borderColor' => '#3498db',
                            'borderWidth' => 1,
                            'borderDash' => [5, 5],
                            'pointRadius' => 0
                        ],
                        // Garis +3SD (Ungu)
                        [
                            'label' => 'Sangat Tinggi (+3SD)',
                            'data' => array_values($chartData['veryHigh']),
                            'borderColor' => '#9b59b6',
                            'borderWidth' => 1,
                            'borderDash' => [5, 5],
                            'pointRadius' => 0
                        ],
                        // Data Berat Badan Anak
                        [
                            'label' => 'Berat Badan Anak',
                            'data' => array_values($bbAnak),
                            'borderColor' => '#000000',
                            'borderWidth' => 3,
                            'pointRadius' => 4,
                            'pointBackgroundColor' => '#000000'
                        ]
                    ]
                ],
                'options' => [
                    'responsive' => true,
                    'maintainAspectRatio' => false,
                    'scales' => [
                        'x' => [
                            'title' => [
                                'display' => true,
                                'text' => 'Umur (Bulan)',
                                'font' => ['weight' => 'bold']
                            ],
                            'grid' => [
                                'display' => true,
                                'color' => 'rgba(0,0,0,0.1)',
                                'drawBorder' => true
                            ],
                            'ticks' => [
                                'stepSize' => 1,
                                'autoSkip' => false
                            ]
                        ],
                        'y' => [
                            'title' => [
                                'display' => true,
                                'text' => 'Berat Badan (kg)',
                                'font' => ['weight' => 'bold']
                            ],
                            'min' => 0,
                            'max' => 18,
                            'grid' => [
                                'display' => true,
                                'color' => 'rgba(0,0,0,0.1)',
                                'drawBorder' => true
                            ],
                            'ticks' => [
                                'stepSize' => 1,
                                'callback' => 'function(value) { return Number.isInteger(value) ? value : ""; }'
                            ]
                        ]
                    ],
                    'plugins' => [
                        'legend' => [
                            'position' => 'bottom',
                            'labels' => [
                                'boxWidth' => 12,
                                'padding' => 20,
                                'font' => ['size' => 10]
                            ]
                        ]
                    ]
                ]
            ];

            $response = $client->post('https://quickchart.io/chart/create', [
                'json' => [
                    'chart' => $config,
                    'width' => 800,
                    'height' => 500,
                    'backgroundColor' => 'white',
                    'format' => 'png',
                    'version' => '3.8.0'
                ],
                'timeout' => 15
            ]);

            $responseData = json_decode($response->getBody(), true);

            if (!isset($responseData['url'])) {
                throw new \Exception('URL chart tidak ditemukan dalam response');
            }

            return $responseData['url'];
        } catch (\Exception $e) {
            Log::error('Gagal generate chart: ' . $e->getMessage());
            return null;
        }
    }
}
