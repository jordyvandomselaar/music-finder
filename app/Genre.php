<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    protected $guarded = ['id'];

    public function artists(): BelongsToMany {
        return $this->belongsToMany(Artist::class);
    }

    public function albumns(): BelongsToMany {
        return $this->belongsToMany(Album::class);
    }
}
