<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/socialite/spotify/redirect', 'Auth\SpotifyController@redirect')->name('socialite.spotify.redirect');
Route::get('/socialite/spotify/callback', 'Auth\SpotifyController@callback');

Route::resource('suggestions', 'SuggestionsController');
