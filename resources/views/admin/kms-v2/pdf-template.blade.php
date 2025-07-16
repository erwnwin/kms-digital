<!DOCTYPE html>
<html>

<head>
    <title>KMS 2 {{ $jenisKelamin }} - {{ $anak->nama_lengkap }}</title>
    <style>
        @page {
            size: A3 landscape;
            margin: 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header-title {
            font-size: 14pt;
            font-weight: bold;
        }

        .header-subtitle {
            font-size: 12pt;
        }

        .info-box {
            margin-bottom: 10px;
        }

        .chart-container {
            width: 100%;
            height: 400px;
            margin: 10px 0;
        }

        .chart-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .kms-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            page-break-inside: avoid;
        }

        .kms-table th,
        .kms-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 8pt;
            min-width: 30px;
        }

        .kms-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .kms-table .row-header {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
            width: 120px;
        }

        .merged-cell {
            background-color: #f9f9f9;
        }

        .interpretasi {
            margin-top: 15px;
            font-size: 9pt;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .footer {
            margin-top: 10px;
            font-size: 8pt;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-title">KMS 2</div>
        <div class="header-subtitle">KARTU MENUJU SEHAT (24-60 Bulan) - Untuk {{ $jenisKelamin }}</div>
    </div>

    <div class="info-box">
        <div><strong>Nama Anak:</strong> {{ $anak->nama_lengkap }}</div>
        <div><strong>Posyandu:</strong> CEMPAKA</div>
    </div>

    <div style="text-align: center; font-style: italic; margin-bottom: 5px;">
        Pantau Pertumbuhan Anak Anda Setiap Bulan<br>
        Anak Sehat, Tumbuh Optimal, Cerdas Kreatif
    </div>

    @if ($hasChart && $chartUrl)
        <div class="chart-container">
            @php
                try {
                    $imageData = file_get_contents($chartUrl);
                    if ($imageData !== false) {
                        $base64 = 'data:image/png;base64,' . base64_encode($imageData);
                        echo '<img src="' . $base64 . '" class="chart-img">';
                    } else {
                        throw new \Exception('Gagal mengambil gambar chart');
                    }
                } catch (\Exception $e) {
                    echo '<div class="alert alert-warning">Grafik tidak dapat dimuat: ' . $e->getMessage() . '</div>';
                }
            @endphp
        </div>
    @else
        <div style="border: 1px solid #ccc; padding: 10px; text-align: center;">
            Grafik tidak dapat ditampilkan. Berikut data pertumbuhan:
            <table style="width: 100%; margin-top: 10px;">
                <tr>
                    <th>Umur (Bulan)</th>
                    <th>Berat Badan (kg)</th>
                    <th>Status</th>
                </tr>
                @foreach ($bbAnak as $bulan => $berat)
                    @if (!is_null($berat))
                        <tr>
                            <td>{{ $bulan }}</td>
                            <td>{{ number_format($berat, 1) }}</td>
                            <td>
                                @php
                                    $timbangan = $anak->timbangan->firstWhere('umur_bulan', $bulan);
                                @endphp
                                {{ $timbangan ? $timbangan->kategori_berat : '-' }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    @endif

    <!-- Tabel Data Horizontal untuk KMS 2 (25-60 bulan) -->
    <div style="font-weight: bold; text-align: center; margin-bottom: 5px;">
        Pertumbuhan Berat Badan (25-60 Bulan)
    </div>

    <table class="kms-table">
        <thead>
            <tr>
                <th class="row-header">Umur (Bulan)</th>
                @for ($i = 25; $i <= 60; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            <!-- Baris Bulan Penimbangan -->
            <tr>
                <td class="row-header">Bulan Penimbangan</td>
                @for ($i = 25; $i <= 60; $i++)
                    <td>
                        @php
                            $timbangan = $anak->timbangan->firstWhere('umur_bulan', $i);
                            echo $timbangan ? date('m/Y', strtotime($timbangan->created_at)) : '';
                        @endphp
                    </td>
                @endfor
            </tr>

            <!-- Baris Berat Badan -->
            <tr>
                <td class="row-header">BB (kg)</td>
                @for ($i = 25; $i <= 60; $i++)
                    <td>
                        @php
                            $timbangan = $anak->timbangan->firstWhere('umur_bulan', $i);
                            echo $timbangan ? number_format($timbangan->berat, 1) : '';
                        @endphp
                    </td>
                @endfor
            </tr>

            <!-- Baris KBM -->
            <tr>
                <td class="row-header">KBM (gr)</td>
                @php
                    $prevKbm = null;
                    $mergeStart = 25;
                    $mergeCount = 1;
                @endphp

                @for ($i = 25; $i <= 60; $i++)
                    @php
                        $currentKbm = \App\Models\StandarKms::getKbm($anak->jenis_kelamin, $i, '24-60');

                        // $currentKbm = StandarKms::getKbm($anak->jenis_kelamin, $i, '24-60');

                        if ($currentKbm == $prevKbm) {
                            $mergeCount++;
                        } else {
                            if ($mergeCount > 1) {
                                echo '<td class="merged-cell" colspan="' . $mergeCount . '">' . $prevKbm . '</td>';
                            } elseif ($prevKbm !== null) {
                                echo '<td>' . $prevKbm . '</td>';
                            }

                            $mergeStart = $i;
                            $mergeCount = 1;
                            $prevKbm = $currentKbm;
                        }

                        // Handle last iteration
                        if ($i == 60) {
                            if ($mergeCount > 1) {
                                echo '<td class="merged-cell" colspan="' . $mergeCount . '">' . $prevKbm . '</td>';
                            } elseif ($prevKbm !== null) {
                                echo '<td>' . $prevKbm . '</td>';
                            }
                        }
                    @endphp
                @endfor
            </tr>

            <!-- Baris N/T -->
            <tr>
                <td class="row-header">N/T</td>
                @for ($i = 25; $i <= 60; $i++)
                    <td>
                        @php
                            $timbangan = $anak->timbangan->firstWhere('umur_bulan', $i);
                            echo $timbangan ? $timbangan->kategori_berat : '';
                        @endphp
                    </td>
                @endfor
            </tr>
        </tbody>
    </table>

    <div class="interpretasi">
        <div><strong>Interpretasi Grafik:</strong></div>
        <div><strong>NAIK (N):</strong> Grafik BB mengikuti garis pertumbuhan atau Berat Badan Sama dengan KBM (Kenaikan
            Berat Badan Minimal) atau lebih</div>
        <div><strong>TIDAK NAIK (T):</strong> Grafik BB mendatar atau menurun memotong garis pertumbuhan di bawahnya
            atau Berat Badan kurang dari KBM</div>
    </div>

    <div class="interpretasi" style="border-top: none; padding-top: 0;">
        <div><strong>Rujuk Bila:</strong></div>
        <div>- Berat Badan Anak Tidak Naik (T)</div>
        <div>- Di Bawah Garis Merah (-3SD)</div>
        <div>- Di Atas Garis Biru (+2SD)</div>
    </div>

    <div class="footer">
        Kader kesehatan melakukan plotting hasil penimbangan, ME kepada ibu dan rujukan ke petugas kesehatan.<br>
        Petugas kesehatan memastikan plotting hasil penimbangan dan menindaklanjuti segera sesuai Permenkes Standar
        Antropometri Anak.<br>
        Dicetak pada {{ date('d/m/Y H:i') }}
    </div>
</body>

</html>
