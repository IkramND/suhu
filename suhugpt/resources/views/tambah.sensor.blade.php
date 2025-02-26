<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('sensor.page') }}" method="GET">
        <label for="lokasi">Lokasi:</label>
        <input type="text" name="lokasi" id="lokasi" class="form-control" required>

        <label for="ip">IP Address:</label>
        <input type="text" name="ip" id="ip" class="form-control" required>

        <button type="submit" class="btn btn-primary mt-2">Tampilkan Data</button>
    </form>

</body>
</html>
