<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'konteks',
        'value',
    ];
}
