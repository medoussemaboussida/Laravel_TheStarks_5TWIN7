<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'evenement_id',
        'statut',
        'commentaire',
        'date_inscription'
    ];

    protected $casts = [
        'date_inscription' => 'datetime'
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'événement
     */
    public function evenement(): BelongsTo
    {
        return $this->belongsTo(Evenement::class);
    }
}
