<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendetaController extends Controller
{
    public function index()
    {
        $dataType = 'pendeta';
        $pendetas = User::where('role', 'pendeta')->orderBy('created_at','asc')->get();
        return view('admin.users.pendeta.index', compact('dataType','pendetas'));
    }

    public function create(){

        $dataType = 'pendeta';
        return view('admin.users.pendeta.create', compact('dataType'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',

            'password.required' => 'Kata sandi wajib diisi.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi harus memiliki minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Periksa kembali data anda.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s')));

        User::create([
            'id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pendeta',
            'is_verified' => 1
        ]);

        toast('Pendeta berhasil ditambahkan.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('pendeta.index');
    }
}
