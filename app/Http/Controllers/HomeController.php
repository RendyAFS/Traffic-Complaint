<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Carbon\Carbon;
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

    public function indexLandingPage()
    {
        // Total seluruh Complient
        $totalComplient = Complaint::count();

        // Complient dalam 1 minggu terakhir
        $oneWeekAgo = Carbon::now()->subWeek(); // Mendapatkan tanggal satu minggu lalu
        $complientWeekly = Complaint::where('created_at', '>=', $oneWeekAgo)->count();

        // Complient dengan status "Selesai"
        $complinetDone = Complaint::where('status', 'Selesai')->count();

        // Kirim data ke view welcome
        return view('welcome', compact('totalComplient', 'complientWeekly', 'complinetDone'));
    }
}
