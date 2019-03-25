<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'artist', 'mbid', 'url', 'art_small', 'art_medium', 'art_large', 'art_extralarge',
    ];

    /**
     * Get the playlists a song belongs to
     */
    public function playlists() {
        return $this->belongsToMany('App\Playlist');
    }
}
