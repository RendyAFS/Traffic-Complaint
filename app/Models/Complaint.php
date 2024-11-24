<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $fillable = [
        'users_id',
        'text_complaint',
        'type_complaint',
        'category_complaint',
        'lokasi',
        'status',
        'gambar',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'users_id');
    }
    public function history(){
        return $this->hasMany(Historys::class, 'complaints_id');
    }
}
