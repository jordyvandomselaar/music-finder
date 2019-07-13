<?php

namespace App\Http\Controllers;

use App\Artist;
use Illuminate\Http\Request;

class SuggestionsController extends Controller
{
    public function store(Request $request)
    {
        $artistName = $request->artist;

        $artist = Artist::where('name', $artistName)->first();
    }
}
