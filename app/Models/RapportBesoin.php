<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RapportBesoin extends Model
{
     protected $fillable = [
        'date_rapport',
        'description',
        'priorite',
        'cout_estime',
        'statut',
        'espace_vert_id',
    ];
    public function espaceVert()
    {
        return $this->belongsTo(EspaceVert::class);
    }
     protected $casts = [
        'date_rapport' => 'date',
        'cout_estime' => 'float',
    ];
}
