@extends('component.navbar')
@section('mains')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        body {
            overflow-x: hidden;
        }

        canvas {
            width: 100%;
        }

        .card {
            width: 100%;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        input {
                min-width: 70px;
            }

        @media (max-width:1024px) {



            .pisah {
                grid-template-columns: 7fr 1fr !important;
            }

            .pisah2 {
                grid-template-columns: 1fr !important;
            }

            .left {
                grid-column: 1;
            }

            .center {
                grid-column: 1 / 3;
            }

            .right {
                grid-column: 2;
                grid-row: 1;
            }

            input {
                margin-top: 20px !important
            }

            button {
                margin-top: 20px !important
            }

        }

        @media (max-width:800px) {
            .container {

                margin: 85px auto 0 auto;
            }

            .card {
                width: 65%;
                padding: 30px;
                border: 1px solid #ccc;
                border-radius: 30px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                margin: 20px;
            }




        }

        @media (max-width:630px) {
            .dd {
                min-width: 100px;
            }

            .rd {
                min-width: 100px;
            }



            .lastupdate{
                font-size: 16px;
            }

            .left{
                max-width:200px
            }






        }

        @media (max-width:425px) {

            .container {
                margin-top: 115px;
            }

            .rd {
                max-width: 63px;
                min-width: 30px;
            }

            .dd {
                max-width: 63px;
                min-width: 30px;

            }

            button {
                margin-top: 20px !important
            }

            .left{
                max-width:150px
            }

            .card{
                width: 100%
            }

                        .input-durationdata{
                margin-top: 38px !important
            }

            .input-maxdata{
                margin-top:38px !important
            }

            button{
                 margin-top:38px !important
            }


        }

    </style>

    @foreach ($alats as $alat)
        <div style=";width: 94%;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        padding: 20px;
        margin-top: 3%;
        margin-left: 2%;"
            class="container">
            <div class="card">
                <div class="pisah" style="grid-template-columns: 7fr 7fr 1fr; display:grid;">
                    <div class="left">
                        <h4>Machine ID : {{ $alat->id_mesin }} ({{ $alat->lokasi }})</h4>
                        <h4>Status : <span id="status_{{ $alat->id_mesin }}"
                                style="color: {{ $alat->status == 'Active' ? 'green' : 'red' }}">{{ $alat->status }}</span>
                        </h4>
                        <h4>Last update : <span id="lastUpdate_{{ $alat->id_mesin }}">Loading...</span></h4>

                    </div>
                    <div class="center">
                        <h4 style="margin-bottom:0 ">IP : {{ $alat->ip_address }} </h4>
                        <div style="display:flex;align-items:center;">

                            <h4 style="margin-bottom:0 " class="rd">Range data : </h4>
                            <input type="number" id="limit_{{ $alat->id_mesin }}" name="limit_{{ $alat->id_mesin }}"
                                min="1" max="16" required oninput="validateInput(this)"
                                style="width: 10%;margin-left:12px;margin-top:3%" class="input-maxdata" placeholder="">
                            <button onclick="fetchData{{ $alat->id_mesin }}()"
                                style="background-color: blue; color: white; padding: 4px 8px; border: none; border-radius: 5px; cursor: pointer;margin-left:2%;margin-top:3%">Update</button>
                            <span style="color:grey;margin-left:1%;margin-top:3%;font-family: Arial, Helvetica, sans-serif" class="max"> <i
                                    style="font-weight:normal;" id="maxdata"></i></span>
                        </div>

                        <div style="display:flex;align-items:center;">
                            <h4 style="margin-bottom:0 " class="dd">Duration data : </h4>
                            <input type="number" id="second_{{ $alat->id_mesin }}" name="second_{{ $alat->id_mesin }}"
                                required style="width: 10%;margin-left:10px;margin-top:3%" class="input-durationdata"
                                placeholder="">
                            <button onclick="fetchData{{ $alat->id_mesin }}()"
                                style="background-color: blue; color: white; padding: 4px 8px; border: none; border-radius: 5px; cursor: pointer;margin-left:2%;margin-top:3%">Update</button>
                            <span style="color:grey;margin-left:1%;margin-top:3%;font-family:Arial, Helvetica, sans-serif"> <i style="font-weight:normal;"
                                    id="defsec" class="max"></i></span>


                        </div>

                    </div>
                    <div style="min-width:50px; justify-content:center;display:block;text-align:center;border:1px solid#ccc;border-radius:20px;box-shadow:#ccc 1px 2px 5px 0px;height:120px"
                        class="right">
                        <h4><span id="lastUpdateTemperature_{{ $alat->id_mesin }}" class="lastupdate"></span></h4>
                        <hr style="border: 1px solid black;width:70%;">
                        <h4><span id="lastUpdateHumidity_{{ $alat->id_mesin }}" class="lastupdate"></span></h4>
                    </div>
                </div>

                <hr style="border: solid black 1px;margin-top:0;padding-top:0">

                <div class="pisah2" style="grid-template-columns: 1fr 1fr; display:grid;">
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
    @foreach ($alats as $alat)
        <script>
            let temperatureChart_{{ $alat->id_mesin }};
            let humidityChart_{{ $alat->id_mesin }};

            function getmaxlimit() {
                const width = window.innerWidth;
                if (width < 390) return 7;
                if (width < 600) return 10;
                if (width < 768) return 15;
                if (width < 900) return 18;
                return 24
            }

            function getsec() {
                const width = window.innerWidth;
                if (width < 630) return "Def 60 Sec";
                if (width > 630) return " ( Default 60 Second ) ";
            }


            function getdata() {
                const inputsrd = document.querySelectorAll('.input-maxdata');
                const inputsdd = document.querySelectorAll('.input-durationdata');
                const defsec = document.getElementById("defsec");
                const maxdata = document.getElementById("maxdata");

                const width = window.innerWidth;

                const placeholderText = (width < 630) ? `Max ${getmaxlimit()}` : '';
                const placeholderTexts = (width < 630) ? `${getsec()}` : '';

                inputsrd.forEach(input => {
                    input.placeholder = placeholderText;
                });

                inputsdd.forEach(input => {
                    input.placeholder = placeholderTexts;
                });

                if (width > 630) {
                    defsec.innerText = `${getsec()}`
                    maxdata.innerText = `( MAX ${getmaxlimit()} ) `
                } else {
                    defsec.innerText = ""
                    maxdata.innerText = ""
                }
            }

            function validateInput(input) {
                const maxLimit = getmaxlimit();
                if (input.value > maxLimit) {
                    alert("Input more than maximum input");
                    input.value = "";
                }
            }

            window.addEventListener('DOMContentLoaded', () => {
                getdata();
            });

            window.addEventListener('resize', () => {
                getdata();
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
                            document.getElementById("lastUpdate_{{ $alat->id_mesin }}").textContent = "No data";
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
                            tempData[tempData.length - 1] + " °C";
                        document.getElementById("lastUpdateHumidity_{{ $alat->id_mesin }}").textContent = humData[
                            humData.length - 1] + " %";



                        if (temperatureChart_{{ $alat->id_mesin }}) {
                            temperatureChart_{{ $alat->id_mesin }}.data.labels = labels;
                            temperatureChart_{{ $alat->id_mesin }}.data.datasets[0].data = tempData;
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
                                        fill: false
                                    }]
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
                            let lastUpdateElement = document.querySelector(`#last_update_${alat.id_mesin}`);
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
            setInterval(updateAlats, 300000);

            fetchData{{ $alat->id_mesin }}();
            setInterval(fetchData{{ $alat->id_mesin }}, 5000);
        </script>
    @endforeach
@endsection
