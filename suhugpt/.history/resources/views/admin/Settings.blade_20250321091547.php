<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap & Ionicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <title>Confoguration</title>

    <style>
         /* Menghilangkan spinner di input number */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    </style>
</head>
<body>

    <div class="login-dark">
        <form method="POST" action="{{ route('add.configuration') }}">
            @csrf
            <div class="illustration"><i class="icon ion-settings"></i></div>
            <h5 class="text-center mb-3">Configurations</h5>

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger text-center">
                    <ul class="list-unstyled mb-0" style="background: #0f0f0f">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <input type="text" class="form-control" name="id_mesin" placeholder="Machine ID" required>
            </div>

            <div class="form-group">
                <input type="number" class="form-control" name="batas_atas_suhu" placeholder="Upper limit of temperature" required>
            </div>

            <div class="form-group">
                <input type="number" class="form-control" name="batas_bawah_suhu" placeholder="Lower limit of temperature" required>
            </div>

            <div class="form-group">
                <input type="number" class="form-control" name="batas_atas_kelembaban" placeholder="Upper limit of humidity " required>
            </div>

            <div class="form-group">
                <input type="number" class="form-control" name="batas_bawah_kelembaban" placeholder="Lower limit of humidity" required>
            </div>

            <div class="form-group">
                <button type="number" class="btn btn-primary btn-block">SUBMIT</button>
            </div>
        </form>
    </div>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Styling -->
    <style>
        .login-dark {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #000000;
        }

        .login-dark form {
            width: 100%;
            max-width: 350px;
            background-color: #0f0f0f;
            padding: 40px;
            border-radius: 5px;
            text-align: center;
            color: #fff;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
        }

        .login-dark .illustration {
            font-size: 80px;
            color: blue;
            margin-bottom: 20px;
        }

        .login-dark .form-control {
            background: none;
            border: none;
            border-bottom: 1px solid #434a52;
            border-radius: 0;
            box-shadow: none;
            outline: none;
            color: inherit;
            padding: 10px;
        }

        .login-dark .form-control::placeholder {
            color: #ccc;
        }

        .login-dark .btn-primary {
            background: blue;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
        }

        .login-dark .btn-primary:hover {
            background: darkblue;
        }

        .alert {
            font-size: 14px;
            border-radius: 4px;
            padding: 10px;
        }

        body {
            overflow: hidden;
        }
    </style>
</body>
</html>
