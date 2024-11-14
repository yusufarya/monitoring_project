<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_MaterialPickup extends Model
{
    use HasFactory;

    protected $table = 'material_pickups';
    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(M_MaterialPickupDetail::class, 'material_pickup_id', 'id');
    }
}
