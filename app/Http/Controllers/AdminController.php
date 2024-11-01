<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ComplaintsImport;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Index
    public function index()
    {
        $title = 'Admin';
        return view('page-admin.index', compact('title'));
    }

    public function uploadGambar(Request $request)
    {
        // Validasi file gambar
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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

            try {
                $file->storeAs('file-gambar', $filename, 'public');
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal upload file: ' . $e->getMessage()], 500);
            }

            session(['uploaded_image' => $filename]);
            return response()->json(['filename' => $filename]);
        }

        return response()->json(['error' => 'Gagal upload file'], 400);
    }

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

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:complaints,id',
            'status' => 'required|string|in:Belum Selesai,Selesai', // Sesuaikan dengan opsi yang ada
        ]);

        // Temukan aduan berdasarkan ID dan perbarui statusnya
        $complaint = Complaint::findOrFail($request->id);
        $complaint->status = $request->status;
        $complaint->save();

        return response()->json([
            'message' => 'Aduan berhasil diupdate!',
            'redirect' => route('admin.index'), // Mengembalikan URL untuk redirect
        ]);
    }

    public function uploadFileAduan(Request $request)
    {
        // Validasi file Excel
        $request->validate([
            'fileTemplateAduan' => 'required|file|mimes:xlsx,xls|max:2048',
        ]);

        if ($request->hasFile('fileTemplateAduan')) {
            $file = $request->file('fileTemplateAduan');

            try {
                // Import data dari file Excel ke database
                Excel::import(new ComplaintsImport, $file);
                return response()->json(['success' => 'File imported successfully!']);
            } catch (\Exception $e) {
                // Log error ke laravel.log untuk pengecekan
                Log::error('File import error: ' . $e->getMessage());

                return response()->json(['error' => 'Gagal mengimpor file: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['error' => 'Tidak ada file yang diupload'], 400);
    }



    public function getDataComplaint(Request $request)
    {
        // Query dengan urutan prioritas pada 'type_complaint'
        $query = Complaint::with('user')
            ->orderByRaw("CASE
            WHEN type_complaint = 'sangat urgent' THEN 1
            WHEN type_complaint = 'urgent' THEN 2
            WHEN type_complaint = 'kurang urgent' THEN 3
            WHEN type_complaint = 'tidak urgent' THEN 4
            ELSE 5 END")
            ->where('status', 'Belum Selesai')
            ->orderBy('created_at', 'asc');

        return datatables()->of($query)
            ->addColumn('no', function ($row) {
                static $counter = 1;
                return $counter++;
            })
            ->addColumn('status', function ($row) {
                // Mengembalikan status mentah untuk di-render di frontend
                return $row->status;
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

    // Index Done Complaint
    public function indexDoneComplaint()
    {
        $title = 'Done Complaint';
        return view('page-admin.done-complaint', compact('title'));
    }

    public function getDataDoneComplaint(Request $request)
    {
        // Query dengan urutan prioritas pada 'type_complaint'
        $query = Complaint::with('user')
            ->orderByRaw("CASE
            WHEN type_complaint = 'sangat urgent' THEN 1
            WHEN type_complaint = 'urgent' THEN 2
            WHEN type_complaint = 'kurang urgent' THEN 3
            WHEN type_complaint = 'tidak urgent' THEN 4
            ELSE 5 END")
            ->where('status', 'Selesai')
            ->orderBy('created_at', 'asc');

        return datatables()->of($query)
            ->addColumn('no', function ($row) {
                static $counter = 1;
                return $counter++;
            })
            ->addColumn('status', function ($row) {
                // Mengembalikan status mentah untuk di-render di frontend
                return $row->status;
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
