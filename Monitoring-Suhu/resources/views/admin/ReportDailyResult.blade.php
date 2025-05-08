<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
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
        <h1>Report {{ $id_mesin }}</h1>
        <br>
        <br>
        <div style="text-align:left;padding-left:2%">
        <p><strong>IP Address:</strong> {{ $ip_address }}</p>
        <p><strong>Location:</strong> {{ $lokasi }}</p>
        <p><strong>Date:</strong> {{\Carbon\Carbon::parse($dates)->format('d-m-Y')}}</p>
    </div>



        <table>
            <thead>
                <tr>
                    <th rowspan="2">TIME</th>
                    <th colspan="3">Temperature (°C)</th>
                    <th colspan="3">Humidity (%)</th>
                </tr>
                <tr>
                    <th>Average</th>
                    <th>Lowest</th>
                    <th>Highest</th>
                    <th>Average</th>
                    <th>Lowest</th>
                    <th>Highest</th>

                </tr>
            </thead>
            <tbody>
                @foreach($sensor_data as $data)
                <tr>
                    <td>{{ str_pad($data->Jam, 2, '0', STR_PAD_LEFT) . ':00' }}</td>
                    <td>{{ number_format($data->average_temperature,2) }}</td>
                    <td>{{ number_format($data->lowest_temperature,2) }}</td>
                    <td>{{ number_format($data->highest_temperature,2) }}</td>
                    <td>{{ number_format($data->average_humidity,2) }}</td>
                    <td>{{ number_format($data->lowest_humidity,2) }}</td>
                    <td>{{ number_format($data->highest_humidity,2) }}</td>
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
