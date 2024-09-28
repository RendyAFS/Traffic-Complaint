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

    public function uploadGambar(Request $request)
    {
        // Validasi file gambar
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan file ke folder 'file-gambar' di storage publik
        if ($request->hasFile('gambar')) {
            $user = Auth::user();
            $file = $request->file('gambar');
            $originalName = $file->getClientOriginalName();

            // Fungsi untuk menghasilkan kode acak 11 karakter
            $randomCode = '';
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);

            // Menghasilkan kode acak
            for ($i = 0; $i < 11; $i++) {
                $randomCode .= $characters[rand(0, $charactersLength - 1)];
            }

            // Buat nama file dengan format: id-user-email_user-randomCode-nama_gambar.ext
            $filename = $user->id . '-' . $user->email . '_' . $user->name . '_' . $randomCode . '_' . $originalName;

            try {
                $file->storeAs('file-gambar', $filename, 'public');
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal upload file: ' . $e->getMessage()], 500);
            }

            // Simpan nama file di session
            session(['uploaded_image' => $filename]);

            return response()->json(['filename' => $filename]);
        }

        return response()->json(['error' => 'Gagal upload file'], 400);
    }

    // Method untuk simpan aduan
    public function formComplaint(Request $request)
    {
        $request->validate([
            'text-complaint' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'gambar' => 'nullable|string',
        ]);

        // Ambil nama file dari session
        $filename = session('uploaded_image');

        Complaint::create([
            'users_id' => Auth::id(),
            'text_complaint' => $request->input('text-complaint'),
            'type_complaint' => $this->getRandomComplaintType(), // Fungsi untuk mendapatkan tipe aduan secara acak
            'lokasi' => $request->input('lokasi'),
            'status' => 'Belum Selesai',
            'gambar' => $filename, // Gunakan nama file dari session
        ]);

        // Hapus session setelah disimpan
        session()->forget('uploaded_image');

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
