<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_BalanceMaterialDetail extends Model
{
    use HasFactory;

    protected $table = 'balance_material_details';
    protected $guarded = ['id'];
    public $timestamps = true;
}
