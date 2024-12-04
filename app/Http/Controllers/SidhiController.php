<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class SidhiController extends Controller
{
    public function index()
    {
        return view('landing-page.sidhi.index');
    }

    public function create(){
        $jadwals = Jadwal::whereHas('layanan', function($query) {
            $query->where('nama', 'Sidhi/Baptis Dewasa');
        })->get();
        return view('landing-page.sidhi.create', compact('jadwals'));
    }
}
