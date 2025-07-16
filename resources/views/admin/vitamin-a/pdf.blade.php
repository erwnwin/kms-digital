<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekam Medis Vitamin A - {{ $anak->nama_lengkap }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header img {
            height: 70px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 12px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .bg-success {
            background-color: #28a745;
            color: white;
        }

        .bg-info {
            background-color: #17a2b8;
            color: white;
        }

        .bg-danger {
            background-color: #dc3545;
            color: white;
        }

        .bg-gray {
            background-color: #aeb3af;
        }

        .table-active {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
        }

        .signature {
            margin-top: 40px;
        }

        .keterangan {
            font-size: 11px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">REKAM MEDIS PEMBERIAN VITAMIN A DAN OBAT CACING</div>
        <div class="subtitle">POSYANDU TERPADU TAHUN {{ $currentYear }}</div>
    </div>

    <table>
        <tr>
            <td width="20%">Nama Anak</td>
            <td width="30%"><strong>{{ $anak->nama_lengkap }}</strong></td>
            <td width="20%">Umur</td>
            <td width="30%"><strong>{{ round($anak->umur_bulan) }} bulan</strong></td>
        </tr>
        <tr>
            <td>Nama Orang Tua</td>
            <td><strong>{{ $anak->orangtua->nama_ibu ?? '-' }}</strong></td>
            <td>Alamat</td>
            <td><strong>{{ $anak->alamat ?? '-' }}</strong></td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th rowspan="3" class="align-middle bg-success" style="width: 20%">Usia</th>
                <th colspan="3" class="bg-success">Kapsul Vitamin A</th>
                <th rowspan="3" class="align-middle bg-success">Obat Cacing</th>
            </tr>
            <tr>
                <th class="bg-info">Kapsul Biru<br>(100.000 IU)</th>
                <th colspan="2" class="bg-danger">Kapsul Merah<br>(200.000 IU)</th>
            </tr>
            <tr>
                <th class="bg-info">Februari atau Agustus</th>
                <th class="bg-danger">Februari</th>
                <th class="bg-danger">Agustus</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ageGroups as $index => $group)
                @php
                    $isActive = $usiaBulan >= $group['min'] && $usiaBulan <= $group['max'];

                    // Tentukan eligibility
                    $eligibleBiru = $group['min'] == 6 && $group['max'] == 11;
                    $eligibleMerah = $group['min'] >= 12 && $group['max'] <= 59;
                    $eligibleCacing = $group['min'] >= 12 && $group['max'] <= 71;

                    // Warna sel
                    $biruColor = $eligibleBiru ? '#ffffff' : '#aeb3af';
                    $merahFebColor = $eligibleMerah && $index != 0 && $index != 5 ? '#ffffff' : '#aeb3af';
                    $merahAugColor = $eligibleMerah && $index != 0 && $index != 5 ? '#ffffff' : '#aeb3af';
                    $cacingColor = $eligibleCacing && $index != 0 ? '#ffffff' : '#aeb3af';

                    // Cek data
                    $hasBiru = $eligibleBiru ? $anak->hasVitaminA('biru', $group['min'], $group['max']) : false;
                    $hasMerahFeb = $eligibleMerah
                        ? $anak->hasVitaminA('merah', $group['min'], $group['max'], 'feb')
                        : false;
                    $hasMerahAug = $eligibleMerah
                        ? $anak->hasVitaminA('merah', $group['min'], $group['max'], 'aug')
                        : false;
                    $hasCacing = $eligibleCacing ? $anak->hasObatCacing($group['min'], $group['max']) : false;
                @endphp

                <tr class="{{ $isActive ? 'table-active' : '' }}">
                    <td>{{ $group['label'] }}</td>

                    <!-- Kapsul Biru -->
                    <td style="background-color: {{ $biruColor }};">
                        @if ($eligibleBiru && $hasBiru)
                            ✓
                        @endif
                    </td>

                    <!-- Kapsul Merah Februari -->
                    <td style="background-color: {{ $merahFebColor }};">
                        @if ($eligibleMerah && $index != 0 && $index != 5 && $hasMerahFeb)
                            ✓
                        @endif
                    </td>

                    <!-- Kapsul Merah Agustus -->
                    <td style="background-color: {{ $merahAugColor }};">
                        @if ($eligibleMerah && $index != 0 && $index != 5 && $hasMerahAug)
                            ✓
                        @endif
                    </td>

                    <!-- Obat Cacing -->
                    <td style="background-color: {{ $cacingColor }};">
                        @if ($eligibleCacing && $index != 0 && $hasCacing)
                            ✓
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="keterangan">
        <p><strong>Keterangan:</strong></p>
        <ul>
            <li>✓ : Sudah diberikan</li>
            <li>Kolom abu-abu : Tidak termasuk kelompok usia</li>
        </ul>
    </div>

    <div class="riwayat">
        <h4>Riwayat Pemberian:</h4>
        <table>
            <thead>
                <tr>
                    <th width="15%">Tanggal</th>
                    <th width="25%">Jenis</th>
                    <th width="20%">Dosis</th>
                    <th width="30%">Keterangan</th>
                    <th width="10%">Paraf</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anak->vitamin as $v)
                    <tr>
                        <td>{{ $v->tanggal->format('d/m/Y') }}</td>
                        <td>
                            @if ($v->jenis == 'Vitamin A')
                                Vitamin A Kapsul {{ ucfirst($v->warna) }}
                            @else
                                Obat Cacing
                            @endif
                        </td>
                        <td>{{ $v->dosis }}</td>
                        <td>{{ $v->keterangan ?? '-' }}</td>
                        <td>✓</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada riwayat pemberian</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="signature">
        <div style="float: right; width: 200px; text-align: center;">
            <p>Mengetahui,</p>
            <p>Petugas Posyandu</p>
            <br><br><br>
            <p>(___________________)</p>
            <p>NIP/NIK: ........................</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }} oleh {{ auth()->user()->name ?? 'Sistem' }}
    </div>
</body>

</html>
