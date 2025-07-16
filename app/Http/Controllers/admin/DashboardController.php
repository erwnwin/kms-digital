<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Anak;
use App\Models\OrangTua;
use App\Models\AnakTimbangan;
use App\Models\JadwalImunisasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isKordinator()) {
            return $this->kordinatorDashboard();
        } elseif ($user->isKader()) {
            return $this->kaderDashboard();
        } elseif ($user->isOrangTua()) {
            return $this->orangTuaDashboard();
        }

        abort(403, 'Unauthorized');
    }

    protected function kordinatorDashboard()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalAnak' => Anak::count(),
            'totalKader' => User::where('role', 'kader')->count(),
            'totalPosyandu' => 5, // Ganti dengan query sesuai kebutuhan
            'jadwalImunisasi' => JadwalImunisasi::where('start_date', '>=', now())
                ->orderBy('start_date')
                ->take(5)
                ->get(),
            'recentActivities' => $this->getRecentActivities(5)
        ];

        return view('admin.dashboard.dashboard', $data);
    }

    protected function kaderDashboard()
    {
        $anakBinaan = Anak::whereHas('timbangan', function ($q) {
            $q->where('petugas_id', Auth::id());
        })->count();

        $data = [
            'anakBinaan' => $anakBinaan,
            'penimbanganBulanIni' => AnakTimbangan::where('petugas_id', Auth::id())
                ->whereMonth('tanggal', now()->month)
                ->count(),
            'imunisasiBulanIni' => 15, // Ganti dengan query sesuai kebutuhan
            'perluTindakLanjut' => Anak::whereHas('timbangan', function ($q) {
                $q->where('status_gizi', 'Gizi Kurang')
                    ->orWhere('status_gizi', 'Gizi Buruk');
            })->count(),
            'anakPerluTimbang' => Anak::whereDoesntHave('timbangan', function ($q) {
                $q->whereMonth('tanggal', now()->month);
            })->take(5)->get(),
            // 'anakPerluImunisasi' => Anak::with('imunisasi_dibutuhkan')->take(5)->get()
        ];

        return view('admin.dashboard.dashboard', $data);
    }

    protected function orangTuaDashboard()
    {
        $orangTua = OrangTua::where('user_id', Auth::id())->first();

        if (!$orangTua) {
            abort(404, 'Data orang tua tidak ditemukan');
        }

        $anak = $orangTua->anak()->with(['timbangan' => function ($q) {
            $q->orderBy('tanggal', 'desc');
        }])->get();

        $lastTimbangan = $anak->flatMap(function ($child) {
            return $child->timbangan;
        })->sortByDesc('tanggal')->first();

        $data = [
            'totalAnak' => $anak->count(),
            'lastTimbangan' => $lastTimbangan ? $lastTimbangan->tanggal : null,
            'nextImunisasi' => now()->addMonth(), // Ganti dengan query sesuai kebutuhan
            'nextPosyandu' => now()->addMonth(), // Ganti dengan query sesuai kebutuhan
            'anak' => $anak,
            'jadwalImunisasiAnak' => [] // Ganti dengan query sesuai kebutuhan
        ];

        return view('admin.dashboard.dashboard', $data);
    }

    protected function getRecentActivities($limit = 5)
    {
        // Implementasi sesuai kebutuhan
        return collect([
            (object)['description' => 'User baru mendaftar', 'created_at' => now()->subMinutes(15)],
            (object)['description' => 'Data anak baru ditambahkan', 'created_at' => now()->subHours(2)],
            (object)['description' => 'Penimbangan bulanan dilakukan', 'created_at' => now()->subDays(1)],
            (object)['description' => 'Imunisasi campak diberikan', 'created_at' => now()->subDays(3)],
            (object)['description' => 'Laporan bulanan dibuat', 'created_at' => now()->subWeeks(1)],
        ])->take($limit);
    }
}
