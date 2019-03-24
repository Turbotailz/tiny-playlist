<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', 'PlaylistController@getUserPlaylists');

Route::middleware('auth:api')->get('/playlists', 'PlaylistController@showPlaylists');
Route::middleware('auth:api')->get('/playlist/{playlist}', 'PlaylistController@getPlaylist');
Route::middleware('auth:api')->post('/playlist', 'PlaylistController@createPlaylist');
Route::middleware('auth:api')->put('/playlist/{playlist}', 'PlaylistController@updatePlaylist');
Route::middleware('auth:api')->delete('/playlist/{playlist}', 'PlaylistController@deletePlaylist');
