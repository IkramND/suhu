<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Grafik Sensor</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2>Grafik Sensor</h2>
        <p>ID Mesin: <span id="idMesinDisplay">-</span></p>
        <p>Terakhir diperbarui: <span id="lastUpdate">-</span></p>
        <p>Suhu terbaru: <span id="latestTemperature">-</span>°C</p>
        <p>Kelembaban terbaru: <span id="latestHumidity">-</span>%</p>

        <canvas id="temperatureChart"></canvas>
        <canvas id="humidityChart"></canvas>
    </div>

    <script>
        const tempCtx = document.getElementById('temperatureChart').getContext('2d');
        const humCtx = document.getElementById('humidityChart').getContext('2d');
        let tempChart, humChart;

        $(document).ready(function() {
            const idMesin = localStorage.getItem("id_mesin");
            if (!idMesin) {
                alert("ID Mesin tidak ditemukan! Silakan tambahkan alat terlebih dahulu.");
                window.location.href = "/tambah-alat";
                return;
            }

            $("#idMesinDisplay").text(idMesin);
            fetchData(idMesin);
        });

        function fetchData(idMesin) {
            $.ajax({
                url: `/sensor/fetch-data?id_mesin=${idMesin}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length === 0) {
                        $("#lastUpdate").text("Tidak ada data");
                        return;
                    }

                    const labels = data.map(item => new Date(item.waktu).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }));
                    const tempData = data.map(item => item.suhu);
                    const humData = data.map(item => item.kelembaban);

                    $("#lastUpdate").text(labels[labels.length - 1]);
                    $("#latestTemperature").text(tempData[tempData.length - 1]);
                    $("#latestHumidity").text(humData[humData.length - 1]);

                    if (!tempChart) {
                        tempChart = new Chart(tempCtx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{ label: 'Suhu (°C)', data: tempData, borderColor: 'red', fill: false }]
                            },
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
                            data: {
                                labels: labels,
                                datasets: [{ label: 'Kelembaban (%)', data: humData, borderColor: 'blue', fill: false }]
                            },
                            options: { responsive: true }
                        });
                    } else {
                        humChart.data.labels = labels;
                        humChart.data.datasets[0].data = humData;
                        humChart.update();
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching data:", xhr.responseText);
                    $("#lastUpdate").text("Gagal memperbarui data");
                }
            });
        }
    </script>
</body>
</html>
