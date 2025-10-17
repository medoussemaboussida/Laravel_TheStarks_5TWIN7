<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicationLike extends Model
{
    protected $fillable = ['user_id', 'publication_id', 'type'];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Publication
    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }
}
