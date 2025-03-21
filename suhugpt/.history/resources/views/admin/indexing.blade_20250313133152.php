@extends('component.dashboard')
@section('main')

<br>

@foreach($alats as $alat)
    <div style="width: 65%; padding: 20px; border: 1px solid #ccc; border-radius: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 20px auto; margin-top:6%;margin-left:25%">

        <div class="card">
            <div class="pisah" style="grid-template-columns: 4fr 4fr 1fr; display: grid; position: relative;">
                <div>
                    <h4>Location :  {{ $alat->lokasi }}</h4>
                    <h4>Status :<span id="status_{{ $alat->id_mesin}}" style="color: {{$alat->status == 'Active' ? 'green' : 'red'}}">{{$alat->status}}</span> </h4>
                    <h4>Last update : <span id="lastUpdate_{{ $alat->id_mesin }}">Loading...</span></h4>
                </div>
                <div>
                <h4>IP  : {{ $alat->ip_address }} </h4>
                Amount of data  :
                <input type="number" id="limit_{{ $alat->id_mesin }}" name="limit_{{ $alat->id_mesin }}" min="1" max="18" required oninput="validateInput(this)" style="width: 11%;margin-left:2%">
                <button onclick="fetchData{{ $alat->id_mesin }}()" style="background-color: blue; color: white; padding: 4px 8px; border: none; border-radius: 5px; cursor: pointer;">Update</button>
                <span style="color:grey;"> <i style="font-weight:normal">( max 18 )</i></span>
                <br>
                <br>
                Second per Data :
        <input type="number" id="second_{{ $alat->id_mesin }}" name="second_{{ $alat->id_mesin }}" required style="width: 10%">
<button onclick="fetchData({{ $alat->id_mesin }})" style="background-color: blue; color: white; padding: 4px 8px; border: none; border-radius: 5px; cursor: pointer;">Update</button>

            </div>
            <div style="background: red; position: relative; width: 100px; height: 100px; display: flex; flex-direction: column; align-items: flex-end; justify-content: start;">
                <a href="{{ route('history', ['id_mesin' => $alat->id_mesin, 'ip_address' => $alat->ip_address]) }}"
                    style="color: black; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;
                    border-radius: 50%; position: absolute; top: 1px; right: 1px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                </a>
                <div style="margin-top: 40px; text-align: right;">
                    <p style="margin: 0;"><strong>Suhu:</strong> <span id="suhu_{{$alat->id_mesin}}">Loading...</span> °C</p>
                    <p style="margin: 0;"><strong>Kelembaban:</strong> <span id="kelembaban_{{$alat->id_mesin}}">Loading...</span> %</p>
                </div>
            </div>

            </div>



            <!-- Input untuk mengatur jumlah data -->
                    <hr style="border: solid black 1px">
<div style="display: grid;grid-template-columns: 1fr 1fr">
    <div>

            <canvas id="temperatureChart_{{ $alat->id_mesin }}"></canvas>
        </div>
<div>
            <canvas id="humidityChart_{{ $alat->id_mesin }}"></canvas>
        </div>
        </div>
        </div>
    </div>


    <style>
        /* Menghilangkan spinner di input number */
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

 canvas {
        /* width: 100%; Mengatur lebar canvas menjadi 100% dari elemen induknya */
        /* max-width: ; Mengatur lebar maksimum */
        /* height: 100px; Mengatur tinggi canvas */
        /* max-height: 300px; */
        /* border: 1px solid black; Menambahkan border */
        /* margin: 20px 0; Menambahkan margin atas dan bawah */
    }
    </style>

    <script>
    function validateInput(input) {
        const maxLimit = 18;
        if (input.value > maxLimit) {
            alert("Input lebih dari batas maksimal (18)");
            input.value = "";
        }
    }

    function fetchData(id_mesin) {
        let limit = document.getElementById(`limit_${id_mesin}`).value || 10;
        let second = document.getElementById(`second_${id_mesin}`).value || 10;

        $.ajax({
            url: '/sensor/fetch-data',
            method: 'GET',
            data: {
                id_mesin: id_mesin,
                limit: limit,
                second: second
            },
            dataType: 'json',
            success: function(data) {
                if (data.length === 0) {
                    document.getElementById(`lastUpdate_${id_mesin}`).textContent = "Tidak ada data";
                    return;
                }

                const labels = data.map(item => new Date(item.waktu).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit', hour12: false}));
                const tempData = data.map(item => item.suhu);
                const humData = data.map(item => item.kelembaban);

                document.getElementById(`lastUpdate_${id_mesin}`).textContent = labels[labels.length - 1];

                if (window[`temperatureChart_${id_mesin}`]) {
                    window[`temperatureChart_${id_mesin}`].data.labels = labels;
                    window[`temperatureChart_${id_mesin}`].data.datasets[0].data = tempData;
                    window[`temperatureChart_${id_mesin}`].update();
                } else {
                    window[`temperatureChart_${id_mesin}`] = new Chart(document.getElementById(`temperatureChart_${id_mesin}`).getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Suhu (°C)',
                                data: tempData,
                                borderColor: 'red',
                                fill: false
                            }]
                        }
                    });
                }

                if (window[`humidityChart_${id_mesin}`]) {
                    window[`humidityChart_${id_mesin}`].data.labels = labels;
                    window[`humidityChart_${id_mesin}`].data.datasets[0].data = humData;
                    window[`humidityChart_${id_mesin}`].update();
                } else {
                    window[`humidityChart_${id_mesin}`] = new Chart(document.getElementById(`humidityChart_${id_mesin}`).getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Kelembaban (%)',
                                data: humData,
                                borderColor: 'blue',
                                fill: false
                            }]
                        }
                    });
                }
            }
        });
    }

    function updateLastSensorData(id_mesin) {
        $.ajax({
            url: '/sensor/last-data',
            method: 'GET',
            data: { id_mesin: id_mesin },
            dataType: 'json',
            success: function(data) {
                document.getElementById(`suhu_${id_mesin}`).textContent = data.suhu ?? 'No Data';
                document.getElementById(`kelembaban_${id_mesin}`).textContent = data.kelembaban ?? 'No Data';
            },
            error: function() {
                document.getElementById(`suhu_${id_mesin}`).textContent = 'Error';
                document.getElementById(`kelembaban_${id_mesin}`).textContent = 'Error';
            }
        });
    }

    function updateAlats() {
        $.ajax({
            url: '/get-alats',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                data.forEach(alat => {
                    let statusElement = document.getElementById(`status_${alat.id_mesin}`);
                    if (statusElement) {
                        statusElement.innerHTML = `<span style="color: ${alat.status === 'Active' ? 'green' : 'red'}">${alat.status}</span>`;
                    }
                });
            }
        });
    }

    // Inisialisasi
    @foreach($alats as $alat)
        updateLastSensorData({{ $alat->id_mesin }});
        setInterval(() => updateLastSensorData({{ $alat->id_mesin }}), 2000);
        fetchData({{ $alat->id_mesin }});
        setInterval(() => fetchData({{ $alat->id_mesin }}), 2000);
    @endforeach

    updateAlats();
    setInterval(updateAlats, 300000);
</script>



    @endforeach
@endsection




