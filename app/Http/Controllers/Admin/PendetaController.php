<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilPendeta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendetaController extends Controller
{
    public function index()
    {
        $dataType = 'pendeta';
        $pendetas = User::with('profilPendeta')->where('role', 'pendeta')->orderBy('created_at','asc')->get();
        return view('admin.users.pendeta.index', compact('dataType','pendetas'));
    }

    public function create(){

        $dataType = 'pendeta';
        return view('admin.users.pendeta.create', compact('dataType'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

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
            toast('Gagal menambahkan pendeta.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = strtoupper(md5("!@#!@#" . Carbon::now()->format('YmdH:i:s')));

        $pendeta =User::create([
            'id' => $id,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pendeta',
            'is_verified' => 1
        ]);

        ProfilPendeta::create([
            'user_id' => $pendeta->id,
            'nama' => $request->nama
        ]);

        toast('Pendeta berhasil ditambahkan.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('pendeta.index');
    }

    public function destroy($id){
        $pendeta = User::findOrFail($id);
        $pendeta->delete();

        toast('Pendeta berhasil dihapus.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
