<?php

namespace App\Http\Controllers;

use App\Services\ImdbScraper;

class ImdbController extends Controller
{
    public function search(ImdbScraper $imdb)
    {
        return response()->json(
            $imdb->search('Naruto'),
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show(ImdbScraper $imdb)
    {
        return response()->json($imdb->getMovie('tt1375666'));
    }
}
