@extends('component.dashboard')
@section('main')

<div class="container">
    <h2 class="text-center mb-4">Daftar Configuration</h2> {{-- Pastikan judul di tengah --}}

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="row d-flex justify-content-center"> {{-- Pusatkan isi row --}}
        @foreach($configurations as $configuration)
            <div class="col-md-6 col-lg-4 d-flex justify-content-center"> {{-- Pastikan setiap card tetap di tengah --}}
                <div class="configuration text-center border p-4 shadow rounded w-100"> {{-- Tambahkan styling agar rapi --}}
                    <h5 class="configuration-title">{{ $configuration->id_mesin }}</h5>
                    <p class="configuration-text">Batas Atas Suhu: {{ $configuration->batas_atas_suhu }}°C</p>
                    <p class="configuration-text">Batas Bawah Suhu: {{ $configuration->batas_bawah_suhu }}°C</p>
                    <p class="configuration-text">Batas Atas Kelembaban: {{ $configuration->batas_atas_kelembaban }}%</p>
                    <p class="configuration-text">Batas Bawah Kelembaban: {{ $configuration->batas_bawah_kelembaban }}%</p>

                    <a href="{{ route('configuration.edit', $configuration->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('alats.destroy', $configuration->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
