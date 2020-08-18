@extends('template')

@section('title', 'Open Weather Map API')
    
@section('content')

<div class="container">
    <div class="row">


        <!-- Container for Weather by name testing -->
        <div class="col-md-6">
            <div class="col-md-12">
                <div class="alert alert-info text-center" role="alert" style="margin-top: 50px;">
                    We are Groot. I am Groot. I am Groot. We are Groot. We are Groot. I am Groot. We are Groot. We are Groot. I am Groot. We are Groot. We are Groot. We are Groot. We are Groot.
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Open Weather API data using Fetch API </div>
                    <div class="card-body">
                        <form onsubmit="searchCity(event, this);">
                            <div class="form-group">
                                <input type="text" name="city" id="city" class="form-control" placeholder="Digite a cidade aqui">
                            </div>
                            <button class="btn btn-primary" type="submit">Search</button>
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

    const apiKey = '6690575f2d9e4161426583aaa7bbc559';

    function searchCity(event, form) {
        event.preventDefault();

        const inputCity = form.city;

        if (inputCity) {
            const city = inputCity.value;
            const url = `api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}`;

            console.log('City: ', city, ' - apiKey: ', apiKey);
            console.log('Fetching..........');

            fetch(url)
                .then(response => response.json())
                .then(data => console.log(data))
                .catch(error => console.error(error));
        }
    }

</script>
    
@endsection