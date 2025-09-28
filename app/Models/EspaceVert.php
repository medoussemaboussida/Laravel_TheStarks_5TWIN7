<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EspaceVert extends Model
{
    protected $fillable = [
        'nom',
        'adresse',
        'superficie',
        'type',
        'etat',
        'besoin_specifique',
    ];
    public function rapportBesoins()
    {
return $this->hasMany(RapportBesoin::class, 'espace_vert_id');
    }
}
