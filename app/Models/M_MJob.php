<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_MJob extends Model
{
    use HasFactory;

    protected $table = 'm_jobs';
    protected $fillable = [
        'code',
        'name',
        'unit',
        'price',
    ];
    // public $timestamps = false;
}
