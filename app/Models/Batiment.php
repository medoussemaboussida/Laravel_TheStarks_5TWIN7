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
        'emissionCO2',
        'nbHabitants',
        'nbEmployes',
        'typeIndustrie',
        'pourcentageRenouvelable',
        'emissionReelle',
        'zone_id',
    ];

    protected $casts = [
        'emissionCO2' => 'float',
        'pourcentageRenouvelable' => 'float',
        'emissionReelle' => 'float',
        'nbHabitants' => 'integer',
        'nbEmployes' => 'integer',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(ZoneUrbaine::class, 'zone_id');
    }

    public function setEmissionCO2Attribute($value)
    {
        $this->attributes['emissionCO2'] = (float) $value;
        $this->attributes['emissionReelle'] = $this->calculateEmissionReelle(
            (float) $value,
            $this->attributes['pourcentageRenouvelable'] ?? 0.0
        );
    }

    public function setPourcentageRenouvelableAttribute($value)
    {
        $this->attributes['pourcentageRenouvelable'] = (float) $value;
        $this->attributes['emissionReelle'] = $this->calculateEmissionReelle(
            $this->attributes['emissionCO2'] ?? 0.0,
            (float) $value
        );
    }

    private function calculateEmissionReelle(float $co2, float $pct): float
    {
        return $co2 * (1 - $pct / 100);
    }

    public function getNbArbresBesoinAttribute(): int
    {
        return (int) ceil(($this->emissionReelle ?? 0.0) / 0.02);
    }
}
