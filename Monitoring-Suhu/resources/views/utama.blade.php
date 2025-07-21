@extends('component.navbar')
@section('mains')

    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .navbar-teks {
            margin-left: 0;
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

        .container {
            width: 95%;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 35px auto 20px auto;
            background: white;

        }

        .container2 {
            width: 95%;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* margin-left: 25%;
            margin-top: 5pxpx; */
            margin: 5px auto 10px auto;


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
            max-width: 80px;
            display: flex;
            flex-direction: row-reverse;
            align-items:flex-start;
            width: 100%;
            /* height: 150px; */
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
            max-width: 55px;
            width: 100%;
            min-width: 80px;
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
            }

            .container {
                margin: 35px auto 20px auto;
            }

            .container2 {
                margin: 10px auto auto auto;
            }
        }

        @media (max-width: 600px){
            .wrapper-flex>div {
                flex: 1 1 100%;
            }
        }
    </style>

    <br>

    @foreach ($alats as $alat)
        <div class="container">
            <div class="card">
                <div class="left" style="">
                    <div style="width:100%; display:flex;flex-wrap:wrap;gap:10px;" class="wrapper-flex">
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
                    <div class="mi" style="">
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

