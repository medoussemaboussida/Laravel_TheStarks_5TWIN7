<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ZoneUrbaine extends Model
{
    use HasFactory;

    protected $table = 'zones_urbaines';

    protected $fillable = [
        'nom',
        'population',
        'surface',
        'niveauPollution',
        'nbArbresExist',
    ];

    protected $casts = [
        'population' => 'integer',
        'surface' => 'float',
        'niveauPollution' => 'float',
        'nbArbresExist' => 'integer',
    ];

    public function batiments(): HasMany
    {
        return $this->hasMany(Batiment::class, 'zone_id');
    }

    /**
     * Calcul automatique du besoin en arbres (nbArbresBesoin)
     * Supposons : 1 arbre absorbe 0.02 t CO₂ / an
     */
    public function getNbArbresBesoinAttribute(): int
    {
        $totalEmission = 0;
        foreach ($this->batiments as $b) {
            $totalEmission += $b->emissionReelle ?? 0;
        }
        return (int) ceil($totalEmission / 0.02);
    }

    public function __toString(): string
    {
        return (string) $this->nom;
    }
}
