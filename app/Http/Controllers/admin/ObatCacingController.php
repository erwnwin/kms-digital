<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ObatCacingController extends Controller
{
    //
    public function index()
    {
        return view('admin.obat-cacing.index');
    }
}
