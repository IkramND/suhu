<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h2>Edit Card</h2>

        <form action="{{ route('configuration.update', $configuration->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Id_mesin</label>
                <input type="text" name="id_mesin" id="id_mesin" class="form-control" value="{{ $configuration->id_mesin }}" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">batas_atas_suhu</label>
                <input type="text" name="batas_atas_suhu" id="batas_atas_suhu" class="form-control" value="{{ $configuration->batas_atas_suhu }}" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">batas_bawah_suhu</label>
                <input type="text" name="batas_bawah_suhu" id="batas_bawah_suhu" class="form-control" value="{{ $configuration->batas_bawah_suhu }}" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">batas_atas_kelembaban</label>
                <input type="text" name="batas_atas_kelembaban" id="batas_atas_kelembaban" class="form-control" value="{{ $configuration->batas_atas_kelembaban }}" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">batas_bawah_kelembaban</label>
                <input type="text" name="batas_bawah_kelembaban" id="batas_bawah_kelembaban" class="form-control" value="{{ $configuration->batas_bawah_kelembaban }}" required>
            </div>


            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('configuration.list') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>




