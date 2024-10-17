<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $dataType = 'pengguna';
        $users = User::where('role', '!=', 'admin')->orderBy('created_at','asc')->get();
        return view('admin.users.index', compact('dataType','users'));
    }

    public function verify($id)
    {
        // if (auth()->user()->role == 'admin' || !Auth::guard()->check()) {
        //     toast('Anda harus login sebagai admin.','error')->timerProgressBar()->autoClose(5000);
        //     return redirect('/login');
        // }

        $user = User::findOrFail($id);

        if ($user->isVerified) {
            toast('Pengguna sudah terverifikasi.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back();
        }

        $user->isVerified = 1;
        $user->save();

        toast('Pengguna berhasil diverifikasi.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
