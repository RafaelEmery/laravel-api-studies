@extends('template')

@section('title', 'API de CEP')

@section('content')

<div class="container">
    <div class="col-md-6">
        <div class="alert alert-info text-center" role="alert" style="margin-top: 50px;">
            Exemple of using a third party API for searching brazilian CEP
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"> CEP searching using Fetch API </div>
            <div class="card-body">
                <form action="">
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

</script>

@endsection
    
