<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\ProfilJemaat;
use App\Models\Sidhi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SidhiController extends Controller
{
    public function index()
    {
        $jemaatId = Auth::id();
        $pernahSidhi = Sidhi::where('jemaat_id', $jemaatId)->where('status_verifikasi', '!=', 'ditolak')->first();
        return view('landing-page.sidhi.index', compact('pernahSidhi'));
    }

    public function create(){
        $jadwals = Jadwal::whereHas('layanan', function($query) {
            $query->where('nama', 'Sidhi/Baptis Dewasa');
        })->get();
        return view('landing-page.sidhi.create', compact('jadwals'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nik' => 'nullable|numeric|digits:16',
            'akta_baptis' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'katekisasi' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'jemaat_id' => 'required',
            'jadwal_id' => 'required'
        ], [
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus memiliki 16 angka.',
            'akta_baptis.max' => 'Ukuran file maksimal 2MB.',
            'akta_baptis.mimes' => 'File baptis harus PDF, JPG, JPEG, atau PNG.',
            'katekisasi.required' => 'Akta Baptis wajib diisi.',
            'katekisasi.max' => 'Ukuran file maksimal 2MB.',
            'katekisasi.mimes' => 'File baptis harus PDF, JPG, JPEG, atau PNG.',
            'jemaat_id.required' => 'Jemaat wajib diisi.',
            'jadwal_id.required' => 'Jadwal wajib diisi.',
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Gagal mendaftar sidhi/baptis dewasa.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jemaatId = $request->jemaat_id;
        $pernahSidhi = Sidhi::where('jemaat_id', $jemaatId)->where('status_verifikasi', '!=', 'ditolak')->first();

        if ($pernahSidhi) {
            toast('Anda sudah pernah mendaftar sidhi/baptis dewasa.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withInput();
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

        if ($request->hasFile('katekisasi') && $request->file('katekisasi')->isValid()) {
            $extension = $request->katekisasi->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $katekisasiPath = $request->file('katekisasi')->storeAs('jemaat/katekisasi', $fileName);

            $profil = ProfilJemaat::where('user_id', $jemaatId)->first();

            if ($profil && $profil->katekisasi) {
                if (Storage::exists($profil->katekisasi)) {
                    Storage::delete($profil->katekisasi);
                }
            }

            ProfilJemaat::where('user_id', $jemaatId)->update([
                'katekisasi' => $katekisasiPath
            ]);
        }

        if ($request->filled('nik')) {
            ProfilJemaat::where('user_id', $jemaatId)->update([
                'nik' => $request->nik
            ]);
        }

        Sidhi::create([
            'id' => strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s'))),
            'jemaat_id' => $jemaatId,
            'jadwal_id' => $request->jadwal_id
        ]);

        toast('Berhasil mendaftar sidhi/baptis dewasa.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('sidhi');
    }
}
