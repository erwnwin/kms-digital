<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\AnakTimbangan;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $years = AnakTimbangan::selectRaw('YEAR(tanggal) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->tahun ?? date('Y');
        $selectedMonth = $request->bulan ?? date('m');

        $data = $this->getReportData($selectedYear, $selectedMonth);

        return view('admin.laporan.index', compact('years', 'selectedYear', 'selectedMonth', 'data'));
    }

    public function exportPdf(Request $request)
    {
        $year = $request->tahun;
        $month = $request->bulan;

        $data = $this->getReportData($year, $month);
        $monthName = Carbon::createFromDate($year, $month, 1)->locale('id')->monthName;

        $pdf = PDF::loadView('admin.laporan.pdf', [
            'data' => $data,
            'year' => $year,
            'month' => $monthName
        ])->setPaper('a4', 'landscape');

        return $pdf->stream("laporan-timbangan-{$monthName}-{$year}.pdf");
    }

    protected function getReportData($year, $month)
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $timbangan = AnakTimbangan::with('anak')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('W'); // Group by week
            });

        // Initialize with all possible status gizi values
        $statusSummary = [
            'Sangat Kurang' => 0,
            'Gizi Kurang' => 0,
            'Gizi Baik' => 0,
            'Beresiko Lebih' => 0,
            'Gizi Lebih' => 0,
            'Obesitas' => 0,
            // Add any other possible status values here
        ];

        $totalAnak = 0;
        $totalTimbangan = 0;

        foreach ($timbangan as $week => $items) {
            foreach ($items as $item) {
                // Safely increment the status count
                if (array_key_exists($item->status_gizi, $statusSummary)) {
                    $statusSummary[$item->status_gizi]++;
                } else {
                    // Handle unexpected status values
                    $statusSummary[$item->status_gizi] = 1;
                }
                $totalTimbangan++;
            }
            $totalAnak = $items->unique('anak_id')->count();
        }

        // Filter out statuses with zero counts if desired
        $statusSummary = array_filter($statusSummary);

        return [
            'timbangan' => $timbangan,
            'statusSummary' => $statusSummary,
            'totalAnak' => $totalAnak,
            'totalTimbangan' => $totalTimbangan,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
    }
}
