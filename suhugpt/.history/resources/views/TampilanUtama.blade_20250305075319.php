let temperatureChart_{{ $alat->id_mesin }};
let humidityChart_{{ $alat->id_mesin }};

function fetchData{{ $alat->id_mesin }}() {
    let limit = document.getElementById("limit_{{ $alat->id_mesin }}").value || 10; // Ambil nilai limit dari input

    $.ajax({
        url: '/sensor/fetch-data',
        method: 'GET',
        data: {
            id_mesin: "{{ $alat->id_mesin }}",
            limit: limit
        },
        dataType: 'json',
        success: function(data) {
            if (data.length === 0) {
                document.getElementById("lastUpdate_{{ $alat->id_mesin }}").textContent = "Tidak ada data";
                return;
            }

            // Ambil labels (waktu) dan data suhu/kelembaban
            const labels = data.map(item => new Date(item.waktu).toLocaleTimeString());
            const tempData = data.map(item => item.suhu);
            const humData = data.map(item => item.kelembaban);

            document.getElementById("lastUpdate_{{ $alat->id_mesin }}").textContent = labels[labels.length - 1];

            // Jika grafik sudah ada, cukup update datanya
            if (temperatureChart_{{ $alat->id_mesin }}) {
                temperatureChart_{{ $alat->id_mesin }}.data.labels = labels; // Perbarui labels (sumbu X)
                temperatureChart_{{ $alat->id_mesin }}.data.datasets[0].data = tempData; // Perbarui data suhu
                temperatureChart_{{ $alat->id_mesin }}.update();
            } else {
                // Jika grafik belum ada, buat baru
                temperatureChart_{{ $alat->id_mesin }} = new Chart(document.getElementById("temperatureChart_{{ $alat->id_mesin }}").getContext('2d'), {
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
            }

            if (humidityChart_{{ $alat->id_mesin }}) {
                humidityChart_{{ $alat->id_mesin }}.data.labels = labels; // Perbarui labels (sumbu X)
                humidityChart_{{ $alat->id_mesin }}.data.datasets[0].data = humData; // Perbarui data kelembaban
                humidityChart_{{ $alat->id_mesin }}.update();
            } else {
                humidityChart_{{ $alat->id_mesin }} = new Chart(document.getElementById("humidityChart_{{ $alat->id_mesin }}").getContext('2d'), {
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
            }
        }
    });
}

// Jalankan pertama kali dan perbarui setiap 2 detik
fetchData{{ $alat->id_mesin }}();
setInterval(fetchData{{ $alat->id_mesin }}, 2000);
