@extends('layout')

@section('content')
    <h1>Welcome to music finder!</h1>
    <h2>Please log in</h2>
    <a href="{{ route('socialite.spotify.redirect') }}">Log in with Spotify</a>
@endsection
