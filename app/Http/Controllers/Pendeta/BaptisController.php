<?php

namespace App\Http\Controllers\Pendeta;

use App\Http\Controllers\Controller;
use App\Models\Baptis;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BaptisController extends Controller
{
    public function index()
    {
        $dataType = 'jadwal baptis';

        $pendetaId = Auth::id();
        $jadwals = Jadwal::where('pendeta_id', $pendetaId)
            ->whereHas('layanan', function ($query) {
                $query->where('nama', 'Baptis');
            })
            ->get()
            ->map(function ($jadwal) {
                $uniquePendaftarCount = Baptis::where('jadwal_id', $jadwal->id)
                    ->distinct('jemaat_id')
                    ->count();

                $jadwal->jumlah_pendaftar = $uniquePendaftarCount;

                return $jadwal;
            });

        return view('pendeta.baptis.index', compact('dataType', 'jadwals'));
    }

    public function show($id){
        $dataType = 'pendaftar baptis';
        $dataType1 = 'pendaftar ditolak';
        $jadwal = Jadwal::findOrFail($id);

        $pendetaId = Auth::id();
        $pendaftars = Baptis::where('jadwal_id', $id)
            ->whereHas('jadwal', function($query) use ($pendetaId) {
                $query->where('pendeta_id', $pendetaId);
            })
            ->where('status_verifikasi', '!=', 'ditolak')
            ->get();

        $pendaftarDitolaks = Baptis::where('jadwal_id', $id)
            ->whereHas('jadwal', function ($query) use ($pendetaId) {
                $query->where('pendeta_id', $pendetaId);
            })
            ->where('status_verifikasi', 'ditolak')
            ->whereNotIn('jemaat_id', function ($query) use ($id) {
                $query->select('jemaat_id')
                    ->from('baptis')
                    ->where('jadwal_id', $id)
                    ->where('status_verifikasi', 'disetujui');
            })
            ->get();

        return view('pendeta.baptis.show', compact('dataType', 'dataType1','jadwal', 'pendaftars', 'pendaftarDitolaks'));
    }

    public function showRejectForm($id)
    {
        $pendaftar = Baptis::findOrFail($id);
        return view('pendeta.baptis.rejectForm', compact('pendaftar'));
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

        $pendaftar = Baptis::findOrFail($id);

        $pendaftar->status_verifikasi = 'ditolak';
        $pendaftar->catatan = $request->catatan;
        $pendaftar->save();

        toast("Pendaftar berhasil ditolak.", 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function accept($id){
        $pendaftar = Baptis::findOrFail($id);

        $pendaftar->status_verifikasi = 'disetujui';
        $pendaftar->save();

        toast("Pendaftar berhasil disetujui.", 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
