<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'public',
    ];

    /**
     * The attributes that should be appended to JSON responses
     * 
     * @var array
     */
    protected $appends = ['songs', 'artwork'];

    /**
     * Get the playlist owner
     * 
     * @return \App\User
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the playlist songs as an attribute
     * 
     * @return array
     */
    public function getSongsAttribute() {
        return $this->songs()->get();
    }

    /**
     * Get the playlist songs
     */
    public function songs() {
        return $this->belongsToMany('App\Song');
    }


    /**
     * Get the playlist artwork as an attribute
     * 
     * @return array
     */
    public function getArtworkAttribute() {
        return $this->getPlaylistArt();
    }

    /**
     * Get the playlist's top artwork
     * 
     * @return array
     */
    public function getPlaylistArt() {
        $songs = $this->songs()->limit(4)->get();
        $art = [];

        foreach($songs as $song) {
            $art[] = $song->art_large;
        }

        return $art;
    }
}
