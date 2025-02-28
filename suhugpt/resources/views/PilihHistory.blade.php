{{-- <form id="historyForm" action="{{ route('History.page') }}" method="GET">
    <label for="id_mesin">Pilih ID Mesin:</label>
    <input type="text" id="id_mesin" name="id_mesin" required>
    <label for="start_date">Mulai:</label>
    <input type="date" id="start_date" name="start_date">
    <label for="end_date">Selesai:</label>
    <input type="date" id="end_date" name="end_date">

    <label for="lokasi">Lokasi:</label>
    <input type="text" name="lokasi" id="lokasi" class="form-control" required>

    <label for="ip">IP Address:</label>
    <input type="text" name="ip" id="ip" class="form-control" required>
    <button type="submit">SUBMIT</button>
</form> --}}


{{-- form awal fix --}}
{{--
<form id="historyForm" action="{{ route('History.page') }}" method="GET">
    <label for="lokasi">Lokasi:</label>
    <input type="text" name="lokasi" id="lokasi" class="form-control" required>

    <label for="ip">IP Address:</label>
    <input type="text" name="ip" id="ip" class="form-control" required>

    <label for="id_mesin">ID Mesin:</label>
    <input type="text" name="id_mesin" id="id_mesin" class="form-control" required>

    <button type="submit" class="btn btn-primary mt-2">Tampilkan Data</button>
</form> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form id="historyForm" action="{{ route('History.page') }}" method="GET">
    @csrf  <!-- Tambahkan jika diperlukan -->

    <div class="form-group">
        <label for="lokasi">Lokasi:</label>
        <input type="text" name="lokasi" id="lokasi" class="form-control" required placeholder="Masukkan lokasi">
    </div>

    <div class="form-group">
        <label for="ip">IP Address:</label>
        <input type="text" name="ip" id="ip" class="form-control" required
               placeholder="Masukkan IP Address"
               pattern="^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$"
               title="Format IP harus benar, contoh: 192.168.1.1">
    </div>

    <div class="form-group">
        <label for="id_mesin">ID Mesin:</label>
        <input type="text" name="id_mesin" id="id_mesin" class="form-control" required placeholder="Masukkan ID Mesin">
    </div>

    <button type="submit" class="btn btn-primary mt-2">Tampilkan Data</button>
</form>

</body>
</html>


<!-- Area untuk menampilkan data -->
{{-- <div id="chart-container"> --}}
    {{-- <h3>Grafik Suhu dan Kelembaban</h3> --}}
    {{-- <canvas id="temperatureChart"></canvas>
    <canvas id="humidityChart"></canvas>
</div> --}}

