{{-- @extends('component.dashboard')
@section('main')

<h2 style="text-align: center;margin-top:5%">Grafik Suhu dan Kelembaban: {{ $lokasi->nama_lokasi }}</h2>

<div style="width: 500px; padding: 30px; border: 1px solid #ccc; border-radius: 30px; margin: 0 auto;">
    <h3>IP: {{ $lokasi->ip_addres }}</h3>
    <h3>Last update: <span id="lastUpdate">Memuat...</span></h3>

    <hr>
    <h3>Grafik Suhu</h3>
    <canvas id="temperatureChart"></canvas>

    <hr>
    <h3>Grafik Kelembaban</h3>
    <canvas id="humidityChart"></canvas>
</div>

<script>
    function fetchData() {
        $.ajax({
            url: '/sensor/fetch-data?alat_id={{ $lokasi->id_mesin }}',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.length === 0) {
                    document.getElementById("lastUpdate").textContent = "Tidak ada data";
                    return;
                }

                const labels = data.map(item => item.waktu);
                const tempData = data.map(item => item.suhu);
                const humData = data.map(item => item.kelembaban);
                document.getElementById("lastUpdate").textContent = labels[labels.length - 1];

                new Chart(document.getElementById('temperatureChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{ label: 'Suhu (°C)', data: tempData, borderColor: 'red', fill: false }]
                    },
                    options: { responsive: true }
                });

                new Chart(document.getElementById('humidityChart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{ label: 'Kelembaban (%)', data: humData, borderColor: 'blue', fill: false }]
                    },
                    options: { responsive: true }
                });
            },
            error: function() {
                document.getElementById("lastUpdate").textContent = "Gagal memperbarui data";
            }
        });
    }

    fetchData();
    setInterval(fetchData, 2000);
</script>

@endsection --}}
