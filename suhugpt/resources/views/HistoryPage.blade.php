@extends('component.dashboard')
@section('main')
<h2 style="margin-top:20% ;text-align:center">Grafik Suhu & Kelembaban</h2>

<!-- Form Input ID Mesin & Filter Tanggal -->
<div style="margin-bottom: 20px; text-align: center; margin-top: 3%">

    <input type="date" id="start_date">
    <label for="end_date" style="padding-left: 1%; padding-right: 1%"> - </label>
    <input type="date" id="end_date">
</div>

<!-- Container Grafik -->
<div id="chartContainer" style="width: 500px; padding: 30px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 0 auto;">
    <!-- Tempat untuk menampilkan Last Update -->
    <div id="lastUpdateContainer" style="text-align: center; margin-top: 20px;">
        {{-- <strong>Last Update:</strong> <span id="lastUpdateText">Memuat...</span> --}}
    </div>

    <canvas id="temperatureChart"></canvas>
    <hr id="chartDivider" style="border: solid black 1px; display: none;">
    <canvas id="humidityChart" style="margin-top: 30px;"></canvas>
</div>

<script>
    const tempCtx = document.getElementById('temperatureChart').getContext('2d');
    const humCtx = document.getElementById('humidityChart').getContext('2d');
    const chartDivider = document.getElementById('chartDivider');

    let tempChart, humChart;

    function getQueryParam(param){
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    const idMesin = getQueryParam("id_mesin");

    function fetchDataHistory(startDate = '', endDate = '') {
        // let idMesin = document.getElementById("id_mesin").value.trim();
        if (!idMesin) {
            alert("Masukkan ID Mesin terlebih dahulu!");
            return;
        }

        $.ajax({
            url: `/sensor/fetch-data/${idMesin}`,
            method: 'GET',
            data: { start_date: startDate, end_date: endDate },
            dataType: 'json',
            success: function(data) {
                if (data.length === 0) {
                    alert("Tidak ada data dalam rentang waktu yang dipilih.");
                    return;
                }

                const labels = data.map(item => `${item.hari}, ${item.tanggal}`);
                const tempData = data.map(item => parseFloat(item.rata_rata_suhu));
                const humData = data.map(item => parseFloat(item.rata_rata_kelembaban));

                updateCharts(labels, tempData, humData);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
                alert("Gagal memperbarui data");
            }
        });
    }

    function updateCharts(labels, tempData, humData) {
        chartDivider.style.display = labels.length > 0 ? 'block' : 'none';

        if (!tempChart) {
            tempChart = new Chart(tempCtx, {
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
        } else {
            tempChart.data.labels = labels;
            tempChart.data.datasets[0].data = tempData;
            tempChart.update();
        }

        if (!humChart) {
            humChart = new Chart(humCtx, {
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
        } else {
            humChart.data.labels = labels;
            humChart.data.datasets[0].data = humData;
            humChart.update();
        }
    }

    // Event listener untuk update grafik berdasarkan ID Mesin & tanggal

    document.getElementById("start_date").addEventListener("change", () => {
        fetchDataHistory(document.getElementById("start_date").value, document.getElementById("end_date").value);
    });

    document.getElementById("end_date").addEventListener("change", () => {
        fetchDataHistory(document.getElementById("start_date").value, document.getElementById("end_date").value);
    });

    fetchDataHistory();

</script>
@endsection
