<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class KatekisasiController extends Controller
{
    public function index()
    {
        return view('landing-page.katekisasi.index');
    }

    public function create(){
        $jadwals = Jadwal::whereHas('layanan', function($query) {
            $query->where('nama', 'Katekisasi');
        })->get();
        return view('landing-page.katekisasi.create', compact('jadwals'));
    }
}
