@extends('layouts.app')

@section('content')

@auth

<app :user="{ name: '{{ Auth::user()->name }}', token: '{{ Auth::user()->api_token }}' }" />

@else

<div class="container-fluid welcome">
    <div class="content">
        <h1>Tiny Playlist</h1>
        <p class="subtitle">A quick way to share music playlists</p>
        
        <div class="top-right links">
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
                or
                <a href="{{ route('register') }}">Register</a>
            @endif
        </div>
    </div>
</div>

@endauth

@endsection