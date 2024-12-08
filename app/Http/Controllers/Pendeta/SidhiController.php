<?php

namespace App\Http\Controllers\Pendeta;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Sidhi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SidhiController extends Controller
{
    public function index(){
        $dataType = 'jadwal sidhi';

        $pendetaId = Auth::id();
        $jadwals = Jadwal::where('pendeta_id', $pendetaId)
            ->whereHas('layanan', function ($query) {
                $query->where('nama', 'Sidhi/Baptis Dewasa');
            })
            ->get()
            ->map(function ($jadwal) {
                $uniquePendaftarCount = Sidhi::where('jadwal_id', $jadwal->id)
                    ->where('status_verifikasi', '!=', 'Ditolak')
                    ->distinct('jemaat_id')
                    ->count();

                $jadwal->jumlah_pendaftar = $uniquePendaftarCount;

                return $jadwal;
            });

        return view('pendeta.sidhi.index', compact('dataType', 'jadwals'));
    }

    public function show($id){
        $dataType = 'pendaftar sidhi/baptis dewasa';
        $dataType1 = 'pendaftar ditolak';
        $jadwal = Jadwal::findOrFail($id);

        $pendetaId = Auth::id();
        $pendaftars = Sidhi::where('jadwal_id', $id)
            ->whereHas('jadwal', function($query) use ($pendetaId) {
                $query->where('pendeta_id', $pendetaId);
            })
            ->where('status_verifikasi', '!=', 'Ditolak')
            ->get();

        $pendaftarDitolaks = Sidhi::where('jadwal_id', $id)
            ->whereHas('jadwal', function ($query) use ($pendetaId) {
                $query->where('pendeta_id', $pendetaId);
            })
            ->where('status_verifikasi', 'Ditolak')
            ->whereNotIn('jemaat_id', function ($query) use ($id) {
                $query->select('jemaat_id')
                    ->from('sidhis')
                    ->where('jadwal_id', $id)
                    ->where('status_verifikasi', 'Disetujui');
            })
            ->get();

        return view('pendeta.sidhi.show', compact('dataType', 'dataType1','jadwal', 'pendaftars', 'pendaftarDitolaks'));
    }

    public function showRejectForm($id)
    {
        $pendaftar = Sidhi::findOrFail($id);
        return view('pendeta.sidhi.rejectForm', compact('pendaftar'));
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

        $pendaftar = Sidhi::findOrFail($id);

        $pendaftar->status_verifikasi = 'Ditolak';
        $pendaftar->catatan = $request->catatan;
        $pendaftar->save();

        toast("Pendaftar berhasil ditolak.", 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function accept($id){
        $pendaftar = Sidhi::findOrFail($id);

        $pendaftar->status_verifikasi = 'Disetujui';
        $pendaftar->save();

        toast("Pendaftar berhasil disetujui.", 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
