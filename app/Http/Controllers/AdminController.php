<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Admin';
        return view('page-admin.index', compact('title'));
    }

    public function getDataComplaint(Request $request)
    {
        $query = Complaint::with('user');

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
