<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    protected $fillable = [
        'titre',
        'image',
        'description',
    ];

    // Relation avec l'utilisateur (auteur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
