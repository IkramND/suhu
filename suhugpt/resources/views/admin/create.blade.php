<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h2>Tambah alat</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="id_mesin" class="form-label">id_mesin</label>
                <input type="text" class="form-control" id="id_mesin" name="id_mesin" required>
            </div>
            <div class="mb-3">
                <label for="ip_address" class="form-label">ip_address</label>
                <input type="text" class="form-control" id="ip_address" name="ip_address" required>
            </div>
            <div class="mb-3">
                <label for="lokasi" class="form-label">lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" required>
            </div>
            <button type="submit" class="btn btn-primary">submit</button>
        </form>
    </div>
</body>
</html>
