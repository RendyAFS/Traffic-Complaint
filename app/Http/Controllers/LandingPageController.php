<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Support\Carbon;

class LandingPageController extends Controller
{
    public function indexLandingPage()
    {
        // Total seluruh Complient
        $totalComplient = Complaint::count();

        // Complient dalam 1 minggu terakhir
        $oneWeekAgo = Carbon::now()->subWeek(); // Mendapatkan tanggal satu minggu lalu
        $complientWeekly = Complaint::where('created_at', '>=', $oneWeekAgo)->count();

        // Complient dengan status "Selesai"
        $complinetDone = Complaint::where('status', 'Selesai')->count();

        // Ambil 3 data Complient terbaru berdasarkan created_at
        $latestComplaints = Complaint::orderBy('created_at', 'desc')->take(3)->get();

        // Kirim data ke view welcome
        return view('welcome', compact('totalComplient', 'complientWeekly', 'complinetDone', 'latestComplaints'));
    }
}
