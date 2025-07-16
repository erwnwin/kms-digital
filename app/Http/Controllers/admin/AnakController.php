<?php

namespace App\Http\Controllers\admin;

use App\Models\Anak;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class AnakController extends Controller
{
    public function index()
    {
        $anak = Anak::with('orangTua')->orderBy('nama_lengkap')->get();
        return view('admin.anak.index', compact('anak'));
    }

    public function create()
    {
        $orangTua = OrangTua::with(['user' => function ($query) {
            $query->orderBy('name');
        }])->get();
        return view('admin.anak.create', compact('orangTua'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'orang_tua_id' => 'required|exists:orang_tua,id',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'berat_lahir' => 'required|numeric|min:1|max:10',
            'panjang_lahir' => 'required|numeric|min:30|max:70',
            'anak_ke' => 'required|integer|min:1',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
        ]);

        try {
            Anak::create($validated);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data anak berhasil ditambahkan']);
            }

            return redirect()->route('anak.index')->with('success', 'Data anak berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menambahkan data anak: ' . $e->getMessage()], 500);
            }

            return back()->withInput()->with('error', 'Gagal menambahkan data anak: ' . $e->getMessage());
        }
    }

    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $anak = Anak::findOrFail($id);

            $orangTua = OrangTua::with(['user' => function ($query) {
                $query->orderBy('name');
            }])->get();

            return view('admin.anak.edit', compact('anak', 'orangTua'));
        } catch (\Exception $e) {
            abort(404, 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $anak = Anak::findOrFail($id);

            $validated = $request->validate([
                'orang_tua_id' => 'required|exists:orang_tua,id',
                'nama_lengkap' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'tanggal_lahir' => 'required|date',
                'berat_lahir' => 'required|numeric|min:1|max:10',
                'panjang_lahir' => 'required|numeric|min:30|max:70',
                'anak_ke' => 'required|integer|min:1',
                'golongan_darah' => 'nullable|in:A,B,AB,O',
            ]);

            $anak->update($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data anak berhasil diperbarui'
                ]);
            }

            return redirect()->route('anak.index')
                ->with('success', 'Data anak berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui data: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $anak = Anak::findOrFail($id);

        try {
            $anak->delete();
            return redirect()->route('anak.index')->with('success', 'Data anak berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data anak: ' . $e->getMessage());
        }
    }
}
