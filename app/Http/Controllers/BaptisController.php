<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaptisController extends Controller
{
    public function index(){
        return view('landing-page.baptis.index');
    }

    public function create(){
        $jadwals = Jadwal::whereHas('layanan', function($query) {
            $query->where('nama', 'Baptis');
        })->get();
        return view('landing-page.baptis.create', compact('jadwals'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'jemaat_id' => 'required',
            'jadwal_id' => 'required'
        ], [
            'jemaat_id.required' => 'Jemaat wajib diisi.',
            'jadwal_id.required' => 'Jadwal wajib diisi.',
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Gagal mendaftar baptis.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jemaatId = $request->jemaat_id;
        $pernahBaptis = Baptis::where('jemaat_id', $jemaatId)->first();

        if ($pernahBaptis) {
            toast('Anda sudah pernah mendaftar baptis.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withInput();
        }

        Baptis::create([
            'id' => strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s'))),
            'jemaat_id' => $jemaatId,
            'jadwal_id' => $request->jadwal_id
        ]);

        toast('Berhasil mendaftar baptis.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('baptis');
    }
}
