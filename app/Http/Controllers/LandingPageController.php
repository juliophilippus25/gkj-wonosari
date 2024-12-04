<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::all();
        return view('landing-page.welcome', compact('jadwals'));
    }
}
