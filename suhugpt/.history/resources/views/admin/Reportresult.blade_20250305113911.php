<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 20px; }
        h1 { color: #333; }
        p { font-size: 16px; }
        .footer { margin-top: 50px; font-size: 12px; color: gray; }
    </style>
</head>
<body>
    <h1>{{ $id_mesin }}</h1>
    <p>{{ $ip_address }}</p>
    <p>{{ $lokasi }}</p>

    <div class="footer">Generated on: {{ $date }}</div>
</body>
</html>
