@extends('component.navbar')
@section('mains')

<style>
    .container {
        width: 60%;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        padding: 20px;
        margin-top: 8%;
        margin-left: 20%;
    }
    .card {
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 10px;
        text-align: center;
        background-color: #fff;
    }
    .status-active {
        color: green;
    }
    .status-inactive {
        color: red;
    }
    .btn {
        display: inline-block;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        color: white;
        margin: 5px;
    }
    .btn-update {
        background-color: blue;
    }
    .btn:hover {
        opacity: 0.8;
    }
    input[type=number] {
        width: 50px;
        text-align: center;
    }
</style>

<div class="container">
    @foreach($alats as $alat)
        <div class="card">
            <h3 class="card-title">Location: {{ $alat->lokasi }}</h3>
            <h3>Status: <span class="{{ $alat->status == 'Active' ? 'status-active' : 'status-inactive' }}">{{ $alat->status }}</span></h3>
            <h4>Last update: <span id="lastUpdate_{{ $alat->id_mesin }}">Loading...</span></h4>
            <h4>IP: {{ $alat->ip_address }}</h4>

            <hr>
            <div>
                Amount of data:
                <input type="number" id="limit_{{ $alat->id_mesin }}" min="1" max="16" required oninput="validateInput(this)">
                <button onclick="fetchData{{ $alat->id_mesin }}()" class="btn btn-update">Update</button>
                <span style="color:grey;"> <i>(max 16)</i></span>
            </div>
            <hr>
            <div>
                Data per second:
                <input type="number" id="second_{{ $alat->id_mesin }}" required>
                <button onclick="fetchData({{ $alat->id_mesin }})" class="btn btn-update">Update</button>
            </div>
            <hr>
            <canvas id="temperatureChart_{{ $alat->id_mesin }}"></canvas>
            <hr>
            <canvas id="humidityChart_{{ $alat->id_mesin }}"></canvas>
        </div>
    @endforeach
</div>

<script>
    function validateInput(input) {
        if (input.value > 16) {
            alert("Input more than maximum input");
            input.value = "";
        }
    }
</script>

@endsection
