<?php

namespace App;

use Illuminate\Database\Eloquent\Model,
    Auth;

class Media extends Model
{
    protected $guarded = [];

    protected $appends = ['is_liked'];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getIsLikedAttribute()
    {
        return $this->likes()->pluck('likable_id')->contains(Auth::id());
    }
}
