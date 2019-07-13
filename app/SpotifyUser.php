<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SpotifyUser extends Model
{
    protected $guarded = ['id'];

    public function tracks(): BelongsToMany {
        return $this->belongsToMany(Track::class);
    }
}
