<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
        // Cek level pengguna yang sedang login
        $user = Auth::user();

        if ($user->level == 'Admin') {
            // Redirect ke halaman Admin
            return redirect()->route('admin.index');
        } elseif ($user->level == 'User') {
            // Redirect ke halaman User
            return redirect()->route('user.index');
        }

        // Jika level tidak dikenali, redirect ke halaman default
        return redirect('/home');
    }
}
