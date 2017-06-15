<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = [];
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
}
