    @extends('component.dashboard')
    @section('main')
    <h2>Grafik Suhu & Kelembaban ROB1</h2>

    <!-- Form Filter Tanggal -->
    <div style="margin-bottom: 20px;text-align:center;margin-top:3%">
        {{-- <label for="start_date">Dari Tanggal:</label> --}}
        <input type="date" id="start_date">

        <label for="end_date" style="padding-left: 1%;padding-right:1%"> - </label>
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

        function fetchDataHistoryROB1(startDate = '', endDate = '') {
    $.ajax({
        url: '/sensor/fetch-data-rob1',
        method: 'GET',
        data: { start_date: startDate, end_date: endDate },
        dataType: 'json',
        success: function(data) {
            if (data.length === 0) {
                alert("Tidak ada data dalam rentang waktu yang dipilih.");
                return;
            }

            const labels = data.map(item => `${item.hari}, ${item.tanggal}`); // Format: Senin, 2024-02-26
            const tempData = data.map(item => parseFloat(item.rata_rata_suhu)); // Konversi string ke angka
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

        // Event listener untuk memperbarui grafik otomatis saat tanggal dipilih
        document.getElementById("start_date").addEventListener("change", () => {
            fetchDataHistoryROB1(document.getElementById("start_date").value, document.getElementById("end_date").value);
        });

        document.getElementById("end_date").addEventListener("change", () => {
            fetchDataHistoryROB1(document.getElementById("start_date").value, document.getElementById("end_date").value);
        });

        // Load semua data saat pertama kali halaman dibuka
        fetchDataHistoryROB1();
    </script>
@endsection

