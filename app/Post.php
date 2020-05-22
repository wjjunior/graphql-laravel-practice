<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    //
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function comments() : HasMany
    {
        return $this->hasMany('App\Comment');
    }
}
