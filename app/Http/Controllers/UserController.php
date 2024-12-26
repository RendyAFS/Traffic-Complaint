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
        $title = Auth::user()->name; // Ambil nama dari Auth
        return view('page-user.index', compact('title'));
    }

    // Method untuk simpan aduan
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
                    $situasi[] = $group[0]; // Gunakan istilah utama dari situasi
                    break;
                }
            }
        }

        // Cari tempat berdasarkan sinonim dalam teks aduan
        foreach ($vocabTempat as $location => $synonyms) {
            foreach ($synonyms as $synonym) {
                if (stripos($text, $synonym) !== false) {
                    $tempat[] = $location; // Hanya tambahkan lokasi utama
                    break; // Stop iterasi jika satu sinonim cocok
                }
            }
        }

        // Proses input lokasi (validasi dengan sinonim di vocabTempat)
        if (!empty($inputLokasi)) {
            foreach ($vocabTempat as $location => $synonyms) {
                foreach ($synonyms as $synonym) {
                    if (stripos($inputLokasi, $synonym) !== false) {
                        $tempat[] = $location; // Tambahkan lokasi yang valid
                        break 2; // Stop iterasi setelah lokasi cocok
                    }
                }
            }
        }

        // Prioritaskan lokasi dari teks aduan
        if (empty($tempat)) {
            $tempat[] = $inputLokasi; // Jika tidak ditemukan lokasi valid, gunakan input mentah
        } else {
            $tempat = [reset($tempat)]; // Ambil lokasi pertama dari hasil pencarian
        }

        // Gabungkan kategori
        $situasiStr = implode(', ', array_unique($situasi));
        $tempatStr = implode(', ', array_unique($tempat));

        return $situasiStr . ($tempatStr ? ", " . $tempatStr : '');
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
