<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use App\Models\Jadwal;
use App\Models\Katekisasi;
use App\Models\Sidhi;
use Illuminate\Http\Request;

class JadwalPelayananController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::all();

        foreach ($jadwals as $jadwal) {
            $pendaftarCount = $this->getJumlahPendaftar($jadwal->id);

            $jadwal->jumlah_pendaftar = $pendaftarCount;
        }

        return view('landing-page.jadwal-pelayanan.index', compact('jadwals'));
    }

    private function getJumlahPendaftar($jadwalId)
    {
        $baptis = Baptis::where('jadwal_id', $jadwalId)
            ->where('status_verifikasi', '!=', 'Ditolak')
            ->pluck('jemaat_id');

        $sidhi = Sidhi::where('jadwal_id', $jadwalId)
            ->where('status_verifikasi', '!=', 'Ditolak')
            ->pluck('jemaat_id');

        $katekisasi = Katekisasi::where('jadwal_id', $jadwalId)
            ->where('status_verifikasi', '!=', 'Ditolak')
            ->pluck('jemaat_id');

        $jumlahPendaftar = $baptis->merge($sidhi)->merge($katekisasi)->unique();

        return $jumlahPendaftar->count();
    }

    public function show($id)
    {
        $dataType = 'pendaftar';

        $jadwal = Jadwal::findOrFail($id);

        $pendaftars = collect();

        if (Baptis::where('jadwal_id', $jadwal->id)->exists()) {
            $pendaftars = Baptis::where('jadwal_id', $jadwal->id)
                ->where('status_verifikasi', '!=', 'Ditolak')
                ->get();
        } elseif (Sidhi::where('jadwal_id', $jadwal->id)->exists()) {
            $pendaftars = Sidhi::where('jadwal_id', $jadwal->id)
                ->where('status_verifikasi', '!=', 'Ditolak')
                ->get();
        } elseif (Katekisasi::where('jadwal_id', $jadwal->id)->exists()) {
            $pendaftars = Katekisasi::where('jadwal_id', $jadwal->id)
                ->where('status_verifikasi', '!=', 'Ditolak')
                ->get();
        }

        $pendaftarCount = $pendaftars ? $pendaftars->pluck('jemaat_id')->unique()->count() : 0;
        $jadwal->jumlah_pendaftar = $pendaftarCount;

        return view('landing-page.jadwal-pelayanan.show', compact('dataType', 'jadwal', 'pendaftars'));
    }
}
