@extends('layout')

@section('content')
    <h1>Welcome to music finder!</h1>
    <h2>Log in with Spotify</h2>
    <a href="{{ route('socialite.spotify.redirect') }}">Log in with Spotify</a>

    <h2>Or create a new Suggestion instead</h2>
    <form action="{{route('suggestions.store')}}">
        <label for="artist">Artist to create new suggestion from</label>
        <input id="artist" type="text" placeholder="Enter artist to create new suggestion from">
        <input type="submit" value="create">
    </form>
@endsection
