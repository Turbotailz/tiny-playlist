<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Playlist;

class PlaylistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Get the user's playlists
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getUserPlaylists()
    {
        return response()->json([
            'user' => Auth::user(),
        ]);
    }

    /**
     * Get a list of playlists
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showPlaylists()
    {
        return Playlist::all();
    }

    /**
     * Get a single playlist
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPlaylist(Playlist $playlist)
    {
        return $playlist;
    }

    /**
     * Create a playlist
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createPlaylist(Request $request)
    {
        $playlist = Playlist::create($request->all());

        return response()->json($playlist, 201);
    }

    /**
     * Update a playlist
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updatePlaylist(Request $request, Playlist $playlist)
    {
        $playlist->update($request->all());

        return response()->json($playlist, 200);
    }

    /**
     * Delete a playlist
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deletePlaylist(Playlist $playlist)
    {
        $playlist->delete();

        return response()->json(null, 204);
    }
}
