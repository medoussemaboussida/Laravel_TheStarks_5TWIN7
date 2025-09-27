<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'date_debut',
        'date_fin',
        'statut',
        'budget',
        'localisation'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'budget' => 'decimal:2'
    ];

    /**
     * Relation avec les événements
     * Un projet peut avoir plusieurs événements
     */
    public function evenements(): HasMany
    {
        return $this->hasMany(Evenement::class);
    }
}
