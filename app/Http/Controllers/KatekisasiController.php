<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Katekisasi;
use App\Models\ProfilJemaat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KatekisasiController extends Controller
{
    public function index()
    {
        $jemaatId = Auth::id();
        $pernahKatekisasi = Katekisasi::where('jemaat_id', $jemaatId)->where('status_verifikasi', '!=', 'ditolak')->first();
        $katekisasiTidakHadir = Katekisasi::where('jemaat_id', $jemaatId)
            ->where('status_kehadiran', 'Tidak Hadir')
            ->orderBy('created_at', 'desc')
            ->first();

        return view('landing-page.katekisasi.index', compact('pernahKatekisasi', 'katekisasiTidakHadir'));
    }

    public function create(){
        $jadwals = Jadwal::whereHas('layanan', function($query) {
            $query->where('nama', 'Katekisasi');
        })->get();
        return view('landing-page.katekisasi.create', compact('jadwals'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nik' => 'nullable|numeric|digits:16',
            'akta_baptis' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'jemaat_id' => 'required',
            'jadwal_id' => 'required',
            'jenis_katekisasi' => 'required|in:Baptis Dewasa,Sidhi'
        ], [
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus memiliki 16 angka.',
            'akta_baptis.required' => 'Akta Baptis wajib diisi.',
            'akta_baptis.max' => 'Ukuran file maksimal 2MB.',
            'akta_baptis.mimes' => 'File baptis harus PDF, JPG, JPEG, atau PNG.',
            'jemaat_id.required' => 'Jemaat wajib diisi.',
            'jadwal_id.required' => 'Jadwal wajib diisi.',
            'jenis_katekisasi.required' => 'Jenis katekisasi wajib diisi.',
            'jenis_katekisasi.in' => 'Jenis katekisasi tidak valid.'
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Gagal mendaftar katekisasi.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jemaatId = $request->jemaat_id;
        $pernahKatekisasi = Katekisasi::where('jemaat_id', $jemaatId)
                          ->where('status_verifikasi', '!=', 'Ditolak')
                          ->first();

        $katekisasiTidakHadir = Katekisasi::where('jemaat_id', $jemaatId)
        ->where('status_kehadiran', 'Tidak Hadir')
        ->orderBy('created_at', 'desc')
        ->first();

        if ($pernahKatekisasi && !$katekisasiTidakHadir) {
            toast('Anda sudah pernah mendaftar katekisasi.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withInput();
        }

        if ($katekisasiTidakHadir) {
            Katekisasi::where('jemaat_id', $jemaatId)
                ->where('status_kehadiran', 'Tidak Hadir')
                ->delete();
        }

        if ($request->hasFile('akta_baptis') && $request->file('akta_baptis')->isValid()) {
            $extension = $request->akta_baptis->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $aktaBaptisPath = $request->file('akta_baptis')->storeAs('jemaat/akta_baptis', $fileName);

            $profil = ProfilJemaat::where('user_id', $jemaatId)->first();

            if ($profil && $profil->akta_baptis) {
                if (Storage::exists($profil->akta_baptis)) {
                    Storage::delete($profil->akta_baptis);
                }
            }

            ProfilJemaat::where('user_id', $jemaatId)->update([
                'akta_baptis' => $aktaBaptisPath
            ]);
        }

        if ($request->filled('nik')) {
            ProfilJemaat::where('user_id', $jemaatId)->update([
                'nik' => $request->nik
            ]);
        }
        Katekisasi::create([
            'id' => strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s'))),
            'jemaat_id' => $jemaatId,
            'jadwal_id' => $request->jadwal_id,
            'jenis_katekisasi' => $request->jenis_katekisasi,
        ]);

        toast('Berhasil mendaftar katekisasi.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('katekisasi');
    }
}
