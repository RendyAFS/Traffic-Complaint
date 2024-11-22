<?php

namespace App\Imports;

use App\Models\Complaint;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ComplaintsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Complaint([
            'users_id' => $row['users_id'],
            'text_complaint' => $row['text_complaint'],
            'type_complaint' => $row['type_complaint'],
            'lokasi' => $row['lokasi'],
            'status' => 'Aduan Masuk',
            'gambar' => null,
        ]);
    }
}
