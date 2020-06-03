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
 * APIs on frontend of software
 */
Route::group(['prefix' => 'frontend'], function () {
    
    /**
     * APIs that evolves CEP searching
     */
    Route::get('/cep', function () {
        return view('cep');
    });
    
    /**
     * APIs from ibge data services
     */
    Route::get('/ibge', function () {
        return view('ibge');
    });
});


/**
 * APIs on backend of software
 */
Route::group(['prefix' => 'backend'], function () {
    
    /**
     * Testing how APIs usually work
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
                    'auth' => ['RafaelEmery', 'pass']
                ]);

                dd($response);
            break;
        }
        
    });

    /**
     * Tronald Dump API for Trump's dumbest stuffs
     */
    Route::get('/dump/random', function () {
        
        $client = new Client([
            'base_uri' => 'https://api.tronalddump.io',
            'headers' => [
                'Accept' => 'application/hal+json'
            ],
        ]);
        $response = $client->request('GET', '/random/quote');

        return $response->getBody();
    });

    Route::get('dump/author/{id}', function ($id) {
        
        $client = new Client([
            'base_uri' => 'https://api.tronalddump.io',
            'headers' => [
                'Accept' => 'application/hal+json'
            ],
        ]);
        $response = $client->request('GET', '/author/{id}');

        return $response->getBody();
    });

    /**
     * Postmon for brazilian CEP fast consulting
     */
    Route::get('/cep/{cep}', function ($cep) {

        $client = new Client([
            'base_uri' => 'https://api.postmon.com.br/v1/'
        ]);
        $response = $client->request('GET', 'cep/' ,[
            'cep_a_consultar' => $cep
        ]);

        return $response->getBody();
    });
});