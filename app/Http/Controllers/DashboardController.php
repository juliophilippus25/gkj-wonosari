<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use App\Models\Katekisasi;
use App\Models\ProfilJemaat;
use App\Models\Sidhi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Dashboard Jemaat
        $jemaatId = Auth::user()->id;
        $getSuratBaptis = $this->getSuratBaptis();
        $getSuratSidhi = $this->getSuratSidhi();
        $getSuratKatekisasi = $this->getSuratKatekisasi();

        $suratKehadiran = Katekisasi::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', 'Disetujui')
            ->orderBy('created_at', 'desc')
            ->first();

        $ditolakKatekisasi = Katekisasi::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', 'Ditolak')
            ->orderBy('created_at', 'desc')
            ->first();

        $ditolakBaptis = Baptis::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', 'Ditolak')
            ->orderBy('created_at', 'desc')
            ->first();

        $ditolakSidhi = Sidhi::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', 'Ditolak')
            ->orderBy('created_at', 'desc')
            ->first();

        $pendaftaranKatekisasiBaru = Katekisasi::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', '!=', 'Ditolak')
            ->orderBy('created_at', 'desc')
            ->exists();

        $pendaftaranBaptisBaru = Baptis::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', '!=', 'Ditolak')
            ->orderBy('created_at', 'desc')
            ->exists();

        $pendaftaranSidhiBaru = Sidhi::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', '!=', 'Ditolak')
            ->orderBy('created_at', 'desc')
            ->exists();

        $diprosesKatekisasi = Katekisasi::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', 'Diproses')
            ->first();

        $diprosesBaptis = Baptis::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', 'Diproses')
            ->first();

        $diprosesSidhi = Sidhi::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', 'Diproses')
            ->first();

        $katekisasiTidakHadir = Katekisasi::where('jemaat_id', $jemaatId)
            ->where('status_kehadiran', 'Tidak Hadir')
            ->orderBy('created_at', 'desc')
            ->first();

        $isTidakHadirKatekisasi = $katekisasiTidakHadir ? true : false;

        return view('dashboard', compact(
            'getSuratBaptis',
            'getSuratSidhi',
            'getSuratKatekisasi',
            'suratKehadiran',
            'ditolakKatekisasi',
            'ditolakBaptis',
            'ditolakSidhi',
            'pendaftaranKatekisasiBaru',
            'pendaftaranBaptisBaru',
            'pendaftaranSidhiBaru',
            'diprosesKatekisasi',
            'diprosesBaptis',
            'diprosesSidhi',
            'katekisasiTidakHadir',
            'isTidakHadirKatekisasi'
        ));
    }

    private function getSuratBaptis(){
        $jemaatId = Auth::user()->id;

        $suratBaptis = Baptis::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', 'Disetujui')
            ->where('status_kehadiran', 'Hadir')
            ->first();

        return $suratBaptis;
    }

    private function getSuratSidhi(){
        $jemaatId = Auth::user()->id;

        $suratSidhi = Sidhi::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', 'Disetujui')
            ->where('status_kehadiran', 'Hadir')
            ->first();

        return $suratSidhi;
    }

    private function getSuratKatekisasi(){
        $jemaatId = Auth::user()->id;

        $suratKatekisasi = Katekisasi::where('jemaat_id', $jemaatId)
            ->where('status_verifikasi', 'Disetujui')
            ->where('status_kehadiran', 'Hadir')
            ->first();

        return $suratKatekisasi;
    }

    public function kartuKehadiranPDF($id)
    {
        $jemaatId = Auth::user()->id;

        $profilJemaat = ProfilJemaat::where('user_id', $jemaatId)->first();
        $katekisasi = Katekisasi::where('jemaat_id', $jemaatId)->first();

        // Setup PDF
        $pdf = PDF::loadView('pdf.kehadiran', compact('profilJemaat', 'katekisasi'));

        // Mendapatkan nama pengguna dan membuat nama file PDF yang dinamis
        $namaJemaat = strtoupper(str_replace(' ', '_', $profilJemaat->nama)); // Ganti 'nama' dengan nama yang sesuai di model
        $filename = 'KARTU_KEHADIRAN_KATEKISASI_' . $namaJemaat . '.pdf';

        // Download PDF file dengan nama file yang dinamis
        return $pdf->stream($filename);
    }
}
