<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

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
        'type_zone_urbaine',
        'recyclage_data',
        'energies_renouvelables_data',
        'user_id',
    ];

    protected $casts = [
        'emission_c_o2' => 'float',
        'pourcentage_renouvelable' => 'float',
        'emission_reelle' => 'float',
        'nb_habitants' => 'integer',
        'nb_employes' => 'integer',
        'recyclage_data' => 'array',
        'energies_renouvelables_data' => 'array',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(ZoneUrbaine::class, 'zone_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    // Mutateurs pour les anciens noms (compatibilité)
    public function setNbHabitantsAttribute($value)
    {
        $this->attributes['nb_habitants'] = $value;
    }

    public function setNbEmployesAttribute($value)
    {
        $this->attributes['nb_employes'] = $value;
    }

    public function setTypeIndustrieAttribute($value)
    {
        $this->attributes['type_industrie'] = $value;
    }

    // Accesseur pour les données de recyclage (toujours retourner un tableau)
    public function getRecyclageDataAttribute()
    {
    return $this->attributes['recyclage_data']
        ? json_decode($this->attributes['recyclage_data'], true)
        : [];
}

    // Mutateur pour s'assurer que les données de recyclage sont correctement formatées
    public function setRecyclageDataAttribute($value)
    {
        if (is_array($value)) {
            // S'assurer que quantites est toujours un tableau avec des valeurs numériques
            if (isset($value['quantites']) && is_array($value['quantites'])) {
                foreach ($value['quantites'] as $key => $quantite) {
                    $value['quantites'][$key] = (float) $quantite;
                }
            }
            $this->attributes['recyclage_data'] = json_encode($value);
        } elseif (is_string($value)) {
            $this->attributes['recyclage_data'] = $value;
        } else {
            $this->attributes['recyclage_data'] = null;
        }
    }

    // Accesseur pour vérifier si le recyclage existe
    public function getRecyclageExisteAttribute()
    {
        $data = $this->recyclageData;
        return $data && isset($data['existe']) && $data['existe'];
    }

    // Accesseur pour vérifier si les énergies renouvelables existent
    public function getEnergiesRenouvelablesExisteAttribute()
    {
        $data = $this->energiesRenouvelablesData;
        return !empty($data);
    }

    public function setEnergiesRenouvelablesDataAttribute($value)
    {
        $this->attributes['energies_renouvelables_data'] = json_encode($value);
    }

    public function getEnergiesRenouvelablesDataAttribute($value)
{
    // Si Laravel te renvoie déjà un array
    if (is_array($value)) {
        return $value;
    }

    // Si c’est une chaîne JSON doublement encodée, on décode deux fois
    if (is_string($value)) {
        $decoded = json_decode($value, true);

        // Si le premier decode donne encore une string JSON, on redécode
        if (is_string($decoded)) {
            $decoded = json_decode($decoded, true);
        }

        return is_array($decoded) ? $decoded : [];
    }

    return [];
}

    // Accesseur pour le type de zone urbaine formaté
    public function getTypeZoneUrbaineFormattedAttribute()
    {
        $types = [
            'zone_industrielle' => 'Zone Industrielle',
            'quartier_residentiel' => 'Quartier Résidentiel',
            'centre_ville' => 'Centre Ville'
        ];

        return $this->type_zone_urbaine ? ($types[$this->type_zone_urbaine] ?? $this->type_zone_urbaine) : null;
    }
}
