<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_TJob extends Model
{
    use HasFactory;

    protected $table = 't_jobs';
    protected $guarded = ['id'];
    public $timestamps = true;
    // protected $fillable = [
    //     'code',
    //     'name',
    //     'unit',
    //     'price',
    // ];
}
