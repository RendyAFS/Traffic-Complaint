<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historys extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaints_id',
    ];
    public function complaint(){
        return $this->belongsTo(Complaint::class, 'complaints_id');
    }
}
