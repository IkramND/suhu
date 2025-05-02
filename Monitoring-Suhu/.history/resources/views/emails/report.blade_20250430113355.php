<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Mesin</title>
</head>
<body>
    <h2>Machine Report</h2>
    <p>Halo,</p>
    <p>Here is the report for the machine with ID: <strong>{{ $data['id_mesin'] }}</strong></p>
    <p>Date Range: <strong>{{ $start_date }}  -  {{ $end_date }}</strong></p>
    <p>Please download the report in the attachment.</p>
    <br>
    <p>Thank You,</p>
</body>
</html>
