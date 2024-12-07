<?php

namespace App\Http\Controllers\Pendeta;

use App\Http\Controllers\Controller;
use App\Models\Baptis;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaptisController extends Controller
{
    public function index()
    {
        $dataType = 'baptis';

        $pendetaId = Auth::id();
        $jadwals = Jadwal::where('pendeta_id', $pendetaId)
        ->whereHas('layanan', function($query) {
            $query->where('nama', 'Baptis');
        })
        ->get();

        $jumlahPendaftar = Baptis::where('jadwal_id', $jadwals[0]->id)->count();

        return view('pendeta.baptis.index', compact('dataType', 'jadwals', 'jumlahPendaftar'));
    }
}
