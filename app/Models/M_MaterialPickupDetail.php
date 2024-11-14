<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_MaterialPickupDetail extends Model
{
    use HasFactory;

    protected $table = 'material_pickup_details';
    protected $guarded = ['id'];
}
