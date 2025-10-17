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

    // Relationship with likes/dislikes
    public function likes()
    {
        return $this->hasMany(PublicationLike::class)->where('type', 'like');
    }

    public function dislikes()
    {
        return $this->hasMany(PublicationLike::class)->where('type', 'dislike');
    }

    // Get likes count
    public function getLikesCount()
    {
        return $this->likes()->count();
    }

    // Get dislikes count
    public function getDislikesCount()
    {
        return $this->dislikes()->count();
    }

    // Check if user has liked
    public function hasUserLiked($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    // Check if user has disliked
    public function hasUserDisliked($userId)
    {
        return $this->dislikes()->where('user_id', $userId)->exists();
    }
}
