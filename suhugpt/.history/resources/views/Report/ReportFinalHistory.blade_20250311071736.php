<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Output</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            margin: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 { color: #333; margin-bottom: 10px; }
        p { font-size: 16px; color: #555; margin: 5px 0; }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: gray;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        .highlight {
            font-weight: bold;
            background-color: #e3f2fd;
        }
    </style>
</head>
<body>





    <div class="container">
        <h1>Report for {{ $id_mesin }}</h1>
        <p><strong>IP Address:</strong> {{ $ip_address }}</p>
        <p><strong>Location:</strong> {{ $lokasi }}</p>
        <p><strong>Month :</strong> {{ $month }}</p>
        <p><strong>Years:</strong> {{ $years }}</p>



        <!-- Tabel Data Suhu & Kelembaban Per Hari -->
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    {{-- <th>Total Suhu (°C)</th> --}}
                    <th>Rata-rata Suhu (°C)</th>
                    {{-- <th>Total Kelembaban (%)</th> --}}
                    <th>Rata-rata Kelembaban (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sensor_data as $data)
                <tr>
                    <td class="highlight">{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                    {{-- <td>{{ number_format($data->total_suhu, 2) }}</td> --}}
                    <td>{{ number_format($data->rata_rata_suhu,2) }}</td>
                    {{-- <td>{{ number_format($data->total_kelembaban, 2) }}</td> --}}
                    <td>{{ number_format($data->rata_rata_kelembaban, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            Generated on: {{ $date }}
        </div>
    </div>
</body>
</html>
