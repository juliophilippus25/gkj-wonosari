<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class JemaatController extends Controller
{
    public function index()
    {
        $dataType = 'jemaat';
        $jemaats = User::where('role', 'jemaat')->orderBy('created_at','asc')->get();
        return view('admin.users.jemaat.index', compact('dataType','jemaats'));
    }

    public function verify($id)
    {
        // if (auth()->user()->role == 'admin' || !Auth::guard()->check()) {
        //     toast('Anda harus login sebagai admin.','error')->timerProgressBar()->autoClose(5000);
        //     return redirect('/login');
        // }

        $user = User::findOrFail($id);

        if ($user->is_verified) {
            toast('Jemaat sudah terverifikasi.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back();
        }

        $user->is_verified = 1;
        $user->save();

        toast('Jemaat berhasil diverifikasi.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
