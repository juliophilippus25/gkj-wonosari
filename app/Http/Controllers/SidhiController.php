<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class SidhiController extends Controller
{
    public function index()
    {
        return view('landing-page.sidhi.index');
    }

    public function create(){
        $schedules = Schedule::whereHas('services', function($query) {
            $query->where('name', 'Sidhi/Baptis Dewasa');
        })->get();
        return view('landing-page.sidhi.create', compact('schedules'));
    }
}
