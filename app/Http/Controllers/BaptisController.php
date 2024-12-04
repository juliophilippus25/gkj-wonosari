<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class BaptisController extends Controller
{
    public function index()
    {
        return view('landing-page.baptis.index');
    }

    public function create(){
        $jadwals = Jadwal::whereHas('layanan', function($query) {
            $query->where('nama', 'Baptis');
        })->get();
        return view('landing-page.baptis.create', compact('jadwals'));
    }
}
