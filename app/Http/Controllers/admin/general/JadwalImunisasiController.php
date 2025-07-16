<?php

namespace App\Http\Controllers\admin\general;

use App\Http\Controllers\Controller;
use App\Models\JadwalImunisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class JadwalImunisasiController extends Controller
{
    public function index()
    {
        $jadwals = JadwalImunisasi::orderBy('start_date')->get();
        return view('general.jadwal_imunisasi.index', compact('jadwals'));
    }

    public function create()
    {
        return view('general.jadwal_imunisasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'day' => 'nullable|string|max:20',
            'category' => 'required|string|max:50',
            'is_active' => 'boolean'
        ]);

        try {
            JadwalImunisasi::create($validated);
            return redirect()->route('jadwal-imunisasi')
                ->with('success', 'Jadwal imunisasi berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menambahkan jadwal: ' . $e->getMessage());
        }
    }

    public function show($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $jadwal = JadwalImunisasi::findOrFail($id);
            return view('general.jadwal_imunisasi.show', compact('jadwal'));
        } catch (\Exception $e) {
            abort(404, 'Jadwal tidak ditemukan');
        }
    }

    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $jadwal = JadwalImunisasi::findOrFail($id);
            return view('general.jadwal_imunisasi.edit', compact('jadwal'));
        } catch (\Exception $e) {
            abort(404, 'Jadwal tidak ditemukan');
        }
    }


    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $jadwal = JadwalImunisasi::findOrFail($id);

            $validated = $request->validate([
                'type' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i|after:start_time',
                'location' => 'required|string|max:255',
                'day' => 'nullable|string|max:20',
                'category' => 'required|string|max:50',
                'is_active' => 'boolean'
            ]);

            $jadwal->update($validated);

            return redirect()->route('jadwal-imunisasi')
                ->with('success', 'Jadwal imunisasi berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui jadwal: ' . $e->getMessage());
        }
    }

    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $jadwal = JadwalImunisasi::findOrFail($id);
            $jadwal->delete();

            return redirect()->route('jadwal-imunisasi')
                ->with('success', 'Jadwal imunisasi berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }
}
