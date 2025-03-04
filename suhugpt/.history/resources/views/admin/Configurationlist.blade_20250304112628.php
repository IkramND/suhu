<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
</head>
<body>


<div class="container">

<h2>Daftar configuration</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($configurations as $configuration)
            <div class="col-md-4">
                <div class="configuration mb-3">
                    <div class="configuration-body">
                        <h5 class="configuration-title">{{ $configuration->id_mesin }}</h5>
                        <p class="configuration-text">{{ $configuration->batas_atas_suhu }}</p>
                        <p class="configuration-title">{{ $configuration->batas_bawah_suhu }}</p>
                        <p class="configuration-text">{{ $configuration->batas_atas_kelembaban }}</p>
                        <p class="configuration-text">{{ $configuration->batas_bawah_kelembaban }}</p>


                        <a href="{{ route('configuration.edit', $configuration->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('alats.destroy', $configuration->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
