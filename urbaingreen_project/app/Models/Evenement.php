<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evenement extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'date_debut',
        'date_fin',
        'lieu',
        'nombre_participants_max',
        'statut',
        'projet_id'
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime'
    ];

    /**
     * Relation avec le projet
     * Un événement appartient à un projet
     */
    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    /**
     * Relation avec les inscriptions
     */
    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    /**
     * Relation many-to-many avec les utilisateurs via les inscriptions
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'inscriptions')
                    ->withPivot('statut', 'commentaire', 'date_inscription')
                    ->withTimestamps();
    }

    /**
     * Obtenir le nombre de participants inscrits
     */
    public function getNombreParticipantsAttribute(): int
    {
        return $this->inscriptions()->where('statut', 'confirmee')->count();
    }

    /**
     * Vérifier si l'événement est complet
     */
    public function isComplet(): bool
    {
        if (!$this->nombre_participants_max) {
            return false;
        }

        return $this->nombre_participants >= $this->nombre_participants_max;
    }

    /**
     * Vérifier si un utilisateur est inscrit à cet événement
     */
    public function userIsInscrit(User $user): bool
    {
        return $this->inscriptions()
                    ->where('user_id', $user->id)
                    ->exists();
    }

    /**
     * Obtenir le statut d'inscription d'un utilisateur
     */
    public function getStatutInscription(User $user): ?string
    {
        $inscription = $this->inscriptions()
                           ->where('user_id', $user->id)
                           ->first();

        return $inscription ? $inscription->statut : null;
    }
}
