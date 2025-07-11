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

        .btn-warning {
            background-color: orange;
        }

        .btn-danger {
            background-color: red;
        }

        .btn:hover {
            opacity: 0.8;
        }

        @media (max-width:800px) {
            .container {

                margin: 85px auto 0 auto;

            }

        }
    </style>

    <div class="container">
        @foreach ($dataretentions as $dataretention)
            <div class="card">
                <h5 class="card-title">Data Retention</h5>
                <p class="card-text"> <span
                        style="color:solid black; font-weight:bold ">{{ $dataretention->year }} Years</span></p>
                <a href="{{ route('dataretention.edit', $dataretention->id) }}" class="btn btn-warning">Edit</a>
            </div>
        @endforeach
    </div>
@endsection
