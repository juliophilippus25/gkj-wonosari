<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use App\Models\Jadwal;
use App\Models\Katekisasi;
use App\Models\ProfilJemaat;
use App\Models\Sidhi;
use App\Models\Wilayah;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ->whereIn('status_verifikasi', ['Diproses', 'Disetujui'])
            ->first();

        $diprosesBaptis = Baptis::where('jemaat_id', $jemaatId)
            ->whereIn('status_verifikasi', ['Diproses', 'Disetujui'])
            ->first();

        $diprosesSidhi = Sidhi::where('jemaat_id', $jemaatId)
            ->whereIn('status_verifikasi', ['Diproses', 'Disetujui'])
            ->first();

        $katekisasiTidakHadir = Katekisasi::where('jemaat_id', $jemaatId)
            ->where('status_kehadiran', 'Tidak Hadir')
            ->orderBy('created_at', 'desc')
            ->first();

        $isTidakHadirKatekisasi = $katekisasiTidakHadir ? true : false;

        // Dashboard Admin dan Pendeta
        $getJumlahJemaat = $this->getJumlahJemaat();
        $getJemaatLaki = $this->getJemaatLaki();
        $getJemaatPerempuan = $this->getJemaatPerempuan();
        $getJemaatPerWilayah = $this->getJemaatPerWilayah();
        $getJadwalPelayanan = $this->getJadwalPelayanan();

        // Dashboard Pendeta
        $getJadwalPelayananPendeta = $this->getJadwalPelayananPendeta();

        return view('dashboard', compact(
            // Dashboard Jemaat
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
            'isTidakHadirKatekisasi',

            // Dashboard Admin dan Pendeta
            'getJumlahJemaat',
            'getJemaatLaki',
            'getJemaatPerempuan',
            'getJemaatPerWilayah',
            'getJadwalPelayanan',

            // Dashboard Pendeta
            'getJadwalPelayananPendeta'
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

    private function getJumlahJemaat() {
        $jemaatCount = ProfilJemaat::count();

        return $jemaatCount;
    }

    private function getJemaatLaki() {
        $jemaatCount = ProfilJemaat::where('jenis_kelamin', 'L')->count();

        return $jemaatCount;
    }

    private function getJemaatPerempuan() {
        $jemaatCount = ProfilJemaat::where('jenis_kelamin', 'P')->count();

        return $jemaatCount;
    }

    private function getJemaatPerWilayah() {
        $wilayahs = Wilayah::all();

        $jemaatPerWilayah = ProfilJemaat::select('wilayah_id', DB::raw('COUNT(*) as jumlah_jemaat'))
            ->groupBy('wilayah_id')
            ->get();

        $data = [];

        $priorityOrder = [
            'Wilayah 1', 'Wilayah 2', 'Wilayah 3', 'Wilayah 4', 'Wilayah 5',
            'Wilayah 6', 'Wilayah 7', 'Wilayah 8', 'Wilayah 9',
            'Panthan Bendungan', 'Panthan Randukuning', 'Panthan Nglipar',
            'Panthan Kebonjero', 'Panthan Hargomulyo', 'Kelompok Wareng'
        ];

        $sortedWilayahs = $wilayahs->sortBy(function($wilayah) use ($priorityOrder) {
            return array_search($wilayah->nama, $priorityOrder);
        });

        foreach ($sortedWilayahs as $wilayah) {
            $jemaat = $jemaatPerWilayah->where('wilayah_id', $wilayah->id)->first();
            $jumlahJemaat = $jemaat ? $jemaat->jumlah_jemaat : 0;

            $data[] = [
                'wilayah' => $wilayah->nama,
                'jumlah_jemaat' => $jumlahJemaat
            ];
        }

        return $data;
    }

    private function getJadwalPelayanan() {
        $bulanTahunSekarang = Carbon::now()->format('F Y');

        $jadwals = Jadwal::whereMonth('tanggal', Carbon::now()->month)
                        ->whereYear('tanggal', Carbon::now()->year)
                        ->get();

        $jadwalPerBulan = [];

        foreach ($jadwals as $jadwal) {
            $pendaftarCount = 0;

            if (Baptis::where('jadwal_id', $jadwal->id)->exists()) {
                $pendaftarCount += Baptis::where('jadwal_id', $jadwal->id)
                                        ->where('status_verifikasi', '!=', 'Ditolak')
                                        ->count();
            }

            if (Sidhi::where('jadwal_id', $jadwal->id)->exists()) {
                $pendaftarCount += Sidhi::where('jadwal_id', $jadwal->id)
                                        ->where('status_verifikasi', '!=', 'Ditolak')
                                        ->count();
            }

            if (Katekisasi::where('jadwal_id', $jadwal->id)->exists()) {
                $pendaftarCount += Katekisasi::where('jadwal_id', $jadwal->id)
                                            ->where('status_verifikasi', '!=', 'Ditolak')
                                            ->count();
            }

            $jadwalPerBulan[$bulanTahunSekarang][] = [
                'jadwal' => $jadwal,
                'jumlah_pendaftar' => $pendaftarCount
            ];
        }

        return $jadwalPerBulan;
    }

    private function getJadwalPelayananPendeta() {
        $bulanTahunSekarang = Carbon::now()->format('F Y');

        $pendetaId = Auth::user()->id;

        $jadwals = Jadwal::whereMonth('tanggal', Carbon::now()->month)
                        ->whereYear('tanggal', Carbon::now()->year)
                        ->where('pendeta_id', $pendetaId)
                        ->get();

        $jadwalPerBulan = [];

        foreach ($jadwals as $jadwal) {
            $pendaftarCount = 0;

            if (Baptis::where('jadwal_id', $jadwal->id)->exists()) {
                $pendaftarCount += Baptis::where('jadwal_id', $jadwal->id)
                                        ->where('status_verifikasi', '!=', 'Ditolak')
                                        ->count();
            }

            if (Sidhi::where('jadwal_id', $jadwal->id)->exists()) {
                $pendaftarCount += Sidhi::where('jadwal_id', $jadwal->id)
                                        ->where('status_verifikasi', '!=', 'Ditolak')
                                        ->count();
            }

            if (Katekisasi::where('jadwal_id', $jadwal->id)->exists()) {
                $pendaftarCount += Katekisasi::where('jadwal_id', $jadwal->id)
                                            ->where('status_verifikasi', '!=', 'Ditolak')
                                            ->count();
            }

            $jadwalPerBulan[$bulanTahunSekarang][] = [
                'jadwal' => $jadwal,
                'jumlah_pendaftar' => $pendaftarCount
            ];
        }

        return $jadwalPerBulan;
    }

}
