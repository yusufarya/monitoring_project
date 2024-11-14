<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Project extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $guarded = ['id'];
    public $timestamps = true;



}
