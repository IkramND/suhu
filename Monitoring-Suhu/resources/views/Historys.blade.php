@extends('component.dashboard')
@section('main')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>

#chartContainer.hidden{
    display: none;
}

.container {
            width: 70%;
            padding: 20px;
            margin-left: 25%;
            margin-top: 40px;
        }

#chartContainer{
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            margin: 0 auto;
}

canvas{
/* background: green; */
padding: 20px;
}

@media (max-width: 800px){
    .container{
    margin:150px auto 0 auto;
    width: 100% !important;
    }

}

@media (max-width: 600px){
    #chartContainer{
        max-width: 600px !important;
    }
}

@media (max-width: 500px){
    #chartContainer{
        max-width: 490px !important;
    }

    input{
        max-width: 100px;
    }
}

@media (max-width:350px){
    #chartContainer{
        max-width: 420px !important;
    }
}
</style>

<div class="container">
    <div style="margin-bottom: 30px; text-align: center; margin-top: 10%;">
        <input type="hidden" id="id_mesin" value="{{ $id_mesin }}">
        <div style="margin-top:7%">
            <input type="date" id="start_date" placeholder="Select Start Date">
            <label for="end_date" style="padding-left: 1%;padding-right:1%"> - </label>
            <input type="date" id="end_date" placeholder="Select End Date">
        </div>
    </div>

    <div id="chartContainer">
        <div style="margin-top: 5%;">
            <center>
                <h2>{{ $id_mesin }}</h2>

                <h2>{{ $ip_address }}</h2>
            </center>
        </div>
        {{-- <hr style="border:1px solid black"> --}}
        <br>
        <canvas id="temperatureChart"></canvas>
        <hr id="chartDivider" style="border: solid black 1px; display: none;">
        <canvas id="humidityChart" style="margin-top: 30px;"></canvas>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>

        flatpickr("#start_date",{
            dateFormat: "Y-m-d",
            disableMobile:true
        })

        flatpickr("#end_date",{
            dateFormat: "Y-m-d",
            disableMobile:true
        })

        let temperatureChart = null;
        let humidityChart = null;

        function fetchDataHistory(startDate = '', endDate = '') {
            let id_mesin = document.getElementById("id_mesin").value;

            if ((startDate && !endDate) || (!startDate && endDate)) {
                return;
            }

            if (!id_mesin) {
                alert("Machine ID not found!");
                return;
            }

            $.ajax({
                url: '/sensor/fetch-history',
                method: 'GET',
                data: {
                    id_mesin: id_mesin,
                    start_date: startDate,
                    end_date: endDate
                },
                dataType: 'json',
                success: function(data) {
                    if (data.length === 0) {
                        alert("There is no data in the selected time range.");
                        document.getElementById("chartContainer").classList.add("hidden");
                        return;
                    }

                    document.getElementById("chartContainer").classList.remove("hidden");


                    const labels = data.map(item =>
                    `${item.hari.slice(0,3)} ${item.tanggal.slice(8,12)}-${item.tanggal.slice(2,4)}`);
                    const tempData = data.map(item => parseFloat(item.rata_rata_suhu));
                    const humData = data.map(item => parseFloat(item.rata_rata_kelembaban));

                    let ctxTemp = document.getElementById("temperatureChart").getContext('2d');
                    let ctxHum = document.getElementById("humidityChart").getContext('2d');

                    if (temperatureChart) {
                        temperatureChart.destroy();
                    }
                    if (humidityChart) {
                        humidityChart.destroy();
                    }

                    temperatureChart = new Chart(ctxTemp, {
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

                    humidityChart = new Chart(ctxHum, {
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
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", xhr.responseText);
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            fetchDataHistory();
        });

        document.getElementById("start_date").addEventListener("change", function() {
            let startDate = document.getElementById("start_date").value;
            let endDate = document.getElementById("end_date").value;
            if (startDate && endDate) {
                fetchDataHistory(startDate, endDate);
            }
        });

        document.getElementById("end_date").addEventListener("change", function() {
            let startDate = document.getElementById("start_date").value;
            let endDate = document.getElementById("end_date").value;
            if (startDate && endDate) {
                fetchDataHistory(startDate, endDate);
            }
        });
    </script>
@endsection
