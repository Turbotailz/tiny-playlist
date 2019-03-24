<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'playlists' => 'array',
    ];

    /**
     * The attributes that should be appended to JSON responses
     * 
     * @var array
     */
    protected $appends = ['playlists'];

    /**
     * Get the user's playlist as an attribute
     * 
     * @return array
     */
    public function getPlaylistsAttribute() {
        return $this->playlists()->get();
    }

    /**
     * Get the user's playlists
     */
    public function playlists() {
        return $this->hasMany('App\Playlist');
    }
}
