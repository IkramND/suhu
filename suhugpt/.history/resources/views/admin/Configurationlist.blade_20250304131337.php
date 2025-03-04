@extends('component.dashboard')
@section('main')

<style>
    .container {
        width: 60%;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        padding: 20px;
        margin-top: 8%;
        margin-left: 25%;
        /* background: red; */
    }
    .card {
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 10px;
        text-align: center;
        background-color: #fff;
    }
    .card-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .card-text {
        font-size: 16px;
        color: #666;
        margin-bottom: 10px;
    }
    .btn {
        display: inline-block;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        color: white;
        margin: 5px;
    }
    .btn-warning {
        background-color: orange;
    }
    .btn-danger {
        background-color: red;
    }
    .btn:hover {
        opacity: 0.8;
    }
</style>

<div class="container">
    @foreach($configurations as $configuration)
        <div class="card">
            <h5 class="card-title">{{ $configuration->id_mesin }}</h5>
            <p class="card-text">Upper Limit Temperature{{ $configuration->batas_atas_suhu }}</p>
            <p class="card-text">{{ $configuration->batas_bawah_suhu }}</p>
            <p class="card-text">{{ $configuration->batas_atas_kelembaban }}</p>
            <p class="card-text">{{ $configuration->batas_bawah_kelembaban }}</p>
            <p class="card-text">{{ $configuration->lokasi }}</p>

            <a href="{{ route('configuration.edit', $configuration->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('alats.destroy', $configuration->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
            </form>
        </div>
    @endforeach
</div>

@endsection
