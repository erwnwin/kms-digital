<?php

namespace App\Http\Controllers\orangtua;

use App\Models\Anak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilAnakController extends Controller
{
    //
    public function index()
    {
        $orangTuaId = Auth::user()->orangTua->id;

        $anak = Anak::where('orang_tua_id', $orangTuaId)->get();

        return view('orangtua.profil_anak.index', compact('anak'));
    }
}
