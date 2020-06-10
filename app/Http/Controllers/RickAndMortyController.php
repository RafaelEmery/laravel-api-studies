<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class RickAndMortyController extends Controller
{  

    public function allCharacters() {

        $client = new Client([
            'base_url' => 'https://rickandmortyapi.com/api/',
        ]);

        return true;
    }
}
