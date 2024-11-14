<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_DailyMaterialReport extends Model
{
    use HasFactory;

    protected $table = 'daily_material_reports';
    protected $guarded = ['id'];
    public $timestamps = true;

}
