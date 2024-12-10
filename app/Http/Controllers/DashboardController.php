<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use App\Models\Katekisasi;
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
        $getSuratBaptis = $this->getSuratBaptis();
        $getSuratSidhi = $this->getSuratSidhi();
        $getSuratKatekisasi = $this->getSuratKatekisasi();

        return view('dashboard', compact(
            'getSuratBaptis',
            'getSuratSidhi',
            'getSuratKatekisasi'
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

    public function downloadPDF($id)
    {
        $pendaftar = null;

        if ($pendaftar = Baptis::find($id)) {
            $pendaftar->jadwal;
        } elseif ($pendaftar = Sidhi::find($id)) {
            $pendaftar->jadwal;
        } elseif ($pendaftar = Katekisasi::find($id)) {
            $pendaftar->jadwal;
        }

        // Setup PDF
        $pdf = PDF::loadView('admin.jadwal.pdf', compact('pendaftar'));
        $nama = strtoupper(str_replace(' ', '_', $pendaftar->profilJemaat->nama));
        $layanan = strtoupper(str_replace(' ', '_', $pendaftar->jadwal->layanan->nama));
        $tanggal = strtoupper(str_replace(' ', '_', \Carbon\Carbon::parse($pendaftar->jadwal->tanggal)->isoFormat('D_MMMM_Y')));

        // Download PDF file with download method
        return $pdf->stream('SURAT_'.$layanan.'_'.$nama.'_'.$tanggal.'_'.'.pdf', compact('pendaftar'));
    }
}
