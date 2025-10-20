<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Un type peut avoir plusieurs plantes
    public function plants()
    {
        return $this->hasMany(Plant::class);
    }
}
