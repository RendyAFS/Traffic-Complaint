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
        $request->validate(
            [
                'text-complaint' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'text-complaint.required' => 'Kolom teks aduan wajib diisi.',
                'lokasi.required' => 'Kolom lokasi wajib diisi.',
                'gambar.image' => 'File harus berupa gambar.',
                'gambar.mimes' => 'Format file yang diperbolehkan hanya jpeg, png, jpg, atau gif.',
                'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
                'gambar.uploaded' => 'Gagal mengunggah file. Ukuran file mungkin melebihi batas maksimal.', // Tambahan untuk pesan "uploaded"
            ]
        );

        try {
            $filename = null;

            // Jika ada file gambar yang diunggah
            if ($request->hasFile('gambar')) {
                $user = Auth::user();
                $file = $request->file('gambar');
                $originalName = $file->getClientOriginalName();

                $randomCode = '';
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);

                for ($i = 0; $i < 11; $i++) {
                    $randomCode .= $characters[rand(0, $charactersLength - 1)];
                }

                $filename = $user->id . '-' . $user->email . '_' . $user->name . '_' . $randomCode . '_' . $originalName;

                // Simpan file ke direktori 'file-gambar' di disk 'public'
                $file->storeAs('file-gambar', $filename, 'public');
            }

            // Simpan data ke database
            Complaint::create([
                'users_id' => Auth::id(),
                'text_complaint' => $request->input('text-complaint'),
                'type_complaint' => $this->getRandomComplaintType(), // Fungsi untuk mendapatkan tipe aduan secara acak
                'lokasi' => $request->input('lokasi'),
                'status' => 'Aduan Masuk',
                'gambar' => $filename, // Simpan nama file di database
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success-formComplaint', 'Aduan berhasil disimpan!');
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            return redirect()->back()->with('error-formComplaint', 'Terjadi kesalahan saat menyimpan aduan!');
        }
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
