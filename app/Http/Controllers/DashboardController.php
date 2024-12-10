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

    public function kartuKehadiranPDF($id)
    {
        $jemaatId = Auth::user()->id;  // Mendapatkan ID pengguna yang sedang login

        // Mengambil ProfilJemaat berdasarkan ID pengguna yang sedang login
        $profilJemaat = ProfilJemaat::where('user_id', $jemaatId)->first();  // Ganti 'user_id' dengan kolom yang benar jika berbeda

        $katekisasi = Katekisasi::where('jemaat_id', $jemaatId)->first();

        // Setup PDF
        $pdf = PDF::loadView('pdf.kehadiran', compact('profilJemaat', 'katekisasi'));

        // Mendapatkan nama pengguna dan membuat nama file PDF yang dinamis
        $namaJemaat = strtoupper(str_replace(' ', '_', $profilJemaat->nama)); // Ganti 'nama' dengan nama yang sesuai di model
        $filename = 'Kartu_Kehadiran_' . $namaJemaat . '.pdf';

        // Download PDF file dengan nama file yang dinamis
        return $pdf->stream($filename);
    }
}
