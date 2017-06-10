<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
