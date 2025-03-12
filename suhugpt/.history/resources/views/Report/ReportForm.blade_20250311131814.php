<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <title>Generate PDF</title>
    <style>

        /* Menghilangkan spinner di input number */
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
        html, body {
            overflow: hidden;
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>




    <div class="login-dark" style="height: 100vh;">

        <form action="{{ route('report.result') }}" method="POST">

            @csrf
            <div class="illustration"><i class="ion-clipboard"></i></div>
           @if ($errors->any())
    <div style="color: red; padding: 10px; border-radius: 5px;">
            @foreach ($errors->all() as $error)
                <p><i>{{" * $error "}}</i></p>
            @endforeach

    </div>
@endif


            <select name="id_mesin" id="id_mesin">
                @foreach ($alats as $alat )

                <option value="{{ $alat->id }}">{{ $alat->id_mesin }}</option>
                @endforeach

            </select>
            {{-- <div class="form-group"><input class="form-control" type="text" name="id_mesin" placeholder="Machine ID" required></div> --}}
            <div class="form-group"><input class="form-control" type="number" name="month" placeholder="Month" required></div>
            <div class="form-group"><input class="form-control" type="number" name="year" placeholder="Year" required></div>

            {{-- <div class="form-group"><input class="form-control" type="text" name="ip_address" placeholder="IP Address" required></div>
            <div class="form-group"><input class="form-control" type="text" name="lokasi" placeholder="Location" required></div> --}}
            <div class="form-group">
                {{-- <input class="form-control" type="date" name="start_date" required>
            </div>

            <div class="form-group">
                <input class="form-control" type="date" name="end_date" required>
            </div> --}}

            <div class="form-group">
                <button class="btn btn-primary btn-block" style="background-color:blue">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <style>
        .login-dark {
            height: 100vh;
            background-size: cover;
            position: relative;
            background: #1e2833;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-dark form {
            max-width: 400px;
            width: 90%;
            background-color: #252d37;
            padding: 40px;
            border-radius: 4px;
            color: #fff;
            box-shadow: 3px 3px 4px rgba(0,0,0,0.2);
        }

        .login-dark .illustration {
            text-align: center;
            padding: 15px 0 20px;
            font-size: 100px;
            color: blue;
        }

        .login-dark form .form-control {
            background: none;
            border: none;
            border-bottom: 1px solid #434a52;
            border-radius: 0;
            box-shadow: none;
            outline: none;
            color: inherit;
        }

        .login-dark form .btn-primary {
            background: #214a80;
            border: none;
            border-radius: 4px;
            padding: 11px;
            box-shadow: none;
            margin-top: 26px;
            text-shadow: none;
            outline: none;
        }

        .login-dark form .btn-primary:hover {
            background: #1a3b6e;
        }
    </style>
</body>
</html>
