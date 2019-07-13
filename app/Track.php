<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Track extends Model
{
    protected $guarded = ['id'];

    public function album(): BelongsTo {
        return $this->belongsTo(Album::class);
    }

    public function artists(): BelongsToMany {
        return $this->belongsToMany(Artist::class);
    }

    public function playlists(): BelongsToMany {
        return $this->belongsToMany(Playlist::class);
    }

    public function spotifyUsers(): BelongsToMany {
        return $this->belongsToMany(SpotifyUser::class);
    }
}
