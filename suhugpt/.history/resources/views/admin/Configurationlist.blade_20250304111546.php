@extends('component.dashboard')

@section('content')
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Machine ID</th>
            <th>Upper Temperature Limit</th>
            <th>Lower Temperature Limit</th>
            <th>Upper Humidity Limit</th>
            <th>Lower Humidity Limit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($configurations as $configuration)
        <tr>
            <td>{{ $configuration->id }}</td>
            <td>{{ $configuration->id_mesin }}</td>
            <td>{{ $configuration->batas_atas_suhu }}</td>
            <td>{{ $configuration->batas_bawah_suhu }}</td>
            <td>{{ $configuration->batas_atas_kelembaban }}</td>
            <td>{{ $configuration->batas_bawah_kelembaban }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
