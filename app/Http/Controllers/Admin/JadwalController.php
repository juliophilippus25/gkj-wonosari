<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Layanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    public function index(){
        $dataType = 'jadwal';
        $jadwals = Jadwal::with(['layanan', 'pendeta'])->get();
        return view('admin.jadwal.index', compact('dataType', 'jadwals'));
    }

    public function create(){
        $dataType = 'jadwal';
        $layanans = Layanan::all();
        $pendetas = User::where('role', 'pendeta')->get();
        return view('admin.jadwal.create', compact('dataType', 'layanans', 'pendetas'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),
        // Aturan
        [
            'tanggal' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
            'jam' => 'required|date_format:H:i',
            'pendeta_id' => 'required|exists:users,id', // Validasi pendeta
            'layanan_id' => 'required|exists:layanans,id', // Validasi ID wilayah
        ],
        // Pesan
        [
            // Required
            'date.required' => 'Tanggal harus diisi.', // Pesan untuk tanggal
            'jam.required' => 'Waktu harus diisi.', // Pesan untuk waktu
            'layanan_id.required' => 'Wilayah harus dipilih.', // Pesan untuk layanan_id

            // Date
            'tanggal.date' => 'Tanggal harus berupa tanggal yang valid.', // Pesan untuk tanggal
            'tanggal.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.', // Pesan untuk tanggal
            'jam.date_format' => 'Format waktu harus dalam format HH:mm.', // Pesan untuk waktu
            'pendeta_id.exists' => 'Pendeta yang dipilih tidak valid.', // Pesan untuk pendeta_id
            'layanan_id.exists' => 'Wilayah yang dipilih tidak valid.', // Pesan untuk layanan_id
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Gagal menambahkan jadwal.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s')));

        Jadwal::create([
            'id' => $id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'pendeta_id' => $request->pendeta_id,
            'layanan_id' => $request->layanan_id
        ]);

        toast('Jadwal berhasil ditambahkan.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('jadwal.index');
    }
}
