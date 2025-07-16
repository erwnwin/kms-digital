<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class OrangTuaController extends Controller
{
    //
    public function index()
    {
        $orangTua = OrangTua::with(['user', 'anak'])->get();
        return view('admin.orang-tua.index', compact('orangTua'));
    }

    public function create()
    {
        return view('admin.orang-tua.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
            'desa_kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'orang_tua'
        ]);

        // Create orang tua
        OrangTua::create([
            'user_id' => $user->id,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'desa_kelurahan' => $request->desa_kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'provinsi' => $request->provinsi,
        ]);

        return redirect()->route('orang-tua.index')->with('success', 'Data orang tua berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $orangTua = OrangTua::with('user')->findOrFail($id);
        return view('admin.orang-tua.edit', compact('orangTua'));
    }

    public function update(Request $request, $id)
    {
        $orangTua = OrangTua::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $orangTua->user_id,
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
            'desa_kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
        ]);

        // Update user
        $orangTua->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update orang tua
        $orangTua->update($request->except(['name', 'email']));

        return redirect()->route('orang-tua.index')->with('success', 'Data orang tua berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $orangTua = OrangTua::findOrFail($id);
        $user = $orangTua->user;

        // Hapus anak terlebih dahulu jika ada
        $orangTua->anak()->delete();

        // Hapus orang tua
        $orangTua->delete();

        // Hapus user
        $user->delete();

        return response()->json(['success' => 'Data orang tua berhasil dihapus.']);
    }

    public function getWilayah(Request $request)
    {
        $request->validate([
            'type' => 'required|in:provinsi,kabupaten,kecamatan,kelurahan',
            'parent' => 'nullable|string',
            'search' => 'nullable|string'
        ]);

        $type = $request->type;
        $parent = $request->parent;
        $search = $request->search;

        $query = DB::table('wilayah');

        // Untuk pencarian provinsi (menampilkan semua Sulawesi)
        if ($type === 'provinsi') {
            $query->select('provinsi as id', 'provinsi as text')
                ->when($search, function ($q) use ($search) {
                    return $q->where('provinsi', 'like', "%$search%");
                })
                ->groupBy('provinsi');
        }
        // Untuk wilayah hierarkis
        else {
            $query->where(
                $type === 'kabupaten' ? 'provinsi' : ($type === 'kecamatan' ? 'kabupaten' : 'kecamatan'),
                $parent
            )
                ->select($type . ' as id', $type . ' as text')
                ->when($search, function ($q) use ($type, $search) {
                    return $q->where($type, 'like', "%$search%");
                })
                ->groupBy($type);
        }

        return response()->json($query->orderBy('text')->get());
    }
}
