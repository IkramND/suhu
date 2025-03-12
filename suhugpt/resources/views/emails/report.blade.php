<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Mesin</title>
</head>
<body>
    <h2>Laporan Mesin</h2>
    <p>Halo,</p>
    <p>Berikut adalah laporan untuk mesin dengan ID: <strong>{{ $data['id_mesin'] }}</strong></p>
    <p>Rentang Tanggal: <strong>{{ $data['start_date'] }} - {{ $data['end_date'] }}</strong></p>
    <p>Silakan unduh laporan dalam lampiran.</p>
    <br>
    <p>Terima kasih,</p>
    <p>Tim Support</p>
</body>
</html>
