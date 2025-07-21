@extends('component.dashboard')
@section('main')

    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        main {
            margin-bottom: 40px
        }

        .left {
            display: flex;
            width: 100%;
        }



        hr {
            border: 1px solid black;
            width: 80%;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .top3 span {
            margin-bottom: 0;
            padding: 0;
        }

        .top2 {
            /* background: blue; */
        }


        .container {
            width: 65%;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-left: 25%;
            margin-top: 85px;
            margin-bottom: 20px;
            background: white;

        }

        .container2 {
            width: 65%;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-left: 25%;
            margin-top: 5px;

        }

        .card {
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }


        #p {
            margin: 0;
            padding: 5px 5px 5px 0px;

            /* background: fuchsia */
        }

        .mi {
            width: 10%;
            max-width: 100px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .icon-history-report,
        .data-update {
            width: 100%;
        }

        .left p,
        .center p {
            color: grey;
        }

        .input-container {
            /* background: green */
        }






        a.tooltip-svg {
            display: flex;
            flex-direction: row-reverse;
        }

        a.tooltip-svg::after {
            content: "History Report";
            position: absolute;
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

        #icon-history {
            color: black;
        }

        .rd {
            min-width: 70px;

        }

        .dd {
            min-width: 70px;
        }

        input {
            min-width: 50px;
            width: 50%;
            border-radius: 5px;
            border: 1px solid black
                /* font-weight:bold; */
        }



        .wrapper-flex>div {
            flex: 1 1 30%;
        }

        .pisah2 {
            display: flex;
        }

        .charts {
            display: flex;
            width: 100%;
            flex-wrap: wrap;
        }

        .chart-box {
            width: 50%;
        }

        .bottom2 input,
        .bottom3 input {
            padding: 8px;
        }

        button {
            background-color: blue;
            color: white;
            padding: 9px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .data-update {
            border: 1px #ccc solid;
            border-radius: 10px;
            box-shadow: #ccc 1px 2px 5px 0px;
            text-align: center;
            margin-top: 10px;
            min-width: 60px;
            max-width: 65px;
        }


        .card h4 {
            font-size: 1em;
            font-weight: bold;

        }




        @media (max-width: 1024px) {
            .wrapper-flex>div {
                flex: 1 1 45%;
            }

            .chart-box {
                width: 100%;
            }

            .data-update {
                margin-left: 0;
            }
        }


        @media (max-width: 800px) {
            .wrapper-flex>div {
                flex: 1 1 45%;
            }

            .mi {
                min-width: 55px;
                /* background: chartreuse */
            }

            .container {
                margin: 35px auto 20px auto;
                width: 90%;
            }

            .container2 {
                margin: 10px auto auto auto;
                width: 90%;
            }



        }

        @media (max-width: 600px) {
                .wrapper-flex>div {
                flex: 1 1 100%;
            }
            }
    </style>

    <br>

    @foreach ($alats as $alat)
        <div class="container">
            <div class="card">
                <div class="left">
                    <div style="width:90%; display:flex;flex-wrap:wrap;gap:10px" class="wrapper-flex">
                        <div class="top1">
                            <p id="p">Machine ID</p>
                            <h4 id="p">{{ $alat->id_mesin }} ({{ $alat->lokasi }})</h4>
                        </div>
                        <div class="top2">
                            <p id="p">Status</p>
                            <h4 id="p">
                                <span id="status_{{ $alat->id_mesin }}"
                                    style="color: {{ $alat->status == 'Active' ? 'green' : 'red' }}">{{ $alat->status }}</span>
                            </h4>
                        </div>
                        <div class="top3">
                            <p id="p">Last update</p>
                            <h4 id="p"><span id="lastUpdate_{{ $alat->id_mesin }}">Loading...</span></h4>
                        </div>
                        <div class="bottom1">
                            <p id="p">IP</p>
                            <h4 id="p">{{ $alat->ip_address }} </h4>
                        </div>
                        <div class="bottom2">
                            <p id="p" class="rd">Range data</p>
                            <div style="" class="input-container">
                                <input type="number" class="input-maxdata" id="limit_{{ $alat->id_mesin }}"
                                    name="limit_{{ $alat->id_mesin }}" min="1" max="18" required
                                    oninput="validateInput(this)">
                                <button onclick="fetchData{{ $alat->id_mesin }}()">Update</button>
                                <span class="max" style="color:grey;">
                                    <i style="font-weight:normal" id="maxdata_{{ $alat->id_mesin }}"></i></span>
                            </div>
                        </div>
                        <div class="bottom3">
                            <p id="p" class="dd">Duration data</p>
                            <div class="input-container">
                                <input type="number" class="input-durationdata" id="second_{{ $alat->id_mesin }}"
                                    name="second_{{ $alat->id_mesin }}" required>
                                <button onclick="fetchData{{ $alat->id_mesin }}">Update</button>
                                <span class="max" style="color:grey;font-weight:bold"><i style="font-weight:bold"
                                        id="defsec_{{ $alat->id_mesin }}"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="mi">
                        <div class="icon-history-report">
                            <a href="{{ route('history', ['id_mesin' => $alat->id_mesin, 'ip_address' => $alat->ip_address]) }}"
                                class="tooltip-svg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                    class="bi bi-clock-history" viewBox="0 0 16 16" id="icon-history">
                                    <path
                                        d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                    <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                    <path
                                        d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                                </svg>
                            </a>
                        </div>
                        <div class="data-update">
                            <br>
                            <span id="lastUpdateTemperature_{{ $alat->id_mesin }}"></span>
                            <hr class="line">
                            <span id="lastUpdateHumidity_{{ $alat->id_mesin }}"></span>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
                <div>
                </div>

            </div>
        </div>
        <div class="container2">
            <div class="card">
                <div class="pisah2">
                    <div class="charts">
                        <div class="chart-box">
                            <canvas id="temperatureChart_{{ $alat->id_mesin }}"></canvas>
                        </div>
                        <div class="chart-box">
                            <canvas id="humidityChart_{{ $alat->id_mesin }}"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>

        <script>
            let temperatureChart_{{ $alat->id_mesin }};
            let humidityChart_{{ $alat->id_mesin }};



            function getmaxlimit() {
                const width = window.innerWidth;
                if (width < 450) return 7;
                if (width < 600) return 10;
                if (width < 768) return 15;
                return 18;
            }

            function getsec() {
                const width = window.innerWidth;
                if (width < 450) return "Def 60 S"
                if (width < 630) return "Def 60 Sec";
                if (width > 630) return "Default 60 Second";
            }



            function getdata{{ $alat->id_mesin }}() {
                const inputsrd = document.querySelectorAll('.input-maxdata');
                const inputsdd = document.querySelectorAll('.input-durationdata');
                const defsec = document.getElementById("defsec_{{ $alat->id_mesin }}");
                const maxdata = document.getElementById("maxdata_{{ $alat->id_mesin }}");

                const width = window.innerWidth;

                const placeholderText = `Max ${getmaxlimit()}`;
                const placeholderTexts = `${getsec()}`;

                inputsrd.forEach(input => {
                    input.placeholder = placeholderText;
                });

                inputsdd.forEach(input => {
                    input.placeholder = placeholderTexts;
                });

            }

            function validateInput(input) {
                const maxLimit = getmaxlimit();
                if (input.value > maxLimit) {
                    alert("Input more than maximum input");
                    input.value = "";
                }
            }

            window.addEventListener('DOMContentLoaded', () => {
                getdata{{ $alat->id_mesin }}();
            });

            window.addEventListener('resize', () => {
                getdata{{ $alat->id_mesin }}();
            });

            function fetchData{{ $alat->id_mesin }}() {
                let limitinput = document.getElementById("limit_{{ $alat->id_mesin }}").value;
                let second = document.getElementById("second_{{ $alat->id_mesin }}").value || 60;
                const width = window.innerWidth;
                let defaultlimit = (width < 500) ? 5 : 10;
                let limit = limitinput || defaultlimit;

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
                                " - ";
                            document.getElementById("lastUpdateTemperature_{{ $alat->id_mesin }}").textContent =
                                " - ";
                            document.getElementById("lastUpdateHumidity_{{ $alat->id_mesin }}").textContent =
                                " - ";
                            return;
                        }

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

                        if (temperatureChart_{{ $alat->id_mesin }}) {
                            temperatureChart_{{ $alat->id_mesin }}.data.labels =
                                labels;
                            temperatureChart_{{ $alat->id_mesin }}.data.datasets[0].data =
                                tempData;
                            temperatureChart_{{ $alat->id_mesin }}.update();
                        } else {
                            temperatureChart_{{ $alat->id_mesin }} = new Chart(document.getElementById(
                                "temperatureChart_{{ $alat->id_mesin }}").getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Temperature (°C)',
                                        data: tempData,
                                        borderColor: 'red',
                                        fill: false,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        x: {
                                            grid: {
                                                color: 'grey',
                                                lineWidth: 0.4
                                            },
                                            ticks: {
                                                color: 'grey'
                                            }
                                        },
                                        y: {
                                            grid: {
                                                color: 'grey',
                                                lineWidth: 0.4
                                            },
                                            ticks: {
                                                color: 'grey'
                                            }
                                        }
                                    }
                                }
                            });
                        }

                        if (humidityChart_{{ $alat->id_mesin }}) {
                            humidityChart_{{ $alat->id_mesin }}.data.labels = labels;
                            humidityChart_{{ $alat->id_mesin }}.data.datasets[0].data =
                                humData;
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
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        x: {
                                            grid: {
                                                color: 'grey',
                                                lineWidth: 0.4
                                            },
                                            ticks: {
                                                color: 'grey'
                                            }
                                        },
                                        y: {
                                            grid: {
                                                color: 'grey',
                                                lineWidth: 0.4
                                            },
                                            ticks: {
                                                color: 'grey'
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            labels: {
                                                color: 'grey',
                                            }
                                        }
                                    }
                                },
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

