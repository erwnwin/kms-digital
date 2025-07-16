<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use App\Models\JadwalImunisasi;
use App\Models\KontakPesan;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil jadwal rutin (Senin-Kamis, Jumat, Sabtu)
        $regularSchedules = JadwalImunisasi::where('type', 'regular')
            ->active()
            ->orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->get()
            ->groupBy(function ($item) {
                // Group jadwal Senin-Kamis bersama
                if (in_array($item->day, ['Senin', 'Selasa', 'Rabu', 'Kamis'])) {
                    return 'Senin-Kamis';
                }
                return $item->day;
            });

        // Ambil jadwal khusus bulan ini
        $specialSchedules = JadwalImunisasi::where('type', 'special')
            ->whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->active()
            ->orderBy('start_date')
            ->get();

        // Ambil FAQ aktif
        $faqs = Faq::active()->ordered()->get();

        // Ambil info kontak
        $contactInfo = ContactInfo::first();

        return view('home', [
            'regularSchedules' => $regularSchedules,
            'specialSchedules' => $specialSchedules,
            'faqs' => $faqs,
            'contactInfo' => $contactInfo
        ]);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        KontakPesan::create($validated);

        return back()->with('success', 'Pesan Anda telah terkirim. Terima kasih!');
    }
}
