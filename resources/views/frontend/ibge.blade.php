@extends('template');

@section('title', 'IBGE APIs');

@section('content')

<div class="container">
    <div class="row">

        <!-- Container of States and Cities -->
        <div class="col-md-6">
            <div class="col-md-12">
                <div class="alert alert-info text-center" role="alert" style="margin-top: 50px;">
                    Exemple of using an API from IBGE for all brazilian states and their cities. <a href="https://servicodados.ibge.gov.br/api/docs/localidades?versao=1#api-_" target="_blank">Click here to read the docs!</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> States and cities data using Fetch API </div>
                    <div class="card-body">
                        <!-- <form onsubmit="showValues(event, this)"> -->
                            <div class="form-group">
                                <select name="state" class="form-control">
                                    <option value="">Select a state</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="city" class="form-control" disabled>
                                    <option value="">Select a city</option>
                                </select>
                            </div>
                        <!-- <button type="submit" id="showValues" class="btn btn-primary">See Values</button> -->
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Container of Names -->
        <div class="col-md-6">
            <div class="col-md-12">
                <div class="alert alert-info text-center" role="alert" style="margin-top: 50px;">
                    Exemple of using an API from IBGE for brazilian names and their info and stats. <a href="https://servicodados.ibge.gov.br/api/docs/censos/nomes?versao=2" target="_blank">Click here to read the docs!</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Names data using Fetch API </div>
                    <div class="card-body">
                        <a href="#modalNamesRankings" class="badge badge-pill badge-success" style="margin-bottom: 20px;"> See the ranking of brazilian names here!</a>      
                        <form onsubmit="getNameStats(event, this);">              
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Plese enter your name here.">
                            </div>
                            <button class="btn btn-primary" type="submit">See some cool stuffs</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection

@section('script')

<script>
    //Code for the IBGE's States and Cities API 

    function getStates() {
        console.log('On getStates')

        const stateSelect = document.querySelector('select[name=state]');

        fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados')
            .then(response => response.json())
            .then(states => {
                for (const state of states) {
                    stateSelect.innerHTML += `<option value="${state.id}">${state.nome}</option>`;
                }
            });
    }

    getStates();

    function getCities(event) {
        console.log('On getCities');

        const citySelect = document.querySelector('select[name=city]');
        const stateValueId = event.target.value;

        const urlForState = `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${stateValueId}/municipios`;

        citySelect.innerHTML = '<option value="">Select a city</option>';
        citySelect.disabled = true;

        fetch(urlForState)
            .then(response => response.json())
            .then(cities => {
                for (const city of cities) {
                    citySelect.innerHTML += `<option value="${city.nome}">${city.nome}</option>`;
                }
                console.log('Fetched!');

                citySelect.disabled = false;
            });
    }

    document
        .querySelector('select[name=state]')
        .addEventListener('change', getCities);

    // function showValues(event, form) {
    //     const input = event.target;

    //     const stateSelected = input.nome;
    //     const citySelected = input.nome;

    //     const message = `Estado: ${stateSelected}; Cidade: ${citySelected}`;

    //     alert(message);
    // }
    
</script>

<script>
    //Code for the IBGE's Names API

    function getNamesRanking() {
        console.log('On getNamesRanking');

        const url = 'https://servicodados.ibge.gov.br/api/v2/censos/nomes/ranking';

        fetch(url) 
            .then(response => response.json())
            .then(names => {
                console.log(names);
            });
    }

    getNamesRanking();

    function getNameStats(event, form) {
        console.log('On getNameStats');

        event.preventDefault();

        const inputName = form.name;

        if (inputName) {
            const nameValue = inputName.value;
            const url = `https://servicodados.ibge.gov.br/api/v2/censos/nomes/${nameValue}`;

            fetch(url)
                .then(response => response.json())
                .then(nameStats => modalNameInfo(nameStats));
        }
    }

    //Issue: undefined fields
    function modalNameInfo(name) {
        console.log(name);
        
        const message = `
            Nome que você digitou: ${name.nome},
            Localidade: ${name.localidade}
        `;

        alert(message);
    }

</script>
    
@endsection