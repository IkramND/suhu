    @extends('component.dashboard')
    @section('main')
        <form action="{{ route ('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                Logout
            </button>
        </form>
        <h2 style="text-align: center;margin-top:5%">Grafik Real-Time Suhu dan Kelembaban</h2>
        <br>

        <div style="width: 500px; padding: 30px; border: 1px solid #ccc; border-radius: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 0 auto;">


            <div class="card">
                <div class="pisah" style="grid-template-columns: 1fr 1fr; display:grid;">
                    <div style="padding-top:12%">
                        <h3>Lokasi :  <span id="LokasiAlat"> memuat...</span></h3>
                        <h3>Status : </h3>
                        <h4>Last update : <span id="lastUpdate">Memuat...</span></h4>
                        <h4>IP  : <span id="IPaddres">Memuat...</span> </h4>
                </div>
                <div>

                <a href="{{route('ROB1')}}" style="color:black" target='_blank'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="23" fill="currentColor" class="bi bi-clock-history" viewBox="2 0 14 16" style="float:right;">
                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                    </a>
                    <br>
                    {{-- <br> --}}
                    <div class="kotak">
                    <p style="text-align: right; margin-right:2%"><span id="latestTemperature">Memuat...</span>  °</p>
                    <hr style="width: 100%;border:solid black 1px">
                    <p style="text-align: right"><span id="latestHumidity">Memuat...</span> %</p>
                </div>

                </div>
                </div>
                <hr style="border:solid black 1px">
                <h3>Grafik Suhu</h3>
                {{-- <h4>Alat: <span id="statusTemp">Memuat...</span></h4> --}}
                <canvas id="temperatureChart"></canvas>
                <hr style="border:solid black 1px">

                <h3>Grafik Kelembaban</h3>
                {{-- <h4>Alat: <span id="statusHum">Memuat...</span></h4> --}}
                <canvas id="humidityChart"></canvas>
                <hr style="border:solid black 1px">
            {{-- </div>
            </div> --}}
        </div>
        </div>

        <script>
            const tempCtx = document.getElementById('temperatureChart').getContext('2d');
            const humCtx = document.getElementById('humidityChart').getContext('2d');
            const lastUpdateTemp = document.getElementById('lastUpdate');
            const IPaddres = document.getElementById('IPaddres');
            const LokasiAlat = document.getElementById('LokasiAlat');

            let tempChart, humChart;

            function fetchData() {
    $.ajax({
        url: '/sensor/fetch-data',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.length === 0) {
                lastUpdate.textContent = "Tidak ada data";
                return;
            }

            // Format waktu menjadi "Hari, Jam:Menit" (contoh: "Sen, 14:30")
            const labels = data.map(item => {
                const date = new Date(item.waktu);
                const day = date.toLocaleDateString('id-ID', { weekday: 'short'}); // Sen, Sel, Rab, dst.
                const time = date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                return `${day} , ${time}`;
            });

            const tempData = data.map(item => item.suhu);
            const humData = data.map(item => item.kelembaban);

            const latestTimestamp = labels[labels.length - 1];
            lastUpdate.textContent = `${latestTimestamp}`;
            document.getElementById("latestTemperature").textContent = tempData[tempData.length - 1];
            document.getElementById("latestHumidity").textContent = humData[humData.length - 1];

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
                    options: { responsive: true }
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
                    options: { responsive: true }
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
        }
    });
}


            function fetchIPAddress() {
        $.ajax({
            url: '/sensor/ip-address', // Route yang dibuat di Laravel
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.ip_address) {
                    document.getElementById("IPaddres").textContent = data.ip_address;
                } else {
                    document.getElementById("IPaddres").textContent = "Tidak ditemukan";
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching IP Address:", error);
                document.getElementById("IPaddres").textContent = "Gagal memuat IP";
            }
        });
    }

    function fetchlokasi() {
        $.ajax({
            url: '/sensor/lokasi', // Route yang dibuat di Laravel
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.lokasi) {
                    document.getElementById("LokasiAlat").textContent = data.lokasi;
                } else {
                    document.getElementById("LokasiAlat").textContent = "Tidak ditemukan";
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching IP Address:", error);
                document.getElementById("LokasiAlat").textContent = "Gagal memuat lokasi";
            }
        });
    }


            fetchData();
            setInterval(fetchData, 2000);
            fetchIPAddress();
            fetchlokasi();

        </script>
    @endsection
