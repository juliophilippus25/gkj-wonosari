<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    public function authenticated($user)
    {
        $user = Auth::user();
        if($user->role == 'admin') {
            toast('Anda berhasil masuk ke sistem.','success')->hideCloseButton()->autoClose(5000);
            return redirect('/dashboard');
        } elseif($user->role == 'pendeta') {
            toast('Anda berhasil masuk ke sistem.','success')->hideCloseButton()->autoClose(5000);
            return redirect('/dashboard');
        } elseif($user->role == 'jemaat') {
            toast('Anda berhasil masuk ke sistem.','success')->hideCloseButton()->autoClose(5000);
            return redirect('/');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
