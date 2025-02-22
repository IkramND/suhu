<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Real-Time Suhu & Kelembaban</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="padding: 30px;">
    <h2>Grafik Real-Time Suhu dan Kelembaban</h2>

    <div style="width: 500px; padding: 30px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 0 auto;">
        <div class="card">
            <h3>Lokasi : ROB1 </h3>
            <h3>Status : </h3>
            <h4>Last Update : <span id="lastUpdate">Memuat...</span></h4>
            <hr style="border:solid black 1px">
            <h3>Grafik Suhu</h3>
            {{-- <h4>Status : <span id="lastUpdateTemp">Memuat...</span></h4> --}}
            {{-- <h4>Alat: <span id="statusTemp">Memuat...</span></h4> --}}
            <canvas id="temperatureChart"></canvas>
            <hr style="border:solid black 1px">

            <h3>Grafik Kelembaban</h3>
            {{-- <h4>Status : <span id="lastUpdateHum">Memuat...</span></h4> --}}
            {{-- <h4>Alat: <span id="statusHum">Memuat...</span></h4> --}}
            <canvas id="humidityChart"></canvas>
            <hr style="border:solid black 1px">
        </div>
    </div>

        <script>
            const tempCtx = document.getElementById('temperatureChart').getContext('2d');
            const humCtx = document.getElementById('humidityChart').getContext('2d');
            const lastUpdate = document.getElementById('lastUpdate');
            // const lastUpdateHum = document.getElementById('lastUpdateHum');
            // const statusTemp = document.getElementById('statusTemp');
            // const statusHum = document.getElementById('statusHum');

        let tempChart, humChart;

        function fetchData() {
            $.ajax({
                url: '/sensor/fetch-data-history', // Menggunakan route Laravel
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length === 0) {
                        lastUpdate.textContent = "Tidak ada data";
                        // lastUpdateHum.textContent = "Tidak ada data";
                        // statusTemp.textContent = "OFFLINE";
                        // statusHum.textContent = "OFFLINE";
                        // statusTemp.style.color = "red";
                        // statusHum.style.color = "red";
                        return;
                    }

                    const labels = data.map(item => item.timestamp);
                    const tempData = data.map(item => item.temperature);
                    const humData = data.map(item => item.humidity);

                    // Mendapatkan timestamp terbaru
                    const latestTimestamp = labels[labels.length - 1];
                    // const latestTimestampp = labels[labels.length - 2]
                    lastUpdate.textContent = ` ${latestTimestamp}`;
                    // lastUpdateHum.textContent = ` ${latestTimestamp}`;

                    // // Mengecek status alat (Online/Offline)
                    // const lastUpdateTime = new Date(latestTimestamp).getTime();
                    // const currentTime = new Date().getTime();
                    // const diffMinutes = (currentTime - lastUpdateTime) / 60000; // Menghitung selisih dalam menit

                    // if (diffMinutes <= 5) {
                    //     statusTemp.textContent = "ONLINE";
                    //     statusHum.textContent = "ONLINE";
                    //     statusTemp.style.color = "green";
                    //     statusHum.style.color = "green";
                    // } else {
                    //     statusTemp.textContent = "OFFLINE";
                    //     statusHum.textContent = "OFFLINE";
                    //     statusTemp.style.color = "red";
                    //     statusHum.style.color = "red";
                    // }

                    // Grafik Suhu
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
                            },
                            options: {
                                responsive: true
                            }
                        });
                    } else {
                        tempChart.data.labels = labels;
                        tempChart.data.datasets[0].data = tempData;
                        tempChart.update();
                    }

                    // Grafik Kelembaban
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
                            },
                            options: {
                                responsive: true
                            }
                        });
                    } else {
                        humChart.data.labels = labels;
                        humChart.data.datasets[0].data = humData;
                        humChart.update();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                    lastUpdate.textContent = "Gagal memperbarui data";
                    // lastUpdateHum.textContent = "Gagal memperbarui data";
                    // statusTemp.textContent = "OFFLINE";
                    // statusHum.textContent = "OFFLINE";
                    // statusTemp.style.color = "red";
                    // statusHum.style.color = "red";
                }
            });
        }

        fetchDataHistory();
        setInterval(fetchDataHistory
        , 2000);
    </script>
</body>
</html>
