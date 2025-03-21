@extends('component.navbar')
@section('mains')

    <br>

    <div style=";width: 94%;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        padding: 20px;
        margin-top: 3%;
        margin-left: 2%;" class="container">
        @foreach($alats as $alat)

        <div style="width: 100%;padding: 30px;border: 1px solid #ccc;border-radius: 30px;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);margin: 20px;">

            <div class="card">
                <div class="pisah" style="grid-template-columns: 7fr 7fr 1fr; display:grid;">
                    <div>
                        <h3>Location :  {{ $alat->lokasi }}</h3>
                        <h3>Status : <span style="color: {{$alat->status == 'Active' ? 'green':'red'}}">{{ $alat->status }}</span></h3>
                        <h4>Last update : <span id="lastUpdate_{{ $alat->id_mesin }}">Loading...</span></h4>

                    </div>
                    <div>
                        <h4 style="margin-bottom:0 ">IP  : {{ $alat->ip_address }} </h4>
                        <div style="display:flex;align-items:center;">

                        <h4 style="margin-bottom:0 ">Amount of data : </h4>
                    <input type="number" id="limit_{{ $alat->id_mesin }}" name="limit_{{ $alat->id_mesin }}" min="1" max="16" required oninput="validateInput(this)" style="width: 10%;margin-left:12px">
                    <button onclick="fetchData{{ $alat->id_mesin }}()" style="background-color: blue; color: white; padding: 4px 8px; border: none; border-radius: 5px; cursor: pointer;margin-left:2%">Update</button>
                    <span style="color:grey;margin-left:2%"> <i style="font-weight:normal;"> ( max 24 )</i></span>
                    </div>

                                {{-- <hr style="border: solid black 1px"> --}}
                                <div style="display:flex;align-items:center;background:rebeccapurple">
                            <h4 style="margin-bottom:0 ">Second per data : </h4>
                            <input type="number" id="second_{{ $alat->id_mesin }}" name="second_{{ $alat->id_mesin }}" required style="width: 10%;margin-left:10px;margin-top:3%">
                    <button onclick="fetchData({{ $alat->id_mesin }})" style="background-color: blue; color: white; padding: 4px 8px; border: none; border-radius: 5px; cursor: pointer;margin-left:2%">Update</button>
                </div>

                    </div>
                    <div style="justify-content:center;display:block;text-align:center;border:1px solid#ccc;border-radius:20px;padding-top:15%;box-shadow:#ccc 1px 2px 5px 0px">

                        <h4><span id="lastUpdateTemperature_{{ $alat->id_mesin}}"></span></h4>
                        <hr style="border: 1px solid black;width:65%">
                        <h4><span id="lastUpdateHumidity_{{ $alat->id_mesin}}"></span></h4>
                        </div>
                </div>

                <hr style="border: solid black 1px">

                <!-- Input untuk mengatur jumlah data -->
                <div class="PisahChart" style="grid-template-columns: 1fr 1fr; display:grid;">
                    <div>
                <canvas id="temperatureChart_{{ $alat->id_mesin }}"></canvas>
            </div>
            <div>
                <canvas id="humidityChart_{{ $alat->id_mesin }}"></canvas>
            </div>
            </div>
            </div>
        </div>
        @endforeach
    </div>
@foreach ( $alats as $alat )

        <style>
            /* Menghilangkan spinner di input number */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    body{
        overflow-x: hidden;
        /* background: red; */
    }

    canvas{
        /* max-height: 400px; */
    }
        </style>

        <script>
            let temperatureChart_{{ $alat->id_mesin }};
            let humidityChart_{{ $alat->id_mesin }};


            function validateInput(input) {
            const maxLimit = 100; // Batas maksimum
            if (input.value > maxLimit) {
                alert("Input more than maximum input");
                input.value = ""; // Mengosongkan input jika melebihi batas
            }
        }

function fetchData{{ $alat->id_mesin }}() {
    let limit = document.getElementById("limit_{{ $alat->id_mesin }}").value || 10; // Ambil nilai limit dari input
    let second = document.getElementById("second_{{ $alat->id_mesin }}").value || 10;


    $.ajax({
        url: '/sensor/fetch-data',
        method: 'GET',
        data: {
            id_mesin: "{{ $alat->id_mesin }}",
            limit: limit,
            second: second

        },
        dataType: 'json',
        success: function(data) {
            if (data.length === 0) {
                document.getElementById("lastUpdate_{{ $alat->id_mesin }}").textContent = "No data";
                document.getElementById("lastUpdateTemperature_{{ $alat->id_mesin}}").textContent = " - ";
                document.getElementById("lastUpdateHumidity_{{ $alat->id_mesin}}").textContent = " - ";

                return;
            }

            // Ambil labels (waktu) dan data suhu/kelembaban
            const labels = data.map(item => new Date(item.waktu).toLocaleTimeString([],{hour: '2-digit', minute: '2-digit',hour12:false }));
            const tempData = data.map(item => item.suhu);
            const humData = data.map(item => item.kelembaban);

            document.getElementById("lastUpdate_{{ $alat->id_mesin }}").textContent = labels[labels.length - 1] ;
            document.getElementById("lastUpdateTemperature_{{ $alat->id_mesin}}").textContent = tempData[tempData.length - 1] + " °C";
            document.getElementById("lastUpdateHumidity_{{ $alat->id_mesin}}").textContent = humData[humData.length - 1] + " %";



            // Jika grafik sudah ada, cukup update datanya
            if (temperatureChart_{{ $alat->id_mesin }}) {
                temperatureChart_{{ $alat->id_mesin }}.data.labels = labels; // Perbarui labels (sumbu X)
                temperatureChart_{{ $alat->id_mesin }}.data.datasets[0].data = tempData; // Perbarui data suhu
                temperatureChart_{{ $alat->id_mesin }}.update();
            } else {
                // Jika grafik belum ada, buat baru
                temperatureChart_{{ $alat->id_mesin }} = new Chart(document.getElementById("temperatureChart_{{ $alat->id_mesin }}").getContext('2d'), {
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

            if (humidityChart_{{ $alat->id_mesin }}) {
                humidityChart_{{ $alat->id_mesin }}.data.labels = labels; // Perbarui labels (sumbu X)
                humidityChart_{{ $alat->id_mesin }}.data.datasets[0].data = humData; // Perbarui data kelembaban
                humidityChart_{{ $alat->id_mesin }}.update();
            } else {
                humidityChart_{{ $alat->id_mesin }} = new Chart(document.getElementById("humidityChart_{{ $alat->id_mesin }}").getContext('2d'), {
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

// Jalankan pertama kali dan perbarui setiap 2 detik
fetchData{{ $alat->id_mesin }}();
setInterval(fetchData{{ $alat->id_mesin }}, 2000);

        </script>

@endforeach

@endsection
