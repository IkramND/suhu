@extends('component.navbar')
@section('mains')
    </form>
    <br>

    @foreach($alats as $alat)
        <div style="width: 30%; padding: 30px; border: 1px solid #ccc; border-radius: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 20px auto; margin-top:10%">

            <div class="card">
                <div class="pisah" style="grid-template-columns: 1fr 1fr; display:grid;">
                    <div style="padding-top:12%">
                        <h3>Location :  {{ $alat->lokasi }}</h3>
                        <h3>Status : </h3>
                        <h4>Last update : <span id="lastUpdate_{{ $alat->id_mesin }}">Loading...</span></h4>
                        <h4>IP  : {{ $alat->ip_address }} </h4>
                    </div>
                </div>

                <hr style="border: solid black 1px">

                <!-- Input untuk mengatur jumlah data -->
                <label for="limit_{{ $alat->id_mesin }}">Amount of data : </label>
                <input type="number" id="limit_{{ $alat->id_mesin }}" value="" min="1" max="100">
                <button onclick="fetchData{{ $alat->id_mesin }}()" style="background-color: blue; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">Update</button>

                <hr style="border: solid black 1px">
                <canvas id="temperatureChart_{{ $alat->id_mesin }}"></canvas>
                <br>
                <hr style="border: solid black 1px">
                <canvas id="humidityChart_{{ $alat->id_mesin }}"></canvas>
            </div>
        </div>

        <script>
            let temperatureChart_{{ $alat->id_mesin }};
            let humidityChart_{{ $alat->id_mesin }};

            function fetchData{{ $alat->id_mesin }}() {
                let limit = document.getElementById("limit_{{ $alat->id_mesin }}").value || 10; // Ambil nilai limit

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

                        const labels = data.map(item => new Date(item.waktu).toLocaleTimeString());
                        const tempData = data.map(item => item.suhu);
                        const humData = data.map(item => item.kelembaban);

                        document.getElementById("lastUpdate_{{ $alat->id_mesin }}").textContent = labels[labels.length - 1];

                        // Hapus instance lama sebelum membuat yang baru
                        if (temperatureChart_{{ $alat->id_mesin }}) {
                            temperatureChart_{{ $alat->id_mesin }}.destroy();
                        }
                        if (humidityChart_{{ $alat->id_mesin }}) {
                            humidityChart_{{ $alat->id_mesin }}.destroy();
                        }

                        // Buat grafik baru setelah instance lama dihapus
                        temperatureChart_{{ $alat->id_mesin }} = new Chart(document.getElementById("temperatureChart_{{ $alat->id_mesin }}").getContext('2d'), {
                            type: 'line',
                            data: { labels: labels, datasets: [{ label: 'Suhu (°C)', data: tempData, borderColor: 'red', fill: false }] }
                        });

                        humidityChart_{{ $alat->id_mesin }} = new Chart(document.getElementById("humidityChart_{{ $alat->id_mesin }}").getContext('2d'), {
                            type: 'line',
                            data: { labels: labels, datasets: [{ label: 'Kelembaban (%)', data: humData, borderColor: 'blue', fill: false }] }
                        });
                    }
                });
            }

            fetchData{{ $alat->id_mesin }}();
            setInterval(fetchData{{ $alat->id_mesin }}, 2000);
        </script>

    @endforeach
@endsection
