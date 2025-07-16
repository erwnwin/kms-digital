<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Jadwal Imunisasi {{ $anak->nama_lengkap }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .bg-warning {
            background-color: #fff3cd;
        }

        .page-break {
            page-break-after: always;
        }

        /* Warna sesuai helper */
        .bg-putih {
            background-color: #FFFFFF;
        }

        .bg-kuning {
            background-color: #FFEB3B;
        }

        .bg-merah {
            background-color: #F44336;
            color: white;
        }

        .bg-abu {
            background-color: #9E9E9E;
            color: white;
        }
    </style>
</head>

<body>
    {{-- <h2 style="text-align: center;">Jadwal Imunisasi</h2> --}}
    <h3 style="text-align: center;">{{ $anak->nama_lengkap }} ({{ $anak->umur_bulan }} bulan)</h3>

    <table class="table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 25%;">Jenis Vaksin</th>
                <th colspan="16">Usia (Bulan)</th>
            </tr>
            <tr>
                @for ($i = 0; $i <= 12; $i++)
                    <th class="text-center {{ $i == $anak->umur_bulan ? 'bg-warning' : '' }}">
                        {{ $i }}
                    </th>
                @endfor
                <th class="text-center {{ 18 == $anak->umur_bulan ? 'bg-warning' : '' }}">18</th>
                <th class="text-center {{ 23 == $anak->umur_bulan ? 'bg-warning' : '' }}">23</th>
                <th class="text-center">23-39</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwalImunisasi as $imunisasi)
                <tr>
                    <td class="font-weight-bold">{{ $imunisasi->nama }}</td>

                    <!-- Kolom 0-12 -->
                    @for ($i = 0; $i <= 12; $i++)
                        @php
                            $cellColor = \App\Helpers\ImunisasiHelper::determineCellColor($imunisasi->kode, $i);
                            $isCompleted = in_array($i, $imunisasi->completedMonths ?? []);
                            $parafInfo = $imunisasi->parafData[$i] ?? null;
                        @endphp
                        <td class="text-center {{ \App\Helpers\ImunisasiHelper::getColorClass($cellColor) }}">
                            @if ($isCompleted)
                                ✓
                                @if ($parafInfo)
                                    <br><small>Dosis: {{ $parafInfo['dosis'] }}</small>
                                    <br><small>{{ \Carbon\Carbon::parse($parafInfo['tanggal'])->format('d/m/Y') }}</small>
                                @endif
                            @endif
                        </td>
                    @endfor

                    <!-- Kolom 18 -->
                    @php
                        $cellColor18 = \App\Helpers\ImunisasiHelper::determineCellColor($imunisasi->kode, 18);
                        $isCompleted18 = in_array(18, $imunisasi->completedMonths ?? []);
                        $parafInfo18 = $imunisasi->parafData[18] ?? null;
                    @endphp
                    <td class="text-center {{ \App\Helpers\ImunisasiHelper::getColorClass($cellColor18) }}">
                        @if ($isCompleted18)
                            ✓
                            @if ($parafInfo18)
                                <br><small>Dosis: {{ $parafInfo18['dosis'] }}</small>
                                <br><small>{{ \Carbon\Carbon::parse($parafInfo18['tanggal'])->format('d/m/Y') }}</small>
                            @endif
                        @endif
                    </td>

                    <!-- Kolom 23 -->
                    @php
                        $cellColor23 = \App\Helpers\ImunisasiHelper::determineCellColor($imunisasi->kode, 23);
                        $isCompleted23 = in_array(23, $imunisasi->completedMonths ?? []);
                        $parafInfo23 = $imunisasi->parafData[23] ?? null;
                    @endphp
                    <td class="text-center {{ \App\Helpers\ImunisasiHelper::getColorClass($cellColor23) }}">
                        @if ($isCompleted23)
                            ✓
                            @if ($parafInfo23)
                                <br><small>Dosis: {{ $parafInfo23['dosis'] }}</small>
                                <br><small>{{ \Carbon\Carbon::parse($parafInfo23['tanggal'])->format('d/m/Y') }}</small>
                            @endif
                        @endif
                    </td>

                    <!-- Kolom 23-39 -->
                    @php
                        $cellColor24 = \App\Helpers\ImunisasiHelper::determineCellColor($imunisasi->kode, 24);
                        $isCompleted24 = in_array(24, $imunisasi->completedMonths ?? []);
                        $parafInfo24 = $imunisasi->parafData[24] ?? null;
                    @endphp
                    <td class="text-center {{ \App\Helpers\ImunisasiHelper::getColorClass($cellColor24) }}">
                        @if ($isCompleted24)
                            ✓
                            @if ($parafInfo24)
                                <br><small>Dosis: {{ $parafInfo24['dosis'] }}</small>
                                <br><small>{{ \Carbon\Carbon::parse($parafInfo24['tanggal'])->format('d/m/Y') }}</small>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Catatan Keterangan -->
    <div style="margin-top: 20px;">
        <h4>Keterangan:</h4>
        <ul>
            <li><strong>✓</strong> : Sudah diberikan (ditandai dengan centang)</li>
            <li><span style="background-color: #FFFFFF; padding: 2px 5px;">Putih</span> : Usia tepat pemberian imunisasi
            </li>
            <li><span style="background-color: #FFEB3B; padding: 2px 5px;">Kuning</span> : Usia yang masih diperbolehkan
            </li>
            <li><span style="background-color: #F44336; color: white; padding: 2px 5px;">Merah</span> : Imunisasi kejar
            </li>
            <li><span style="background-color: #9E9E9E; color: white; padding: 2px 5px;">Abu-abu</span> : Tidak
                diperbolehkan</li>
        </ul>
    </div>
</body>

</html>
