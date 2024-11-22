<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ComplaintsImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Completion\CompletionInput;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getDataAllComplaint(Request $request)
    {
        // Query dengan urutan prioritas pada 'type_complaint'
        $query = Complaint::with('user')
            ->orderByRaw("CASE
            WHEN type_complaint = 'sangat urgent' THEN 1
            WHEN type_complaint = 'urgent' THEN 2
            WHEN type_complaint = 'kurang urgent' THEN 3
            WHEN type_complaint = 'tidak urgent' THEN 4
            ELSE 5 END")
            ->where('status', 'Aduan Masuk')
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

    // Index
    public function index()
    {
        $title = 'Admin';

        // Daftar status yang ingin ditampilkan
        $statusList = ['Aduan Masuk', 'Aduan Ditangani', 'Aduan Selesai'];

        // Hitung total berdasarkan status
        $statuses = Complaint::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Pastikan semua status ada, jika tidak, isi dengan 0
        $statuses = collect($statusList)->map(function ($status) use ($statuses) {
            return [
                'status' => $status,
                'total' => $statuses[$status] ?? 0,
            ];
        });

        // Hitung total semua aduan
        $totalComplaints = array_sum(array_column($statuses->toArray(), 'total'));

        return view('page-admin.index', compact('title', 'statuses', 'totalComplaints'));
    }


    public function formComplaint(Request $request)
    {
        try {
            $request->validate([
                'text-complaint' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $filename = null;
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

            Complaint::create([
                'users_id' => Auth::id(),
                'text_complaint' => $request->input('text-complaint'),
                'type_complaint' => $this->getRandomComplaintType(),
                'lokasi' => $request->input('lokasi'),
                'status' => 'Aduan Masuk',
                'gambar' => $filename,
            ]);

            return redirect()->back()->with('success-formComplaint', 'Aduan berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error-formComplaint', 'Validasi gagal, cek inputan Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error-formComplaint', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
            'status' => 'required|string', // Sesuaikan dengan opsi yang ada
        ]);

        // Temukan aduan berdasarkan ID dan perbarui statusnya
        $complaint = Complaint::findOrFail($request->id);
        $complaint->status = $request->status;
        $complaint->save();

        return response()->json([
            'message' => 'Aduan berhasil diupdate!',
            'redirect' => url()->previous(), // Mengarahkan kembali ke halaman sebelumnya
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



    public function indexNewComplaint()
    {
        $title = 'Nee Complaint';
        return view('page-admin.new-complaint', compact('title'));
    }
    public function getDataNewComplaint(Request $request)
    {
        // Query dengan urutan prioritas pada 'type_complaint'
        $query = Complaint::with('user')
            ->orderByRaw("CASE
            WHEN type_complaint = 'sangat urgent' THEN 1
            WHEN type_complaint = 'urgent' THEN 2
            WHEN type_complaint = 'kurang urgent' THEN 3
            WHEN type_complaint = 'tidak urgent' THEN 4
            ELSE 5 END")
            ->where('status', 'Aduan Masuk')
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
    public function indexProcessComplaint()
    {
        $title = 'Process Complaint';
        return view('page-admin.process-complaint', compact('title'));
    }

    public function getDataProcessComplaint(Request $request)
    {
        // Query dengan urutan prioritas pada 'type_complaint'
        $query = Complaint::with('user')
            ->orderByRaw("CASE
            WHEN type_complaint = 'sangat urgent' THEN 1
            WHEN type_complaint = 'urgent' THEN 2
            WHEN type_complaint = 'kurang urgent' THEN 3
            WHEN type_complaint = 'tidak urgent' THEN 4
            ELSE 5 END")
            ->where('status', 'Aduan Ditangani')
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
            ->where('status', 'Aduan Selesai')
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
