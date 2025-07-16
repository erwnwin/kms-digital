<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KMS - Kartu Menuju Sehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .kms-card {
            border: 2px solid #0056b3;
            border-radius: 10px;
            max-width: 800px;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .kms-header {
            background-color: #0056b3;
            color: white;
            padding: 15px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            text-align: center;
        }

        .kms-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .kms-subtitle {
            font-size: 16px;
        }

        .kms-body {
            padding: 20px;
        }

        .chart-container {
            position: relative;
            height: 400px;
            margin-bottom: 20px;
        }

        .table-title {
            background-color: #f0f8ff;
            padding: 8px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }

        .table-custom {
            margin-bottom: 20px;
        }

        .table-custom th {
            background-color: #e9f5ff;
            text-align: center;
            vertical-align: middle;
        }

        .footer-note {
            font-size: 12px;
            margin-top: 20px;
            color: #555;
        }

        .legend-item {
            display: inline-block;
            margin-right: 15px;
            font-size: 12px;
        }

        .legend-color {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 5px;
            vertical-align: middle;
        }

        .table-custom td {
            text-align: center;
            vertical-align: middle;
        }

        .table-custom input[type="checkbox"] {
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="kms-card">
            <div class="kms-header">
                <div class="kms-title">KMS</div>
                <div class="kms-subtitle">KARTU MENUJU SEHAT - Untuk Laki-laki</div>
            </div>

            <div class="kms-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Nama Anak: <span class="text-primary">CHAISAN PAPRAFYA HOPIO</span></h5>
                    </div>
                    <div class="col-md-6">
                        <h5>Alamat: <span class="text-primary">CEMPAKA</span></h5>
                    </div>
                </div>

                <div class="alert alert-info">
                    <strong>Timbanglah Anak Anda Setiap Bulan</strong><br>
                    Anak Sehat, Tambah Umur Tambah Berat, Tambah Pandai
                </div>

                <div class="chart-container">
                    <canvas id="growthChart" height="600"></canvas>
                </div>

                <div class="text-center mb-3">
                    <div class="legend-item"><span class="legend-color" style="background-color: #e74c3c;"></span>Garis
                        Merah (BB sangat rendah)</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #e67e22;"></span>Garis
                        Oranye (BB rendah)</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #2ecc71;"></span>Garis
                        Hijau (BB normal)</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #3498db;"></span>Garis
                        Biru
                        (BB di atas normal)</div>
                </div>

                <div class="table-title">Pertumbuhan Berat Badan</div>

                <div class="table-responsive">
                    <table class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>Bulan<br>Penimbangan</th>
                                <th>BB<br>(kg)</th>
                                <th>KBM<br>(gr)</th>
                                <th>N/T</th>
                                <th colspan="2">ASI<br>Eksklusif</th>
                                <th>NAIK<br>(N)</th>
                                <th>TIDAK NAIK<br>(T)</th>
                            </tr>
                            <tr>
                                <th>Umur (Bulan)</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Ya</th>
                                <th>Tidak</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows for months 1-24 -->
                            <tr>
                                <td>0</td>
                                <td><input type="text" class="form-control form-control-sm" value="3.2"></td>
                                <td>-</td>
                                <td>N</td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td><input type="text" class="form-control form-control-sm" value="3.2"></td>
                                <td>-</td>
                                <td>N</td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><input type="text" class="form-control form-control-sm" value="4.1"></td>
                                <td>800</td>
                                <td>N</td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><input type="text" class="form-control form-control-sm" value="5.0"></td>
                                <td>800</td>
                                <td>N</td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><input type="text" class="form-control form-control-sm" value="5.7"></td>
                                <td>800</td>
                                <td>N</td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><input type="text" class="form-control form-control-sm" value="6.3"></td>
                                <td>800</td>
                                <td>N</td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><input type="text" class="form-control form-control-sm" value="6.8"></td>
                                <td>800</td>
                                <td>N</td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox" checked></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <!-- Continue rows for months 7-24 -->
                            <tr>
                                <td>7</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>18</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>19</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>20</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>21</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>22</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>23</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                            <tr>
                                <td>24</td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                                <td><input type="checkbox"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-warning">
                    <strong>Interpretasi Grafik:</strong><br>
                    <strong>NAIK (N):</strong> Grafik BB mengikuti garis pertumbuhan atau Berat Badan Sama dengan KBM
                    (Kenaikan Berat Badan Minimal) atau lebih<br>
                    <strong>TIDAK NAIK (T):</strong> Grafik BB mendatar atau menurun memotong garis pertumbuhan di
                    bawahnya atau Berat Badan kurang dari KBM<br>
                    <small>KBM digunakan bila ada keraguan menginterpretasikan arah kurva pertumbuhan</small>
                </div>

                <div class="alert alert-danger">
                    <strong>Rujuk Bila:</strong><br>
                    - Berat Badan Anak Tidak Naik (T)<br>
                    - Di Bawah Garis Merah<br>
                    - Di Atas Garis Oranye
                </div>

                <div class="footer-note">
                    <p>Kader kesehatan melakukan plotting hasil penimbangan, ME kepada ibu dan rujukan ke petugas
                        kesehatan.<br>
                        Petugas kesehatan memastikan plotting hasil penimbangan dan menindaklanjuti segera sesuai
                        Permenkes Standar Antropometri Anak.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Growth Chart Configuration with detailed y-axis
        const ctx = document.getElementById('growthChart').getContext('2d');

        // WHO Growth Standards Data for Boys (0-24 months)
        const labels = Array.from({
            length: 25
        }, (_, i) => i); // 0-24 months

        // WHO standard lines (7 lines)
        const whoStandards = {
            veryLow: [2.1, 2.9, 3.8, 4.4, 4.9, 5.3, 5.7, 6.0, 6.3, 6.5, 6.7, 6.9, 7.0, 7.2, 7.3, 7.5, 7.6, 7.8, 7.9,
                8.1, 8.2, 8.4, 8.5, 8.6, 8.8
            ],
            low: [2.5, 3.4, 4.3, 5.0, 5.6, 6.0, 6.4, 6.7, 6.9, 7.1, 7.4, 7.6, 7.7, 7.9, 8.1, 8.3, 8.4, 8.6, 8.8, 8.9,
                9.1, 9.2, 9.4, 9.5, 9.7
            ],
            normalLow: [2.9, 3.9, 4.9, 5.7, 6.2, 6.7, 7.1, 7.4, 7.7, 8.0, 8.2, 8.4, 8.6, 8.8, 9.0, 9.2, 9.4, 9.6, 9.8,
                10.0, 10.1, 10.3, 10.5, 10.7, 10.8
            ],
            median: [3.3, 4.5, 5.6, 6.4, 7.0, 7.5, 7.9, 8.3, 8.6, 8.9, 9.2, 9.4, 9.6, 9.9, 10.1, 10.3, 10.5, 10.7, 10.9,
                11.1, 11.3, 11.5, 11.8, 12.0, 12.2
            ],
            normalHigh: [3.9, 5.1, 6.3, 7.2, 7.8, 8.4, 8.8, 9.2, 9.6, 9.9, 10.2, 10.5, 10.8, 11.0, 11.3, 11.5, 11.8,
                12.0, 12.3, 12.5, 12.8, 13.0, 13.3, 13.5, 13.7
            ],
            high: [4.4, 5.8, 7.1, 8.0, 8.7, 9.3, 9.8, 10.3, 10.7, 11.0, 11.4, 11.7, 12.0, 12.3, 12.6, 12.9, 13.1, 13.4,
                13.7, 14.0, 14.3, 14.6, 14.9, 15.2, 15.4
            ],
            veryHigh: [5.0, 6.6, 8.0, 9.0, 9.8, 10.5, 11.0, 11.5, 12.0, 12.4, 12.8, 13.1, 13.5, 13.8, 14.1, 14.5, 14.8,
                15.1, 15.4, 15.7, 16.0, 16.4, 16.7, 17.0, 17.3
            ]
        };

        // Sample child data (from the table)
        const childData = [3.2, 4.1, 5.0, 5.7, 6.3, 6.8, null, null, null, null, null, null, null, null, null, null, null,
            null, null, null, null, null, null, null, null
        ];

        const growthChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    // WHO Standard Lines
                    {
                        label: 'Sangat Rendah (Garis Merah)',
                        data: whoStandards.veryLow,
                        borderColor: '#e74c3c',
                        backgroundColor: 'rgba(231, 76, 60, 0.1)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: false,
                        pointRadius: 0
                    },
                    {
                        label: 'Rendah (Garis Oranye)',
                        data: whoStandards.low,
                        borderColor: '#e67e22',
                        backgroundColor: 'rgba(230, 126, 34, 0.1)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: false,
                        pointRadius: 0
                    },
                    {
                        label: 'Batas Bawah Normal',
                        data: whoStandards.normalLow,
                        borderColor: '#2ecc71',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        borderWidth: 1,
                        borderDash: [3, 3],
                        fill: false,
                        pointRadius: 0
                    },
                    {
                        label: 'Median WHO',
                        data: whoStandards.median,
                        borderColor: '#2ecc71',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        borderWidth: 2,
                        fill: false,
                        pointRadius: 0
                    },
                    {
                        label: 'Batas Atas Normal',
                        data: whoStandards.normalHigh,
                        borderColor: '#2ecc71',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        borderWidth: 1,
                        borderDash: [3, 3],
                        fill: false,
                        pointRadius: 0
                    },
                    {
                        label: 'Tinggi (Garis Biru)',
                        data: whoStandards.high,
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: false,
                        pointRadius: 0
                    },
                    {
                        label: 'Sangat Tinggi',
                        data: whoStandards.veryHigh,
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: false,
                        pointRadius: 0
                    },
                    // Child's actual data
                    {
                        label: 'Berat Badan Anak',
                        data: childData,
                        borderColor: '#000000',
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        borderWidth: 3,
                        pointRadius: 5,
                        pointBackgroundColor: '#000000',
                        pointHoverRadius: 7,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Umur (Bulan)',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            display: true
                        },
                        ticks: {
                            stepSize: 1,
                            autoSkip: false
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Berat Badan (kg)',
                            font: {
                                weight: 'bold'
                            }
                        },
                        min: 0,
                        max: 18,
                        ticks: {
                            stepSize: 1, // Interval 1 kg
                            callback: function(value) {
                                // Tampilkan semua angka integer dari 1-18
                                return Number.isInteger(value) ? value : '';
                            },
                            autoSkip: false, // Nonaktifkan skip otomatis
                            maxTicksLimit: 20, // Maksimal ticks yang ditampilkan
                            font: {
                                size: 10 // Ukuran font lebih kecil
                            }

                        },
                        grid: {
                            color: function(context) {
                                // Garis grid untuk setiap kg
                                return 'rgba(0, 0, 0, 0.1)';
                            },
                            lineWidth: 1,
                            drawBorder: true
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 20,
                            font: {
                                size: 10
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y.toFixed(1) + ' kg';
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
