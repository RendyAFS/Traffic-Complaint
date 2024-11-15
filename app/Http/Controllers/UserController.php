<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    // Method untuk simpan aduan
    public function formComplaint(Request $request)
    {
        // Validasi input
        $request->validate([
            'text-complaint' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ], [
            'gambar.required' => 'Gambar harus diunggah.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Gambar maksimal berukuran 2MB.',
        ]);

        $user = Auth::user();

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $originalName = $file->getClientOriginalName();

            // Generate filename unik
            $randomCode = '';
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);

            for ($i = 0; $i < 11; $i++) {
                $randomCode .= $characters[rand(0, $charactersLength - 1)];
            }

            $filename = $user->id . '-' . $user->email . '_' . $user->name . '_' . $randomCode . '_' . $originalName;

            // Simpan gambar
            try {
                $file->storeAs('file-gambar', $filename, 'public');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['gambar' => 'Gagal upload file: ' . $e->getMessage()]);
            }
        } else {
            return redirect()->back()->withErrors(['gambar' => 'Gambar tidak ditemukan atau format salah.']);
        }

        // Simpan data ke database
        Complaint::create([
            'users_id' => $user->id,
            'text_complaint' => $request->input('text-complaint'),
            'type_complaint' => $this->getRandomComplaintType(),
            'lokasi' => $request->input('lokasi'),
            'status' => 'Belum Selesai',
            'gambar' => $filename,
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
        $query = Complaint::where('users_id', Auth::id())->orderBy('created_at', 'asc');

        return datatables()->of($query)
            ->addColumn('no', function ($row) {
                static $counter = 1;
                return $counter++;
            })
            ->addColumn('gambar', function ($row) {
                // Mengembalikan nama file gambar jika ada
                return $row->gambar;
            })
            ->editColumn('created_at', function ($row) {
                // Kembalikan data 'created_at' mentah
                return $row->created_at;
            })
            ->make(true);
    }
}
