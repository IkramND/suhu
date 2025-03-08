@extends('component.dashboard')
@section('main')




<div style="margin-bottom: 20px; text-align: center; margin-top: 10%;">
    <input type="hidden" id="id_mesin" value="{{ $id_mesin}}">
    {{-- <input type="hidden" id="ip_address" value="{{ $ip_address }}">  IP address dari halaman sebelumnya --}}
<div style="margin-top:7%">
    <input type="date" id="start_date">
    <label for="end_date" style="padding-left: 1%;padding-right:1%"> - </label>
    <input type="date" id="end_date">
</div>
</div>

<div id="chartContainer" style="width: 500px; padding: 30px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 0 auto;">
    <div style="margin-top: 10%;">
    <center>
        <h2>{{ $id_mesin }}</h2>

        <h2>{{ $ip_address }}</h2>
    </center>
    </div>
    <hr style="border:1px solid black">
    <canvas id="temperatureChart"></canvas>
    <hr id="chartDivider" style="border: solid black 1px; display: none;">
    <canvas id="humidityChart" style="margin-top: 30px;"></canvas>
</div>

<script>
    let temperatureChart = null;
let humidityChart = null;

function fetchDataHistory(startDate = '', endDate = '') {
    let id_mesin = document.getElementById("id_mesin").value;

    // Jika ingin update berdasarkan tanggal, pastikan kedua tanggal dipilih
    if ((startDate && !endDate) || (!startDate && endDate)) {
        return; // Stop jika hanya satu tanggal yang dipilih
    }

    if (!id_mesin) {
        alert("Machine ID not found!");
        return;
    }

    $.ajax({
        url: '/sensor/fetch-history',
        method: 'GET',
        data: { id_mesin: id_mesin, start_date: startDate, end_date: endDate },
        dataType: 'json',
        success: function(data) {
            if (data.length === 0) {
                alert("There is no data in the selected time range.");
                return;
            }

            const labels = data.map(item => `${item.hari}, ${item.tanggal}`,new Date(item.waktu).toLocaleTimeString([],{hour: '2-digit', minute: '2-digit',hour12:false}));
            const tempData = data.map(item => parseFloat(item.rata_rata_suhu));
            const humData = data.map(item => parseFloat(item.rata_rata_kelembaban));

            let ctxTemp = document.getElementById("temperatureChart").getContext('2d');
            let ctxHum = document.getElementById("humidityChart").getContext('2d');

            // 🔥 Hancurkan chart jika sudah ada sebelumnya
            if (temperatureChart) {
                temperatureChart.destroy();
            }
            if (humidityChart) {
                humidityChart.destroy();
            }

            // 🎨 Buat chart baru setelah menghancurkan yang lama
            temperatureChart = new Chart(ctxTemp, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{ label: 'Suhu (°C)', data: tempData, borderColor: 'red', fill: false }]
                }
            });

            humidityChart = new Chart(ctxHum, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{ label: 'Kelembaban (%)', data: humData, borderColor: 'blue', fill: false }]
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", xhr.responseText);
        }
    });
}

// ✅ Panggil fetchDataHistory saat halaman pertama kali dimuat (tanpa filter)
document.addEventListener("DOMContentLoaded", function () {
    fetchDataHistory();
});

// ✅ Panggil fetchDataHistory hanya saat kedua tanggal dipilih
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
