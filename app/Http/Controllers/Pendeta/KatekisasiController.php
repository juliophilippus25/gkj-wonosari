<?php

namespace App\Http\Controllers\Pendeta;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Katekisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KatekisasiController extends Controller
{
    public function index(){
        $dataType = 'jadwal katekisasi';

        $pendetaId = Auth::id();
        $jadwals = Jadwal::where('pendeta_id', $pendetaId)
            ->whereHas('layanan', function ($query) {
                $query->where('nama', 'Katekisasi');
            })
            ->get()
            ->map(function ($jadwal) {
                $uniquePendaftarCount = Katekisasi::where('jadwal_id', $jadwal->id)
                    ->distinct('jemaat_id')
                    ->count();

                $jadwal->jumlah_pendaftar = $uniquePendaftarCount;

                return $jadwal;
            });

        return view('pendeta.katekisasi.index', compact('dataType', 'jadwals'));
    }

    public function show($id){
        $dataType = 'pendaftar katekiasasi';
        $dataType1 = 'pendaftar ditolak';
        $jadwal = Jadwal::findOrFail($id);

        $pendetaId = Auth::id();
        $pendaftars = Katekisasi::where('jadwal_id', $id)
            ->whereHas('jadwal', function($query) use ($pendetaId) {
                $query->where('pendeta_id', $pendetaId);
            })
            ->where('status_verifikasi', '!=', 'Ditolak')
            ->get();

        $pendaftarDitolaks = Katekisasi::where('jadwal_id', $id)
            ->whereHas('jadwal', function ($query) use ($pendetaId) {
                $query->where('pendeta_id', $pendetaId);
            })
            ->where('status_verifikasi', 'Ditolak')
            ->whereNotIn('jemaat_id', function ($query) use ($id) {
                $query->select('jemaat_id')
                    ->from('katekisasis')
                    ->where('jadwal_id', $id)
                    ->where('status_verifikasi', 'Disetujui');
            })
            ->get();

        return view('pendeta.katekisasi.show', compact('dataType', 'dataType1','jadwal', 'pendaftars', 'pendaftarDitolaks'));
    }

    public function showRejectForm($id)
    {
        $pendaftar = Katekisasi::findOrFail($id);
        return view('pendeta.katekisasi.rejectForm', compact('pendaftar'));
    }

    public function reject(Request $request, $id){
        $validator = Validator::make($request->all(),
            // Aturan
            [
                'catatan' => 'required',
            ],
            // Pesan
            [
                'catatan.required' => 'Catatan harus diisi.',
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Gagal menolak pendaftar.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pendaftar = Katekisasi::findOrFail($id);

        $pendaftar->status_verifikasi = 'Ditolak';
        $pendaftar->catatan = $request->catatan;
        $pendaftar->save();

        toast("Pendaftar berhasil ditolak.", 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function accept($id){
        $pendaftar = Katekisasi::findOrFail($id);

        $pendaftar->status_verifikasi = 'Disetujui';
        $pendaftar->save();

        toast("Pendaftar berhasil disetujui.", 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
