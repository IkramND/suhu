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
            max-width: 600px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ isset($id_mesin) ? $id_mesin : 'Unknown Machine' }}</h1>
        <p><strong>IP Address:</strong> {{ isset($ip_address) ? $ip_address : 'N/A' }}</p>
        <p><strong>Location:</strong> {{ isset($lokasi) ? $lokasi : 'Unknown Location' }}</p>

        <div class="footer">
            Generated on: {{ isset($date) ? $date : now()->format('d-m-Y H:i:s') }}
        </div>
    </div>
</body>
</html>
