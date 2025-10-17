<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Batiment extends Model
{
    use HasFactory;

    protected $table = 'batiments';

    protected $fillable = [
        'type_batiment',
        'adresse',
        'emission_c_o2',
        'nb_habitants',
        'nb_employes',
        'type_industrie',
        'pourcentage_renouvelable',
        'emission_reelle',
        'zone_id',
    ];

    protected $casts = [
        'emission_c_o2' => 'float',
        'pourcentage_renouvelable' => 'float',
        'emission_reelle' => 'float',
        'nb_habitants' => 'integer',
        'nb_employes' => 'integer',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(ZoneUrbaine::class, 'zone_id');
    }

    public function setEmissionCO2Attribute($value)
    {
        $this->attributes['emission_c_o2'] = (float) $value;
        $this->attributes['emission_reelle'] = $this->calculateEmissionReelle(
            (float) $value,
            $this->attributes['pourcentage_renouvelable'] ?? 0.0
        );
    }

    public function setPourcentageRenouvelableAttribute($value)
    {
        $this->attributes['pourcentage_renouvelable'] = (float) $value;
        $this->attributes['emission_reelle'] = $this->calculateEmissionReelle(
            $this->attributes['emission_c_o2'] ?? 0.0,
            (float) $value
        );
    }

    private function calculateEmissionReelle(float $co2, float $pct): float
    {
        return $co2 * (1 - $pct / 100);
    }

    public function getNbArbresBesoinAttribute(): int
    {
        return (int) ceil(($this->emission_reelle ?? 0.0) / 0.02);
    }

    // Accesseurs pour les anciens noms
    public function getEmissionCO2Attribute()
    {
        return $this->attributes['emission_c_o2'] ?? 0.0;
    }

    public function getNbHabitantsAttribute()
    {
        return $this->attributes['nb_habitants'] ?? null;
    }

    public function getNbEmployesAttribute()
    {
        return $this->attributes['nb_employes'] ?? null;
    }
}
