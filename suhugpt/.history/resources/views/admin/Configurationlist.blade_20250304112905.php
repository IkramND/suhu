@extends('component.dashboard')
@section('main')

<div class="container text-center"> {{-- Tambahkan text-center untuk judul --}}
    <h2>Daftar Configuration</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row d-flex justify-content-center"> {{-- Gunakan flexbox agar konten berada di tengah --}}
        @foreach($configurations as $configuration)
            <div class="col-md-4 mx-auto"> {{-- Tambahkan mx-auto agar posisi lebih ke tengah --}}
                <div class="configuration mb-3 border p-3 shadow-sm rounded"> {{-- Tambahkan border dan shadow agar lebih rapi --}}
                    <div class="configuration-body">
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
            </div>
        @endforeach
    </div>
</div>

@endsection
