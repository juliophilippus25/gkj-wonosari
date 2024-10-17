<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index(){
        $dataType = 'jadwal';
        $schedules = Schedule::with(['services', 'users'])->get();
        return view('admin.schedules.index', compact('dataType', 'schedules'));
    }

    public function create(){
        $dataType = 'jadwal';
        $services = Service::all();
        $pendetas = User::where('role', 'pendeta')->get();
        return view('admin.schedules.create', compact('dataType', 'services', 'pendetas'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),
        // Aturan
        [
            'date' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
            'time' => 'required|date_format:H:i',
            'pendeta_id' => 'required|exists:users,id', // Validasi pendeta
            'service_id' => 'required|exists:services,id', // Validasi ID wilayah
        ],
        // Pesan
        [
            // Required
            'date.required' => 'Tanggal harus diisi.', // Pesan untuk tanggal
            'time.required' => 'Waktu harus diisi.', // Pesan untuk waktu
            'service_id.required' => 'Wilayah harus dipilih.', // Pesan untuk service_id

            // Date
            'date.date' => 'Tanggal harus berupa tanggal yang valid.', // Pesan untuk tanggal
            'date.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.', // Pesan untuk tanggal
            'time.date_format' => 'Format waktu harus dalam format HH:mm.', // Pesan untuk waktu
            'pendeta_id.exists' => 'Pendeta yang dipilih tidak valid.', // Pesan untuk pendeta_id
            'service_id.exists' => 'Wilayah yang dipilih tidak valid.', // Pesan untuk service_id
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Periksa kembali data anda.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $schedule = Schedule::create([
            'date' => $request->date,
            'time' => $request->time,
            'pendeta_id' => $request->pendeta_id,
            'service_id' => $request->service_id
        ]);

        toast('Jadwal berhasil ditambahkan.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('admin.schedules.index');
    }
}
