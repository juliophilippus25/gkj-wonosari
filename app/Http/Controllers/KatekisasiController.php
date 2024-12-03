<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class KatekisasiController extends Controller
{
    public function index()
    {
        return view('landing-page.katekisasi.index');
    }

    public function create(){
        $schedules = Schedule::whereHas('services', function($query) {
            $query->where('name', 'Katekisasi');
        })->get();
        return view('landing-page.katekisasi.create', compact('schedules'));
    }
}
