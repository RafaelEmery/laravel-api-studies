## About this repo

The original idea is to learn about external REST APIs using Laravel and pure Javascript and i was motivated by a [repo with a lot of public APIs](https://github.com/public-apis/public-apis#index). In the frontend Javascript i used the *fetch* function and in the backend (Laravel) i used the GuzzleHttp package.

### Whats Next?

This repo is still in use for studies, check the commits to watch the stuff that i'm learning and coding! Currently i'm looking foward to use Laravel Socialite, *OAuth* APIs, axios library for JS and some other usefull techs.

### Routes

- For the frontend studies you can use */frontend/name_of_the_API*
- For the frontend studies you can use */backend/name_of_the_API*
- For some other features consult the *web.php*

### APIs used

- IBGE public data
- Tronald Dump
- Search CEP by Matheus Castiglioni
- Postmon
- Rick and Morty API

## Example of consuming third party APIs

Here are some things i made.

### Frontend 

![](/public/readme-src/frontend-ibge)

The Javascript code at the *script* tag for getting all the states:

````javascript
//Using fetch for add the brazilian states on a select input
function getStates() {
    console.log('On getStates')

    const stateSelect = document.querySelector('select[name=state]');

    //Requesting all the states from IBJE
    fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados')
        .then(response => response.json())
        .then(states => {
            for (const state of states) {

                //Adding a option for each state in Brazil
                stateSelect.innerHTML += `<option value="${state.id}">${state.nome}</option>`;
            }
        });
}
````

### Backend

Using the GuzzleHttp package we can consume external APIs very fast and simple:

````php
use GuzzleHttp\Client;

/**
 * Postmon for brazilian CEP fast consulting
 */
Route::get('/cep/{cep}', function ($cep) {

    $client = new Client([
        'base_uri' => 'https://api.postmon.com.br/v1/'
    ]);

    //Or we can use $client->get('cep/'.$cep)
    $response = $client->request('GET', 'cep/'.$cep);

    $body = $response->getBody();
    
    //Now we have an array
    $cepInfo = json_decode($body, true);

    //Returning fast info at the view
    return $result = 
    'Address: '.$cepInfo['logradouro'].
    ', Neighborhood: '.$cepInfo['bairro'].
    ', City: '.$cepInfo['cidade'].
    ', State: '.$cepInfo['estado_info']['nome'];
});
````