<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class BaptisController extends Controller
{
    public function index()
    {
        return view('landing-page.baptis.index');
    }

    public function create(){
        $schedules = Schedule::whereHas('services', function($query) {
            $query->where('name', 'baptis');
        })->get();
        return view('landing-page.baptis.create', compact('schedules'));
    }
}
