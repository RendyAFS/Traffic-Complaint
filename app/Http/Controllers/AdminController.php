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

        // Ambil data category_complaint
        $categoryComplaints = Complaint::select('category_complaint')->distinct()->take(5)->get();


        // Hitung total semua aduan
        $totalComplaints = array_sum(array_column($statuses->toArray(), 'total'));

        return view('page-admin.index', compact('title', 'statuses', 'totalComplaints', 'categoryComplaints'));
    }

    public function getDataAllComplaint(Request $request)
    {
        $query = Complaint::with('user')
            ->select('complaints.*') // Pastikan hanya kolom complaints yang dipilih
            ->leftJoin('users', 'complaints.users_id', '=', 'users.id')
            ->orderByRaw("
            CASE
                WHEN type_complaint = 'sangat urgent' THEN 1
                WHEN type_complaint = 'urgent' THEN 2
                WHEN type_complaint = 'kurang urgent' THEN 3
                WHEN type_complaint = 'tidak urgent' THEN 4
                ELSE 5
            END
        ")
            ->orderBy('complaints.created_at', 'asc'); // Tambahkan prefiks tabel untuk created_at

        // Filter kategori aduan (category_complaint)
        if ($request->has('category_complaint') && $request->category_complaint) {
            $query->where('category_complaint', $request->category_complaint);
        }

        // Filter rentang tanggal pada complaints.created_at
        if ($request->has('date_range') && $request->date_range) {
            $dates = explode(' to ', $request->date_range);
            $startDate = $dates[0] ?? null;
            $endDate = $dates[1] ?? null;

            if ($startDate && !$endDate) {
                // Jika hanya satu tanggal dipilih, filter pada tanggal tersebut saja
                $query->whereDate('complaints.created_at', $startDate);
            } elseif ($startDate && $endDate) {
                // Jika rentang tanggal diberikan, filter di antara tanggal tersebut
                $query->whereBetween('complaints.created_at', [$startDate, $endDate]);
            }
        }

        return datatables()->of($query)
            ->addColumn('no', function ($row) {
                static $counter = 1;
                return $counter++;
            })
            ->make(true);
    }

    public function formComplaint(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'text-complaint' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Proses gambar (jika ada)
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

            // Baca data dari file CSV
            $situasiFile = public_path('dataset/situasi.csv'); // Path file situasi.csv
            $tempatFile = public_path('dataset/tempat.csv');   // Path file tempat.csv
            $vocabSituasi = $this->loadCsvSituasi($situasiFile);
            $vocabTempat = $this->loadCsvTempat($tempatFile);

            // Ekstrak kategori aduan
            $textComplaint = $request->input('text-complaint');
            $inputLokasi = $request->input('lokasi'); // Ambil lokasi dari input form
            $categoryComplaint = $this->extractCategoryComplaint($textComplaint, $vocabSituasi, $vocabTempat, $inputLokasi);

            // Simpan data aduan ke database
            Complaint::create([
                'users_id' => Auth::id(),
                'text_complaint' => $textComplaint,
                'type_complaint' => $this->getRandomComplaintType(),
                'category_complaint' => $categoryComplaint, // Tambahkan kategori aduan di sini
                'lokasi' => $inputLokasi,
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


    // Fungsi untuk membaca file CSV (situasi)
    private function loadCsvSituasi($filePath)
    {
        $situasi = [];
        if (($handle = fopen($filePath, "r")) !== false) {
            $header = fgetcsv($handle, 1000, ",");
            while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                $situasi[] = array_filter([$row[0], $row[1], $row[2], $row[3], $row[4], $row[5]]);
            }
            fclose($handle);
        }
        return $situasi;
    }

    // Fungsi untuk membaca file CSV (tempat)
    private function loadCsvTempat($filePath)
    {
        $tempat = [];
        if (($handle = fopen($filePath, "r")) !== false) {
            $header = fgetcsv($handle, 1000, ",");
            while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                $tempat[$row[1]] = array_filter([$row[1], $row[2], $row[3], $row[4], $row[5], $row[6]]);
            }
            fclose($handle);
        }
        return $tempat;
    }

    // Fungsi untuk mengekstraksi kategori aduan
    private function extractCategoryComplaint($text, $vocabSituasi, $vocabTempat, $inputLokasi)
    {
        $situasi = [];
        $tempat = [];

        // Cari situasi
        foreach ($vocabSituasi as $group) {
            foreach ($group as $word) {
                if (stripos($text, $word) !== false) {
                    $situasi[] = $group[0];
                    break;
                }
            }
        }

        // Cari tempat
        foreach ($vocabTempat as $key => $synonyms) {
            foreach ($synonyms as $synonym) {
                if (stripos($text, $synonym) !== false) {
                    $tempat[] = $key;
                    break;
                }
            }
        }

        // Jika lokasi dari teks kosong, gunakan lokasi dari input
        if (empty($tempat)) {
            $tempat[] = $inputLokasi;
        }

        // Gabungkan kategori
        $situasiStr = implode(', ', $situasi);
        $tempatStr = implode(', ', $tempat);

        return $situasiStr . ($tempatStr ? ", " . $tempatStr : '');
    }


    // Fungsi untuk menentukan tipe aduan secara acak
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

        // Temukan aduan berdasarkan ID
        $complaint = Complaint::findOrFail($request->id);

        // Simpan status baru pada aduan yang ditemukan
        $complaint->status = $request->status;
        $complaint->save();

        // Perbarui semua aduan dengan category_status yang sama dalam rentang waktu 3 jam
        if ($complaint->category_complaint && $complaint->created_at) { // Pastikan category_complaint dan created_at ada
            $startTime = $complaint->created_at->subHours(3); // Rentang 3 jam ke belakang
            $endTime = $complaint->created_at->addHours(3);  // Rentang 3 jam ke depan

            Complaint::where('category_complaint', $complaint->category_complaint)
                ->where('id', '!=', $complaint->id) // Hindari memperbarui data yang sama
                ->whereBetween('created_at', [$startTime, $endTime]) // Filter rentang waktu 3 jam
                ->update(['status' => $request->status]);
        }

        return response()->json([
            'message' => 'Aduan berhasil diupdate, termasuk semua aduan dengan kategori dan rentang waktu yang sama!',
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
        $title = 'New Complaint';
        return view('page-admin.new-complaint', compact('title'));
    }
    public function getDataNewComplaint(Request $request)
    {
        // Query dengan urutan prioritas pada 'type_complaint'
        $query = Complaint::with('user') // Eager load untuk menghindari N+1 query
            ->select('complaints.*') // Pastikan hanya kolom dari complaints yang diambil langsung
            ->orderByRaw("
            CASE
                WHEN type_complaint = 'sangat urgent' THEN 1
                WHEN type_complaint = 'urgent' THEN 2
                WHEN type_complaint = 'kurang urgent' THEN 3
                WHEN type_complaint = 'tidak urgent' THEN 4
                ELSE 5
            END
        ") // Prioritas berdasarkan type_complaint
            ->where('status', 'Aduan Masuk') // Filter hanya Aduan Masuk
            ->orderBy('created_at', 'asc'); // Urutkan berdasarkan created_at secara ascending


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
        $query = Complaint::with('user') // Eager load untuk menghindari N+1 query
            ->select('complaints.*') // Pastikan hanya kolom dari complaints yang diambil langsung
            ->orderByRaw("
        CASE
            WHEN type_complaint = 'sangat urgent' THEN 1
            WHEN type_complaint = 'urgent' THEN 2
            WHEN type_complaint = 'kurang urgent' THEN 3
            WHEN type_complaint = 'tidak urgent' THEN 4
            ELSE 5
        END
    ") // Prioritas berdasarkan type_complaint
            ->where('status', 'Aduan Ditangani') // Filter hanya Aduan Masuk
            ->orderBy('created_at', 'asc'); // Urutkan berdasarkan created_at secara ascending


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
        $query = Complaint::with('user') // Eager load untuk menghindari N+1 query
            ->select('complaints.*') // Pastikan hanya kolom dari complaints yang diambil langsung
            ->orderByRaw("
        CASE
            WHEN type_complaint = 'sangat urgent' THEN 1
            WHEN type_complaint = 'urgent' THEN 2
            WHEN type_complaint = 'kurang urgent' THEN 3
            WHEN type_complaint = 'tidak urgent' THEN 4
            ELSE 5
        END
    ") // Prioritas berdasarkan type_complaint
            ->where('status', 'Aduan Selesai') // Filter hanya Aduan Masuk
            ->orderBy('created_at', 'asc'); // Urutkan berdasarkan created_at secara ascending


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
