@extends('component.dashboard')
@section('main')
    <style>
        /* Menghilangkan spinner di input number */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        canvas {
            width: 100%;
            height: 100%;
        }

        a.tooltip-svg {
            position: relative;
        }

        a.tooltip-svg::after {
            content: "History Report";
            position: absolute;
            /* bottom: 120%; Geser ke atas elemen */
            right: 10%;
            transform: translateX(-50%);
            background-color: black;
            color: white;
            padding: 5px 8px;
            border-radius: 5px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
            font-size: 12px;
            z-index: 100;
        }

        a.tooltip-svg:hover::after {
            opacity: 1;
        }

        @media (max-width:800px) {
            .pisah{
                grid-template-columns: 7fr 1fr !important;
            }

            .pisah2{
                grid-template-columns: 1fr !important;
            }

            .left{
                grid-column: 1;
            }
            .center{
                grid-column: 1;
                display: flex !important;
            }
            .right{
                grid-column: 2;
                grid-row: 1;
            }
        }
    </style>
    <br>

    @foreach ($alats as $alat)
        <div
            style="width: 65%; padding: 20px; border: 1px solid #ccc; border-radius: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 20px auto; margin-top:6%;margin-left:25%">

            <div class="card">
                <div class="pisah" style="grid-template-columns: 3fr 4fr 1fr; display: grid; position: relative;">
                    <div class="left">
                        <h4>Machine ID : {{ $alat->id_mesin }} ({{ $alat->lokasi }})</h4>
                        <h4>Status :<span id="status_{{ $alat->id_mesin }}"
                                style="color: {{ $alat->status == 'Active' ? 'green' : 'red' }}">{{ $alat->status }}</span>
                        </h4>
                        <h4>Last update : <span id="lastUpdate_{{ $alat->id_mesin }}">Loading...</span></h4>
                    </div>
                    <div class="center">
                        <h4 style="margin-bottom:0 ">IP : {{ $alat->ip_address }} </h4>
                        <div style="display:flex;align-items:center;">
                            <h4 style="margin-bottom:0 ">Range data : </h4>
                            <input type="number" id="limit_{{ $alat->id_mesin }}" name="limit_{{ $alat->id_mesin }}"
                                min="1" max="18" required oninput="validateInput(this)"
                                style="width: 11%; margin-left:5%;margin-top:5%">
                            <button onclick="fetchData{{ $alat->id_mesin }}()"
                                style="background-color: blue; color: white; padding: 4px 8px; border: none; border-radius: 5px; cursor: pointer;margin-top:5%;margin-left:2%">Update</button>
                            <span style="color:grey;margin-left:2%;margin-top:4%"> <i style="font-weight:normal">( max 18
                                    )</i></span>
                        </div>
                        <div style="display:flex;align-items:center;">
                            <h4 style="margin-bottom:0 ">Duration data :</h4>
                            <input type="number" id="second_{{ $alat->id_mesin }}" name="second_{{ $alat->id_mesin }}"
                                required style="width: 11%;margin-left:12px;margin-top:5%">
                            <button onclick="fetchData({{ $alat->id_mesin }})"
                                style="background-color: blue; color: white; padding: 4px 8px; border: none; border-radius: 5px; cursor: pointer;margin-top:5%;margin-left:2%">Update</button>
                            <span style="color:grey;margin-left:2%;margin-top:4%"> <i style="font-weight:normal">( Default 1
                                    Minute )</i></span>

                        </div>
                    </div>
                    <div
                        style="position: relative; width: 120px; height: 120px; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 10px; padding: 10px;" class="right">
                        <!-- Icon History -->
                        <a href="{{ route('history', ['id_mesin' => $alat->id_mesin, 'ip_address' => $alat->ip_address]) }}"
                            class="tooltip-svg"
                            style="color: black; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;
                    border-radius: 50%; position: absolute; top: 5px; right: 5px; background: white;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-clock-history" viewBox="0 0 16 16">
                                <path
                                    d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                <path
                                    d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </a>

                        <!-- Data Suhu dan Kelembaban -->
                        <div style=" width: 100%; padding: 10px; text-align: left; margin-top: 30px; border-radius: 5px;">
                            <div
                                style="margin-left:60%;border-radius:10px;text-align:center;border:1px solid black;height:60%;margin-top:23%">
                                <h5 style="margin-bottom:25%;margin-top:25%; "><span
                                        id="lastUpdateTemperature_{{ $alat->id_mesin }}"></span> </h5>
                                <hr style="border: 1px solid black; width: 65%;margin-top:0;margin-bottom:0;">
                                <h5 style="margin-top:25%"><span id="lastUpdateHumidity_{{ $alat->id_mesin }}"></span>
                                </h5>
                            </div>
                        </div>

                    </div>


                </div>



                <!-- Input untuk mengatur jumlah data -->
                <hr style="border: solid black 1px">
                <div style="display: grid;grid-template-columns: 1fr 1fr" class="pisah2">
                    <div>
                        <canvas id="temperatureChart_{{ $alat->id_mesin }}"></canvas>
                    </div>
                    <div>
                        <canvas id="humidityChart_{{ $alat->id_mesin }}"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let temperatureChart_{{ $alat->id_mesin }};
            let humidityChart_{{ $alat->id_mesin }};


            function validateInput(input) {
                const maxLimit = 18; // Batas maksimum
                if (input.value > maxLimit) {
                    alert("Input more than maximum input");
                    input.value = ""; // Mengosongkan input jika melebihi batas
                }
            }

            function fetchData{{ $alat->id_mesin }}() {
                let limit = document.getElementById("limit_{{ $alat->id_mesin }}").value || 10; // Ambil nilai limit dari input
                let second = document.getElementById("second_{{ $alat->id_mesin }}").value || 60;


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
                            document.getElementById("lastUpdate_{{ $alat->id_mesin }}").textContent =
                                "Tidak ada data";
                            document.getElementById("lastUpdateTemperature_{{ $alat->id_mesin }}").textContent =
                                " - ";
                            document.getElementById("lastUpdateHumidity_{{ $alat->id_mesin }}").textContent =
                                " - ";
                            return;
                        }

                        // Ambil labels (waktu) dan data suhu/kelembaban
                        const labels = data.map(item => new Date(item.waktu).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        }));
                        const tempData = data.map(item => item.suhu);
                        const humData = data.map(item => item.kelembaban);

                        document.getElementById("lastUpdate_{{ $alat->id_mesin }}").textContent = labels[labels
                            .length - 1];
                        document.getElementById("lastUpdateTemperature_{{ $alat->id_mesin }}").textContent =
                            tempData[tempData.length - 1] + " C";
                        document.getElementById("lastUpdateHumidity_{{ $alat->id_mesin }}").textContent = humData[
                            humData.length - 1] + " %";

                        // Jika grafik sudah ada, cukup update datanya
                        if (temperatureChart_{{ $alat->id_mesin }}) {
                            temperatureChart_{{ $alat->id_mesin }}.data.labels =
                                labels; // Perbarui labels (sumbu X)
                            temperatureChart_{{ $alat->id_mesin }}.data.datasets[0].data =
                                tempData; // Perbarui data suhu
                            temperatureChart_{{ $alat->id_mesin }}.update();
                        } else {
                            // Jika grafik belum ada, buat baru
                            temperatureChart_{{ $alat->id_mesin }} = new Chart(document.getElementById(
                                "temperatureChart_{{ $alat->id_mesin }}").getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Temperature (°C)',
                                        data: tempData,
                                        borderColor: 'red',
                                        fill: false
                                    }]
                                }
                            });
                        }

                        if (humidityChart_{{ $alat->id_mesin }}) {
                            humidityChart_{{ $alat->id_mesin }}.data.labels = labels; // Perbarui labels (sumbu X)
                            humidityChart_{{ $alat->id_mesin }}.data.datasets[0].data =
                                humData; // Perbarui data kelembaban
                            humidityChart_{{ $alat->id_mesin }}.update();
                        } else {
                            humidityChart_{{ $alat->id_mesin }} = new Chart(document.getElementById(
                                "humidityChart_{{ $alat->id_mesin }}").getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Humidity (%)',
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


            function updateAlats() {
                $.ajax({
                    url: '/get-alats',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        data.forEach(alat => {
                            let statusElement = document.querySelector(`#status_${alat.id_mesin}`);
                            let lastUpdateElement = document.querySelector(`#lastUpdate_${alat.id_mesin}`);
                            let suhuElement = document.querySelector(`#suhu_${alat.id_mesin}`);
                            let kelembabanElement = document.querySelector(`#kelembaban_${alat.id_mesin}`);

                            // if (statusElement) {
                            //     statusElement.innerHTML = `<span style="color: ${alat.status === 'Active' ? 'green' : 'red'}">${alat.status}</span>`;
                            // }

                            if (statusElement) {
                                statusElement.textContent = alat.status;
                                statusElement.style.color = alat.status === 'Active' ? 'green' : 'red';
                            }


                            if (lastUpdateElement) {
                                lastUpdateElement.innerHTML = alat.latest_update;
                            }

                            if (suhuElement) {
                                suhuElement.innerHTML = alat.suhu !== 'No Data' ? `${alat.suhu} °C` :
                                    'No Data';
                            }

                            if (kelembabanElement) {
                                kelembabanElement.innerHTML = alat.kelembaban !== 'No Data' ?
                                    `${alat.kelembaban} %` : 'No Data';
                            }
                        });
                    }
                });
            }










            updateAlats();
            setInterval(updateAlats, 30000);
            fetchData{{ $alat->id_mesin }}();
            setInterval(fetchData{{ $alat->id_mesin }}, 5000);
        </script>
    @endforeach
@endsection
