<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = 'User';
        return view('page-user.index', compact('title'));
    }

    public function formComplaint(Request $request)
    {
        $request->validate([
            'text-complaint' => 'required|string|max:255',
            'file-gambar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('file-gambar')) {
            $gambarPath = $request->file('file-gambar')->store('uploads', 'public');
        }

        Complaint::create([
            'users_id' => Auth::id(),
            'text_complaint' => $request->input('text-complaint'),
            'type_complaint' => $this->getRandomComplaintType(), // Method untuk mendapatkan tipe acak
            'status' => 'Belum Selesai',
            'gambar' => $gambarPath,
        ]);

        return redirect()->back()->with('success-upload', 'Aduan berhasil disimpan!');
    }

    private function getRandomComplaintType()
    {
        $types = ['tidak urgent', 'kurang urgent', 'urgent', 'sangat urgent'];
        return $types[array_rand($types)];
    }

    public function getDataRiwayat(Request $request)
    {
        $query = Complaint::where('users_id', Auth::id())->latest();

        return datatables()->of($query)
            ->addColumn('no', function ($row) {
                static $counter = 1;
                return $counter++;
            })
            ->addColumn('gambar', function ($row) {
                if ($row->gambar) {
                    return '<img src="' . asset('storage/' . $row->gambar) . '" width="100">';
                }
                return 'Tidak ada gambar';
            })
            ->rawColumns(['gambar'])
            ->make(true);
    }
}
