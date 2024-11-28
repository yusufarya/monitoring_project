<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_BalanceReportDetail extends Model
{
    use HasFactory;

    protected $table = 'balance_report_details';
    protected $guarded = ['id'];
    public $timestamps = true;
}
