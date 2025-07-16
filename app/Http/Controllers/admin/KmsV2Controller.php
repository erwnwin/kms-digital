<?php

namespace App\Http\Controllers\admin;

use App\Models\Anak;
use App\Models\StandarKms;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;

class KmsV2Controller extends Controller
{
    //
    // public function index()
    // {
    //     $anak = Anak::with(['orangTua.user', 'timbangan'])
    //         ->orderBy('nama_lengkap')
    //         ->paginate(10);
    //     return view('admin.kms2.index', compact('anak'));
    // }


    public function show($encryptedId)
    {
        try {
            $anakId = Crypt::decrypt($encryptedId);
            $anak = Anak::with(['timbangan' => function ($query) {
                $query->where('umur_bulan', '>', 24) // Hanya ambil data >24 bulan
                    ->where('umur_bulan', '<=', 60)
                    ->orderBy('umur_bulan');
            }])->findOrFail($anakId);

            $umurBulan = $anak->umur_bulan;

            // Hanya tampilkan bulan >24 yang bisa diisi
            $editableMonths = array_filter($this->getEditableMonths($umurBulan), function ($month) {
                return $month > 24;
            });

            // Ambil data standar pertumbuhan KMS 2 (24-60 bulan)
            $standarPertumbuhan = StandarKms::where('jenis_kelamin', $anak->jenis_kelamin)
                ->where('umur_bulan', '>', 24)
                ->where('umur_bulan', '<=', 60)
                ->where('kategori', '24-60') // Pastikan hanya ambil standar KMS 2
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

            // Data untuk tabel (25-60 bulan)
            $tabelBulanan = [];
            for ($i = 25; $i <= 60; $i++) {
                $timbangan = $anak->timbangan->firstWhere('umur_bulan', $i);
                $tabelBulanan[] = [
                    'bulan' => $i,
                    'bb' => $timbangan ? $timbangan->berat : null,
                    'kbm' => StandarKms::getKbm($anak->jenis_kelamin, $i, '24-60'),
                    'status' => $timbangan ? $timbangan->kategori_berat : null,
                    'editable' => in_array($i, $editableMonths)
                ];
            }

            return view('admin.kms-v2.show', [
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

    private function cekKenaikanBerat($anak, $bbBaru, $kbm)
    {
        $timbanganTerakhir = $anak->timbangan->sortByDesc('umur_bulan')->first();

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

            // Get child data with eager loading (hanya data >24 bulan)
            $anak = Anak::with(['timbangan' => function ($query) {
                $query->where('umur_bulan', '>', 24)
                    ->where('umur_bulan', '<=', 60)
                    ->orderBy('umur_bulan', 'asc');
            }])->findOrFail($anakId);

            // Validasi data anak
            if (empty($anak->jenis_kelamin)) {
                throw new \Exception('Data jenis kelamin anak tidak valid');
            }

            // Get growth standards for KMS 2 (24-60 bulan)
            $standarPertumbuhan = StandarKms::where('jenis_kelamin', $anak->jenis_kelamin)
                ->where('umur_bulan', '>', 24)
                ->where('umur_bulan', '<=', 60)
                ->where('kategori', '24-60') // Pastikan hanya ambil standar KMS 2
                ->orderBy('umur_bulan')
                ->get();

            if ($standarPertumbuhan->isEmpty()) {
                throw new \Exception('Tidak ada data standar pertumbuhan KMS 2 yang tersedia');
            }

            // Siapkan data chart dengan validasi
            $chartData = [
                'labels' => $standarPertumbuhan->pluck('umur_bulan')->toArray(),
                'veryLow' => $standarPertumbuhan->pluck('berat_minimal')->toArray(),
                'low' => $standarPertumbuhan->pluck('berat_minimal_2sd')->toArray(),
                'normalLow' => $standarPertumbuhan->pluck('berat_minimal_1sd')->toArray(),
                'median' => $standarPertumbuhan->pluck('berat_ideal')->toArray(),
                'normalHigh' => $standarPertumbuhan->pluck('berat_maksimal_1sd')->toArray(),
                'high' => $standarPertumbuhan->pluck('berat_maksimal_2sd')->toArray(),
                'veryHigh' => $standarPertumbuhan->pluck('berat_maksimal')->toArray()
            ];

            // Validasi data chart
            foreach ($chartData as $key => $values) {
                if (empty($values) || !is_array($values)) {
                    throw new \Exception("Data chart $key tidak valid");
                }
            }

            // Siapkan data berat badan anak (25-60 bulan)
            $bbAnak = array_fill(25, 36, null); // 25-60 bulan = 36 elemen
            foreach ($anak->timbangan as $timbangan) {
                $bulan = (int)$timbangan->umur_bulan;
                if ($bulan >= 25 && $bulan <= 60) {
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
            $pdf = PDF::loadView('admin.kms-v2.pdf-template', [
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
                ->setOption('enable_remote', true)
                ->setOption('enable_javascript', true)
                ->setOption('javascript_delay', 5000)
                ->setOption('enable_smart_shrinking', true)
                ->setOption('no-stop-slow-scripts', true);

            return $pdf->stream('kms2-' . Str::slug($anak->nama_lengkap) . '.pdf');
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(400, 'ID tidak valid atau telah kadaluarsa');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Data anak tidak ditemukan');
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            abort(500, 'Gagal membuat PDF. Silakan coba lagi atau hubungi administrator.');
        }
    }

    private function generateChartUrl($chartData, $bbAnak)
    {
        try {
            $client = new \GuzzleHttp\Client();

            // Konfigurasi grafik khusus KMS 2 (rentang 25-60 bulan)
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
                            'min' => 25,
                            'max' => 60,
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
                            'min' => 5,  // Nilai minimal lebih tinggi untuk KMS 2
                            'max' => 25, // Nilai maksimal lebih tinggi untuk KMS 2
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
