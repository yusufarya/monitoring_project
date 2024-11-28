<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_BalanceReport extends Model
{
    use HasFactory;

    protected $table = 'balance_reports';
    protected $guarded = ['id'];
    public $timestamps = true;
}

