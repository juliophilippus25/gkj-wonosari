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
        $dataType = 'jadwal baptis';

        $pendetaId = Auth::id();
        $jadwals = Jadwal::where('pendeta_id', $pendetaId)
            ->whereHas('layanan', function($query) {
                $query->where('nama', 'Baptis');
            })
            ->withCount('baptis')
            ->get();

        return view('pendeta.baptis.index', compact('dataType', 'jadwals'));
    }


    public function show($id){
        $dataType = 'pendaftar baptis';
        $jadwal = Jadwal::find($id);

        $pendetaId = Auth::id();
        $pendaftars = Baptis::where('jadwal_id', $id)
            ->whereHas('jadwal', function($query) use ($pendetaId) {
                $query->where('pendeta_id', $pendetaId);
            })
            ->with('profilJemaat')
            ->get();

        return view('pendeta.baptis.show', compact('dataType', 'jadwal', 'pendaftars'));
    }
}
