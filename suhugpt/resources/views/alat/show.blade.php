{{-- @extends('component.dashboard')
@section('main')

<h2 style="text-align: center;margin-top:5%">Grafik Real-Time Suhu dan Kelembaban - {{ $alat->nama }}</h2>
<br>

<div style="width: 500px; padding: 30px; border: 1px solid #ccc; border-radius: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 0 auto;">
    <div class="card">
        <div class="pisah" style="grid-template-columns: 1fr 1fr; display:grid;">
            <div style="padding-top:12%">
                <h3>Lokasi : {{ $alat->lokasi }}</h3>
                <h3>Status : {{ $alat->status }}</h3>
                <h4>Last update : <span id="lastUpdate">Memuat...</span></h4>
                <h4>IP : {{ $alat->ip_address }}</h4>
            </div>
            <div>
                <canvas id="temperatureChart"></canvas>
                <canvas id="humidityChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    function fetchData() {
        $.ajax({
            url: '/sensor/fetch-data/{{ $alat->id }}', // Sesuai dengan ID alat
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // Update grafik dan last update di sini...
            }
        });
    }

    fetchData();
    setInterval(fetchData, 2000);
</script>

@endsection --}}
