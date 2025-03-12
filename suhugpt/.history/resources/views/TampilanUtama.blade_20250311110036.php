<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .card {
            width: 30%;
            min-width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: #fff;
            text-align: center;
        }
        canvas {
            max-height: 250px !important;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        @foreach($alats as $alat)
            <div class="card">
                <h3>{{ $alat->id_mesin }}</h3>
                <p>ID Mesin: {{ $alat->id_mesin }}</p>
                <canvas id="chart-{{ $alat->id_mesin }}"></canvas>
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @foreach($alats as $alat)
                var ctx = document.getElementById("chart-{{ $alat->id_mesin }}").getContext("2d");
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["00:00", "01:00", "02:00", "03:00", "04:00"],
                        datasets: [{
                            label: 'Suhu',
                            data: [22, 24, 26, 23, 25],
                            borderColor: 'red',
                            fill: false
                        }, {
                            label: 'Kelembaban',
                            data: [60, 62, 64, 63, 61],
                            borderColor: 'blue',
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            @endforeach
        });
    </script>
</body>
</html>
