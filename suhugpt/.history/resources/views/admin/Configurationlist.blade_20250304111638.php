@extends('component.dashboard')

@section('content')
<div class="container">
    <div class="row">
        @foreach($configurations as $configuration)
        <div class="col-md-4">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-body">
                    <h5 class="card-title">Configuration ID: {{ $configuration->id }}</h5>
                    <p class="card-text"><strong>Machine ID:</strong> {{ $configuration->id_mesin }}</p>
                    <p class="card-text"><strong>Upper Temperature Limit:</strong> {{ $configuration->batas_atas_suhu }}</p>
                    <p class="card-text"><strong>Lower Temperature Limit:</strong> {{ $configuration->batas_bawah_suhu }}</p>
                    <p class="card-text"><strong>Upper Humidity Limit:</strong> {{ $configuration->batas_atas_kelembaban }}</p>
                    <p class="card-text"><strong>Lower Humidity Limit:</strong> {{ $configuration->batas_bawah_kelembaban }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
