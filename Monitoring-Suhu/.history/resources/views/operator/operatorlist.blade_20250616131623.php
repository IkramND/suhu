@extends('component.dashboard')
@section('main')

<style>
    .container {
        width: 60%;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        padding: 20px;
        margin-top: 75px;
        margin-left: 25%;
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
    .btn-orange {
        background-color: orange;
    }
    .btn-danger {
        background-color: red;
    }
    .btn:hover {
        opacity: 0.8;
    }
    .btn-warning{
        background-color:orange
    }
</style>

<div class="container">
    @foreach($operators as $operator)
        <div class="card">
            <h2>{{ $operator->name }}</h2>
    <div style="display: flex; flex-wrap: wrap; gap: 5px; justify-content: center;">
    @foreach(json_decode($operator->acess, true) as $id_mesin)
    <span style="
        /* background-color: blue; */
        color: white;
        background:green;
        padding: 3px 8px;
        /* border-radius: 12px; */
        font-size: 12px;
        display: inline-block;
        max-width: 80px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight:bold;"
        title="{{ $id_mesin }}">
        {{ $id_mesin }}
    </span>
@endforeach
</div>
<br>

            <a href="{{ route('operator.edit', $operator->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('operator.destroy', $operator->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
            </form>
        </div>
    @endforeach
</div>


@endsection
