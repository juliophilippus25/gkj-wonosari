<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ProfilJemaat;
use App\Models\User;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |---------------------------------------------------------------------------
    | Register Controller
    |---------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default, this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $wilayahs = Wilayah::all();

        $priorityOrder = [
            'Wilayah 1', 'Wilayah 2', 'Wilayah 3', 'Wilayah 4', 'Wilayah 5',
            'Wilayah 6', 'Wilayah 7', 'Wilayah 8', 'Wilayah 9',
            'Panthan Bendungan', 'Panthan Randukuning', 'Panthan Nglipar',
            'Panthan Kebonjero', 'Panthan Hargomulyo', 'Kelompok Wareng'
        ];

        $sortedWilayahs = $wilayahs->sortBy(function($wilayah) use ($priorityOrder) {
            return array_search($wilayah->nama, $priorityOrder);
        });

        return view('auth.register', compact('sortedWilayahs'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'same:password'],

            'nik' => ['nullable', 'string', 'max:16', 'unique:profil_jemaats'],
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'ayah' => ['required', 'string', 'max:255'],
            'ibu' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'wilayah_id' => ['required'],
        ], [
            // Pesan untuk nama
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            // Pesan untuk email
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',

            // Pesan untuk password
            'password.required' => 'Kata sandi wajib diisi.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi harus memiliki minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',

            // Pesan untuk konfirmasi password
            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
            'password_confirmation.string' => 'Konfirmasi kata sandi harus berupa teks.',
            'password_confirmation.min' => 'Konfirmasi kata sandi harus memiliki minimal 8 karakter.',
            'password_confirmation.same' => 'Konfirmasi kata sandi tidak cocok.',

            // Pesan untuk NIK
            'nik.string' => 'NIK harus berupa teks.',
            'nik.max' => 'NIK tidak boleh lebih dari 16 karakter.',
            'nik.unique' => 'NIK sudah terdaftar.',

            // Pesan untuk nomor HP
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.string' => 'Nomor HP harus berupa teks.',
            'no_hp.max' => 'Nomor HP tidak boleh lebih dari 255 karakter.',

            // Pesan untuk tempat lahir
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tempat_lahir.string' => 'Tempat lahir harus berupa teks.',
            'tempat_lahir.max' => 'Tempat lahir tidak boleh lebih dari 255 karakter.',

            // Pesan untuk tanggal lahir
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',

            // Pesan untuk ayah
            'ayah.required' => 'Nama ayah wajib diisi.',
            'ayah.string' => 'Nama ayah harus berupa teks.',
            'ayah.max' => 'Nama ayah tidak boleh lebih dari 255 karakter.',

            // Pesan untuk ibu
            'ibu.required' => 'Nama ibu wajib diisi.',
            'ibu.string' => 'Nama ibu harus berupa teks.',
            'ibu.max' => 'Nama ibu tidak boleh lebih dari 255 karakter.',

            // Pesan untuk jenis kelamin
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'jenis_kelamin.in' => 'Jenis kelamin harus berupa L (Laki-laki) atau P (Perempuan).',

            // Pesan untuk wilayah
            'wilayah_id.required' => 'Wilayah wajib dipilih.',
        ]);

        if ($validator->fails()) {
            return redirect($this->redirectTo)->toast($validator->errors(),'error')->timerProgressBar()->autoClose(5000);
        }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $id = strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s')));

        $user = User::create([
            'id' => $id,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        ProfilJemaat::create([
            'user_id' => $user->id,
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'no_hp' => $data['no_hp'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'ayah' => $data['ayah'],
            'ibu' => $data['ibu'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'wilayah_id' => $data['wilayah_id'],
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            toast('Gagal membuat akun.','error')->timerProgressBar()->autoClose(5000);
            return redirect($this->redirectTo)->withInput()->withErrors($validator);
        }

        $this->create($request->all());

        toast('Akun anda telah dibuat. Silakan menunggu verifikasi.','success')->timerProgressBar()->autoClose(5000);
        return redirect($this->redirectTo);
    }
}
