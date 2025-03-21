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

    <title>Edit Configuration</title>
</head>
<body>
    <div class="login-dark">
        <form action="{{ route('configuration.update', $configuration->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="illustration"><i class="ion-settings"></i></div>
            <h5 class="text-center mb-3">Edit Configuration</h5>

            <div class="form-group">
                <input type="text" class="form-control" name="id_mesin" value="{{ $configuration->id_mesin }}" placeholder="ID Mesin" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="batas_atas_suhu" value="{{ $configuration->batas_atas_suhu }}" placeholder="Batas Atas Suhu" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="batas_bawah_suhu" value="{{ $configuration->batas_bawah_suhu }}" placeholder="Batas Bawah Suhu" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="batas_atas_kelembaban" value="{{ $configuration->batas_atas_kelembaban }}" placeholder="Batas Atas Kelembaban" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="batas_bawah_kelembaban" value="{{ $configuration->batas_bawah_kelembaban }}" placeholder="Batas Bawah Kelembaban" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>
            <a href="{{ route('configuration.list') }}" class="btn btn-primary btn-block">Cancel</a>
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
            background: #1e2833;
        }

        .login-dark form {
            width: 100%;
            max-width: 350px;
            background-color: #252d37;
            padding: 20px;
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

        body {
            overflow: hidden;
        }
    </style>
</body>
</html>
