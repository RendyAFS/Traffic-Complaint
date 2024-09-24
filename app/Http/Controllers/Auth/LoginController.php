<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

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

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        // Cek level pengguna setelah berhasil login
        if ($user->level == 'Admin') {
            // Redirect ke route untuk Admin
            return redirect()->route('admin.index');
        } elseif ($user->level == 'User') {
            // Redirect ke route untuk User
            return redirect()->route('user.index');
        }

        // Jika level tidak dikenali, redirect ke halaman default
        return redirect('/home');
    }
}
