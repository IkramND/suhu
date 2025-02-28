@extends('component.dashboard')
@section('main')
<h2>Grafik Suhu & Kelembaban ROB1</h2>

<div style="margin-bottom: 20px; text-align: center; margin-top: 3%;">
    <label for="id_mesin">Pilih Mesin:</label>
    <select id="id_mesin">
        @foreach($alats as $alat)
            <option value="{{ $alat->id_mesin }}">{{ $alat->id_mesin }} - {{ $alat->lokasi }}</option>
        @endforeach
    </select>

    <input type="date" id="start_date">
    <label for="end_date" style="padding-left: 1%;padding-right:1%"> - </label>
    <input type="date" id="end_date">
</div>

<div id="chartContainer" style="width: 500px; padding: 30px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 0 auto;">
    <canvas id="temperatureChart"></canvas>
    <hr id="chartDivider" style="border: solid black 1px; display: none;">
    <canvas id="humidityChart" style="margin-top: 30px;"></canvas>
</div>

<script>
    function fetchDataHistory() {
        let id_mesin = document.getElementById("id_mesin").value;
        let startDate = document.getElementById("start_date").value;
        let endDate = document.getElementById("end_date").value;

        $.ajax({
            url: '/sensor/fetch-history',
            method: 'GET',
            data: { id_mesin: id_mesin, start_date: startDate, end_date: endDate },
            dataType: 'json',
            success: function(data) {
                if (data.length === 0) {
                    alert("Tidak ada data dalam rentang waktu yang dipilih.");
                    return;
                }

                const labels = data.map(item => `${item.hari}, ${item.tanggal}`);
                const tempData = data.map(item => parseFloat(item.rata_rata_suhu));
                const humData = data.map(item => parseFloat(item.rata_rata_kelembaban));

                new Chart(document.getElementById("temperatureChart").getContext('2d'), {
                    type: 'line',
                    data: { labels: labels, datasets: [{ label: 'Suhu (°C)', data: tempData, borderColor: 'red', fill: false }] }
                });

                new Chart(document.getElementById("humidityChart").getContext('2d'), {
                    type: 'line',
                    data: { labels: labels, datasets: [{ label: 'Kelembaban (%)', data: humData, borderColor: 'blue', fill: false }] }
                });
            }
        });
    }

    document.getElementById("id_mesin").addEventListener("change", fetchDataHistory);
    document.getElementById("start_date").addEventListener("change", fetchDataHistory);
    document.getElementById("end_date").addEventListener("change", fetchDataHistory);
</script>
@endsection


