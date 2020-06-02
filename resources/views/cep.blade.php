@extends('template')

@section('title', 'API de CEP')

@section('content')

<div class="container">
    <div class="col-md-6">
        <div class="alert alert-info text-center" role="alert" style="margin-top: 50px;">
            Exemple of using a specific third party API for searching brazilian CEP. <a href="https://blog.matheuscastiglioni.com.br/realizando-requisicoes-ajax-com-fetch-api/" target="_blank">Click here to see the article!</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"> CEP searching using Fetch API </div>
            <div class="card-body">
                <form onsubmit="searchCep(event, this);">
                    <div class="form-group">
                        <input type="text" name="cep" id="cep" class="form-control" placeholder="Digite seu CEP aqui">
                    </div>
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>

    function searchCep(event, form) {
        event.preventDefault(); 
        const inputCep = form.cep;

        if (inputCep) {
            const cep = inputCep.value;

            if (cep.length === 8) {
                const URL = `http://ws.matheuscastiglioni.com.br/ws/cep/find/${cep}/json`;

                fetch(URL)
                    .then(response => response.json())
                    .then(data => showResponse(data))
                    .catch(error => console.error(error));
            }
        }
    }

    function showResponse(cep) {
        const message = `
            CEP: ${cep.cep},
            Logradouro: ${cep.logradouro},
            Complemento: ${cep.complemento},
            Bairro: ${cep.bairro},
            Cidade: ${cep.cidade},
            Estado: ${cep.estado}
        `;

        alert(message);
    }

</script>

@endsection
    
