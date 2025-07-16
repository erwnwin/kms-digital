<?php

namespace App\Http\Controllers\admin\general;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profileData = [];

        if ($user->role === 'orang_tua' && $user->orangTua) {
            $profileData = [
                'alamat' => $user->orangTua->alamat,
                'rt' => $user->orangTua->rt,
                'rw' => $user->orangTua->rw,
                'desa_kelurahan' => $user->orangTua->desa_kelurahan,
                'kecamatan' => $user->orangTua->kecamatan,
                'kabupaten_kota' => $user->orangTua->kabupaten_kota,
                'provinsi' => $user->orangTua->provinsi,
            ];
        }

        return view('general.profil.index', [
            'user' => $user,
            'profileData' => $profileData,
            'role' => $user->role,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        if ($user->role === 'orang_tua' && $user->orangTua) {
            $user->orangTua->alamat = $request->alamat;
            $user->orangTua->rt = $request->rt;
            $user->orangTua->rw = $request->rw;
            $user->orangTua->save();
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Mengirimkan error ke session
                ->withInput(); // Mengembalikan input sebelumnya
        }

        // Cek apakah password baru sama dengan password lama
        if (Hash::check($request->new_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['new_password' => 'Password baru tidak boleh sama dengan password lama.'])
                ->withInput();
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }
}
