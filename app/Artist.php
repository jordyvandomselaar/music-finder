<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Artist extends Model
{
    protected $guarded = ['id'];

    public function albums(): BelongsToMany {
        return $this->belongsToMany(Album::class);
    }

    public function tracks(): BelongsToMany {
        return $this->belongsToMany(Track::class);
    }

    public function genres(): BelongsToMany {
        return $this->belongsToMany(Genre::class);
    }
}
