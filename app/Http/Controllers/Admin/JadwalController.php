<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Baptis;
use App\Models\Jadwal;
use App\Models\Katekisasi;
use App\Models\Layanan;
use App\Models\Sidhi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    public function index(){
        $dataType = 'jadwal';
        $jadwals = Jadwal::with(['layanan', 'pendeta'])->get();
        return view('admin.jadwal.index', compact('dataType', 'jadwals'));
    }

    public function create(){
        $dataType = 'jadwal';
        $layanans = Layanan::all();
        $pendetas = User::where('role', 'pendeta')->get();
        return view('admin.jadwal.create', compact('dataType', 'layanans', 'pendetas'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),
        // Aturan
        [
            'tanggal' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
            'jam' => 'required|date_format:H:i',
            'pendeta_id' => 'required|exists:users,id', // Validasi pendeta
            'layanan_id' => 'required|exists:layanans,id', // Validasi ID wilayah
            'jenis_bahasa' => 'required|in:Indonesia,Jawa',
        ],
        // Pesan
        [
            // Required
            'date.required' => 'Tanggal harus diisi.', // Pesan untuk tanggal
            'jam.required' => 'Waktu harus diisi.', // Pesan untuk waktu
            'layanan_id.required' => 'Wilayah harus dipilih.', // Pesan untuk layanan_id
            'pendeta_id.required' => 'Pendeta harus dipilih.', // Pesan untuk pendeta_id
            'jenis_bahasa.required' => 'Bahasa harus dipilih.',

            // In
            'jenis_bahasa.in' => 'Bahasa dipilih tidak valid.',

            // Date
            'tanggal.date' => 'Tanggal harus berupa tanggal yang valid.', // Pesan untuk tanggal
            'tanggal.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.', // Pesan untuk tanggal
            'jam.date_format' => 'Format waktu harus dalam format HH:mm.', // Pesan untuk waktu
            'pendeta_id.exists' => 'Pendeta yang dipilih tidak valid.', // Pesan untuk pendeta_id
            'layanan_id.exists' => 'Wilayah yang dipilih tidak valid.', // Pesan untuk layanan_id
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Gagal menambahkan jadwal.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s')));

        Jadwal::create([
            'id' => $id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'pendeta_id' => $request->pendeta_id,
            'layanan_id' => $request->layanan_id,
            'jenis_bahasa' => $request->jenis_bahasa
        ]);

        toast('Jadwal berhasil ditambahkan.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('jadwal.index');
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

        return view('admin.jadwal.show', compact('dataType', 'jadwal', 'pendaftars'));
    }

    public function verifyPresent($id)
    {
        $pendaftar = null;
        if ($pendaftar = Baptis::find($id)) {
            $pendaftar->status_kehadiran = 'Hadir';
            $pendaftar->save();
        } elseif ($pendaftar = Sidhi::find($id)) {
            $pendaftar->status_kehadiran = 'Hadir';
            $pendaftar->save();
        } elseif ($pendaftar = Katekisasi::find($id)) {
            $pendaftar->status_kehadiran = 'Hadir';
            $pendaftar->save();
        }

        toast('Kehadiran berhasil diperbarui ke Hadir.', 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function verifyAbsent($id)
    {
        $pendaftar = null;
        if ($pendaftar = Baptis::find($id)) {
            $pendaftar->status_kehadiran = 'Tidak Hadir';
            $pendaftar->save();
        } elseif ($pendaftar = Sidhi::find($id)) {
            $pendaftar->status_kehadiran = 'Tidak Hadir';
            $pendaftar->save();
        } elseif ($pendaftar = Katekisasi::find($id)) {
            $pendaftar->status_kehadiran = 'Tidak Hadir';
            $pendaftar->save();
        }

        toast('Kehadiran berhasil diperbarui ke Tidak Hadir.', 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
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

    public function destroy($id)
    {
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

        foreach ($pendaftars as $pendaftar) {
            $pendaftar->delete();
        }

        $jadwal->delete();

        toast('Jadwal berhasil dihapus.', 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
