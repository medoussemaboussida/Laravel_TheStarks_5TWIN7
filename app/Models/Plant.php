<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'age', 'location', 'plant_type_id'];

    // Une plante appartient à un type
    public function type()
    {
        return $this->belongsTo(PlantType::class, 'plant_type_id');
    }
}

