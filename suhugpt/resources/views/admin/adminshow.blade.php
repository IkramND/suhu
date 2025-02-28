@extends('component.dashboard')
@section('main')

<h2 style="text-align: center;margin-top:5%">Grafik Real-Time Suhu dan Kelembaban</h2>

<div style="width: 500px; padding: 30px; border: 1px solid #ccc; border-radius: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 0 auto;">
    <div class="card">
        <h3>Lokasi :  {{ $alat->lokasi }}</h3>
        <h3>Status : </h3>
        <h4>Last update : <span id="lastUpdate">Memuat...</span></h4>
        <h4>IP  : {{ $alat->ip_address }} </h4>

        <div class="kotak">
            <p style="text-align: right; margin-right:2%"><span id="latestTemperature">Memuat...</span>  °C</p>
            <hr style="width: 100%;border:solid black 1px">
            <p style="text-align: right"><span id="latestHumidity">Memuat...</span> %</p>
        </div>
    </div>

    <hr style="border:solid black 1px">
    <h3>Grafik Suhu</h3>
    <canvas id="temperatureChart"></canvas>
    <hr style="border:solid black 1px">

    <h3>Grafik Kelembaban</h3>
    <canvas id="humidityChart"></canvas>
    <hr style="border:solid black 1px">
</div>

@endsection

@section('script')
<script>
    const idMesin = "{{ $alat->id_mesin }}";
    const tempCtx = document.getElementById('temperatureChart').getContext('2d');
    const humCtx = document.getElementById('humidityChart').getContext('2d');
    let tempChart, humChart;

    function fetchData() {
        $.ajax({
            url: `/sensor/fetch-data/${idMesin}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.length === 0) {
                    document.getElementById("lastUpdate").textContent = "Tidak ada data";
                    return;
                }

                const labels = data.map(item => new Date(item.waktu).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }));
                const tempData = data.map(item => item.suhu);
                const humData = data.map(item => item.kelembaban);

                document.getElementById("latestTemperature").textContent = tempData[tempData.length - 1];
                document.getElementById("latestHumidity").textContent = humData[humData.length - 1];
                document.getElementById("lastUpdate").textContent = labels[labels.length - 1];

                if (!tempChart) {
                    tempChart = new Chart(tempCtx, {
                        type: 'line',
                        data: { labels: labels, datasets: [{ label: 'Suhu (°C)', data: tempData, borderColor: 'red', fill: false }] },
                        options: { responsive: true }
                    });
                } else {
                    tempChart.data.labels = labels;
                    tempChart.data.datasets[0].data = tempData;
                    tempChart.update();
                }

                if (!humChart) {
                    humChart = new Chart(humCtx, {
                        type: 'line',
                        data: { labels: labels, datasets: [{ label: 'Kelembaban (%)', data: humData, borderColor: 'blue', fill: false }] },
                        options: { responsive: true }
                    });
                } else {
                    humChart.data.labels = labels;
                    humChart.data.datasets[0].data = humData;
                    humChart.update();
                }
            },
            error: function() {
                document.getElementById("lastUpdate").textContent = "Gagal memperbarui data";
            }
        });
    }

    fetchData();
    setInterval(fetchData, 5000);
</script>
@endsection
