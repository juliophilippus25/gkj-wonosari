<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Registration;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $dataType = 'pendaftaran';

        $registrations = Registration::with('schedule.users')
            ->where('user_id', $userId)
            ->get();

        return view('jemaat.registrations.index', compact('dataType', 'registrations'));
    }

    public function create() {
        $user = Auth::user();
        $regions = Region::all();
        $schedules = Schedule::with(['services', 'users'])->get();
        return view('jemaat.registrations.create', compact('regions', 'schedules', 'user'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),
            // Aturan
            [
                'name' => 'required|string|max:255',
                'gender' => 'required|in:M,F',
                'date_of_birth' => 'required|date|before:' . now()->format('Y-m-d'),
                'place_of_birth' => 'required|string|max:255',
                'birth_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'address' => 'required|string|max:255',
                'schedule_id' => 'required|exists:schedules,id',
                'region_id' => 'required|exists:regions,id',
            ],
            // Pesan
            [
                'name.required' => 'Nama harus diisi.',
                'gender.required' => 'Jenis kelamin harus dipilih.',
                'date_of_birth.required' => 'Tanggal lahir harus diisi.',
                'place_of_birth.required' => 'Tempat lahir harus diisi.',
                'birth_certificate.required' => 'Nomor akta kelahiran harus diisi.',
                'address.required' => 'Alamat harus diisi.',
                'schedule_id.required' => 'Jadwal harus dipilih.',
                'region_id.required' => 'Wilayah harus dipilih.',

                'name.string' => 'Nama harus berupa string.',
                'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
                'gender.in' => 'Jenis kelamin harus berupa male atau female.',
                'date_of_birth.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
                'date_of_birth.before' => 'Tanggal lahir tidak boleh setelah hari ini.',
                'place_of_birth.string' => 'Tempat lahir harus berupa string.',
                'place_of_birth.max' => 'Tempat lahir tidak boleh lebih dari 255 karakter.',
                'address.string' => 'Alamat harus berupa string.',
                'address.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
                'schedule_id.exists' => 'Jadwal yang dipilih tidak valid.',
                'region_id.exists' => 'Wilayah yang dipilih tidak valid.',
                'user_id.exists' => 'Pengguna yang dipilih tidak valid.',
                'birth_certificate.mimes' => 'Akta kelahiran harus berupa file dengan format: pdf, jpg, jpeg, png.',
                'birth_certificate.max' => 'Ukuran akta kelahiran tidak boleh lebih dari 2MB.',
            ]);

        if ($validator->fails()) {
            // redirect dengan pesan error
            toast('Periksa kembali data anda.', 'error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $userId = Auth::id();

        if ($request->hasFile('birth_certificate') && $request->file('birth_certificate')->isValid()) {
            $extension = $request->birth_certificate->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $birthCertificatePath = $request->file('birth_certificate')->storeAs('files/births', $fileName);
        } else {
            $birthCertificatePath = NULL;
        }
        $id = strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s')));

        Registration::create([
            'id' => $id,
            'name' => $request->name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'place_of_birth' => $request->place_of_birth,
            'birth_certificate' => $birthCertificatePath,
            'address' => $request->address,
            'schedule_id' => $request->schedule_id,
            'region_id' => $request->region_id,
            'user_id' => $userId,
        ]);

        toast('Pendaftaran berhasil ditambahkan.', 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('registrations.index');

    }
}
