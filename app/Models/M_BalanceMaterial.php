<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_BalanceMaterial extends Model
{
    use HasFactory;

    protected $table = 'balance_materials';
    protected $guarded = ['id'];
    public $timestamps = true;
}

