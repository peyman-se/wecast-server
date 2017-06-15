<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    
}
