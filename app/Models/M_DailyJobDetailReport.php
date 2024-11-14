<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_DailyJobDetailReport extends Model
{
    use HasFactory;

    protected $table = 'daily_job_report_details';
    protected $guarded = ['id'];
    public $timestamps = true;

}
