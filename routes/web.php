<?php

use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * Route for testing arrays and operations -> Just for testing some random stuff, do not consider!
 */
Route::get('/arrays', function () {
    $array = [
        'Element 0',
        'Element 1 ',
        120 => 'Element 120 (you can set a key in any element)',
        'Element 121',
        'Element 122 (and it goes on...)',
        'custom key' => 'Thats a custom key'
    ];

    dd($array['custom key']);
});

/**
 * APIs on frontend of software
 */
Route::group(['prefix' => 'frontend'], function () {
    
    /**
     * APIs that evolves CEP searching
     */
    Route::get('/cep', function () {
        return view('frontend.cep');
    });
    
    /**
     * APIs from ibge data services
     */
    Route::get('/ibge', function () {
        return view('frontend.ibge');
    });
});


/**
 * APIs on backend of software
 */
Route::group(['prefix' => 'backend'], function () {
    
    /**
     * Testing how APIs usually work -> Just for testing some random stuff, do not consider!
     */
    Route::get('/test/{id}', function ($id) {
    
        switch($id) {
            case 1:
                $client = new Client();
                $response = $client->request('GET', 'https://api.github.com/repos/RafaelEmery/blog-laravel');
                
                return $response->getBody();
            break;
            case 2:
                $client = new Client();
                $response = $client->request('GET', 'https://api.github.com/RafaelEmery', [
                    'auth' => ['RafaelEmery', 'my_github_password']
                ]);

                return $response->getBody();
            break;
        }
        
    });

    /**
     * Tronald Dump API for Trump's random dumbest stuffs
     */
    Route::get('/dump/random', function () {
        
        $client = new Client([
            'base_uri' => 'https://api.tronalddump.io',
            'headers' => [
                'Accept' => 'application/hal+json'
            ],
        ]);
        $response = $client->get('/random/quote');

        $body = $response->getBody();

        $fullQuote = json_decode($body, true);
        
        //Quote "attributes"
        //Issue: change the format of $quoteDate to better reading
        $quoteUrl = $fullQuote['_embedded']['source'][0]['url'];
        $quoteDate = $fullQuote['appeared_at'];
        $quote = $fullQuote['value'];

        return $result = 
        'Url: '.$quoteUrl.
        ', Date: '.$quoteDate.
        ', Dump stuff: '.$quote;
        
    });

    /**
     * Tronald Dump API for Trump's dumbest stuffs searching by author's id
     */
    Route::get('dump/author/{id}', function ($id) {
        
        $client = new Client([
            'base_uri' => 'https://api.tronalddump.io/',
            'headers' => [
                'Accept' => 'application/hal+json'
            ],
        ]);
        $response = $client->request('GET', 'author/'.$id);

        $body = $response->getBody();

        $dd(json_decode($body, true));
    });

    /**
     * Postmon for brazilian CEP fast consulting
     */
    Route::get('/cep/{cep}', function ($cep) {

        $client = new Client([
            'base_uri' => 'https://api.postmon.com.br/v1/'
        ]);
        $response = $client->request('GET', 'cep/'.$cep);

        $body = $response->getBody();
        
        //Now we have and array
        $cepInfo = json_decode($body, true);

        return $result = 
        'Address: '.$cepInfo['logradouro'].
        ', Neighborhood: '.$cepInfo['bairro'].
        ', City: '.$cepInfo['cidade'].
        ', State: '.$cepInfo['estado_info']['nome'];
    });

    /**
     * Using a Controller for consuming APIs 
     */
    Route::get('/controller', 'ApiController@method');

    /**
     * Controller and routes for Rick and Morty's APIs
     */
    Route::get('/rickandmorty/allcharacters', 'RickAndMortyController@allcharacters');
});