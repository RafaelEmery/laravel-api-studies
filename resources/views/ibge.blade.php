@extends('template');

@section('title', 'IBGE APIs');

@section('content')

<div class="container">
    <div class="col-md-6">
        <div class="alert alert-info text-center" role="alert" style="margin-top: 50px;">
            Exemple of using an API from IBGE for all brazilian states and their cities. <a href="https://servicodados.ibge.gov.br/api/docs/localidades?versao=1#api-_" target="_blank">Click here to read the doc!</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"> States and cities data using Fetch API </div>
            <div class="card-body">
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
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    
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
        //Issue: concatenando cidades, o certo era apagar todas as options ao trocarmos o estado...

        const citySelect = document.querySelector('select[name=city]');
        const stateValueId = event.target.value;

        const urlForState = `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${stateValueId}/municipios`;

        fetch(urlForState)
            .then(response => response.json())
            .then(cities => {
                for (const city of cities) {
                    citySelect.innerHTML += `<option value="${city.id}">${city.nome}</option>`;
                }

                citySelect.disabled = false;
            });
    }

    document
        .querySelector('select[name=state]')
        .addEventListener('change', getCities);
    
</script>
    
@endsection