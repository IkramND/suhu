    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Data Suhu {{ $lokasi }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="container mt-5">

        <h2 class="mb-3">Data Suhu {{ $lokasi }}</h2>

        <!-- Form untuk memilih rentang waktu dan lokasi -->
        <form method="GET" class="mb-3">
            <label for="tanggal_awal">Tanggal Awal:</label>
            <input type="date" name="tanggal_awal" value="{{ $tanggal_awal }}" required>

            <label for="tanggal_akhir">Tanggal Akhir:</label>
            <input type="date" name="tanggal_akhir" value="{{ $tanggal_akhir }}" required>
            <br>
            <br>
            <label for="lokasi">Lokasi:</label>
            <select name="lokasi" id="lokasi" class="form-control" required>
                <option value="ROB1" {{ $lokasi == 'ROB1' ? 'selected' : '' }}>ROB1</option>
                <option value="ROB2" {{ $lokasi == 'ROB2' ? 'selected' : '' }}>ROB2</option>
                <option value="ROB3" {{ $lokasi == 'ROB3' ? 'selected' : '' }}>ROB3</option>
            </select>

            <button type="submit" class="btn btn-primary mt-3">Filter</button>
        </form>

        <!-- Tabel untuk menampilkan data -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal & Waktu</th>
                    <th>Suhu (°C)</th>
                    <th>Kelembaban (%)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->timestamp }}</td>
                        <td>{{ $row->temperature }}°C</td>
                        <td>{{ $row->humidity }}%</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Data tidak ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>

    </body>
    </html>
