<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Timbangan Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            padding: 0;
        }

        .header p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .summary-table {
            width: 60%;
            margin-bottom: 30px;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 12px;
            color: white;
            font-weight: bold;
        }

        .bg-success {
            background-color: #4CAF50;
        }

        .bg-warning {
            background-color: #FFC107;
        }

        .bg-danger {
            background-color: #F44336;
        }

        .bg-info {
            background-color: #2196F3;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN TIMBANGAN BULANAN</h2>
        <p>Posyandu Terpadu</p>
        <p>Bulan: {{ $month }} {{ $year }}</p>
    </div>

    <h3>Rekapitulasi Status Gizi</h3>
    <table class="table summary-table">
        <thead>
            <tr>
                <th>Status Gizi</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $total = array_sum($data['statusSummary']) @endphp
            @foreach ($data['statusSummary'] as $status => $count)
                <tr>
                    <td>{{ $status }}</td>
                    <td>{{ $count }}</td>
                    <td>{{ $total > 0 ? round(($count / $total) * 100, 2) : 0 }}%</td>
                </tr>
            @endforeach
            <tr style="background-color: #f2f2f2;">
                <td><strong>Total</strong></td>
                <td><strong>{{ $total }}</strong></td>
                <td><strong>100%</strong></td>
            </tr>
        </tbody>
    </table>

    <h3>Detail Timbangan Per Minggu</h3>
    <p>Periode: {{ $data['startDate']->format('d F Y') }} - {{ $data['endDate']->format('d F Y') }}</p>

    @foreach ($data['timbangan'] as $week => $items)
        <h4>Minggu ke-{{ $week }}</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anak</th>
                    <th>Umur (Bulan)</th>
                    <th>Tanggal Timbang</th>
                    <th>Berat (kg)</th>
                    <th>Tinggi (cm)</th>
                    <th>Status Gizi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->anak->nama_lengkap }}</td>
                        <td>{{ $item->umur_bulan }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item->berat }}</td>
                        <td>{{ $item->tinggi }}</td>
                        <td>
                            <span
                                class="badge 
                            @if ($item->status_gizi == 'Gizi Baik') bg-success
                            @elseif($item->status_gizi == 'Gizi Kurang') bg-warning
                            @elseif($item->status_gizi == 'Gizi Buruk') bg-danger
                            @else bg-info @endif">
                                {{ $item->status_gizi }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
