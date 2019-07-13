<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Album extends Model
{
    protected $guarded = ['id'];

    public function genres(): BelongsToMany {
        return $this->belongsToMany(Genre::class);
    }

    public function artists(): BelongsToMany {
        return $this->belongsToMany(Artist::class);
    }
}
