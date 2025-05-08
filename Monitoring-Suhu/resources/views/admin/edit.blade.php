<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <div class="container">
        <h2>Edit Card</h2>

        <form action="{{ route('alats.update', $alat->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Id_mesin</label>
                <input type="text" name="id_mesin" id="id_mesin" class="form-control" value="{{ $alat->id_mesin }}" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">ip_address</label>
                <input type="text" name="ip_address" id="ip_address" class="form-control" value="{{ $alat->ip_address }}" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">lokasi</label>
                <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ $alat->lokasi }}" required>
            </div>


            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('card.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
