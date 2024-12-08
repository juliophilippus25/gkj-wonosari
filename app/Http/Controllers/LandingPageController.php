<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use App\Models\Jadwal;
use App\Models\Katekisasi;
use App\Models\Sidhi;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::all();

        foreach ($jadwals as $jadwal) {
            $pendaftarCount = $this->getJumlahPendaftar($jadwal->id);

            $jadwal->jumlah_pendaftar = $pendaftarCount;
        }

        return view('landing-page.welcome', compact('jadwals'));
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
}
