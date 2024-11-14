<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_DailyMaterialDetailReport extends Model
{
    use HasFactory;

    protected $table = 'daily_material_report_details';
    protected $guarded = ['id'];
    public $timestamps = true;

}
