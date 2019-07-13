<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\SpotifyUser;
use Laravel\Socialite\Facades\Socialite;

class SpotifyController extends Controller
{
    public function redirect()
    {
        return Socialite::with('spotify')->scopes(['user-top-read'])->redirect();
    }

    public function callback()
    {
        $user = Socialite::with('spotify')->user();

        SpotifyUser::firstOrCreate(
            [
                'spotify_id' => $user->id,
            ],
            [
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken,
            ]
        );

        return redirect('/');
    }
}
