<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SpotifyController extends Controller
{
    public function redirect()
    {
        return Socialite::with('spotify')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('spotify')->user();
    }
}
