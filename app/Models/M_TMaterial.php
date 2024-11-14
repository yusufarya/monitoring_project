<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_TMaterial extends Model
{
    use HasFactory;

    protected $table = 't_materials';
    protected $guarded = ['id'];
    public $timestamps = true;
    // protected $fillable = [
    //     'code',
    //     'name',
    //     'unit',
    //     'price',
    // ];
}
