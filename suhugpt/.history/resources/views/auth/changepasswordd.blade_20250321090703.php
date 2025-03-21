<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap & Ionicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <title>Ganti Password</title>
</head>
<body>
    <div class="login-dark">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <h5 class="text-center mb-3">Ganti Password</h5>

            <p class="text-center">Hello, <strong>{{ Auth::user()->name }}</strong>. Please change your password.</p>
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="form-group">
                <input class="form-control" type="password" name="current_password" placeholder="Old Password" required>
                @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <input class="form-control" type="password" name="new_password" placeholder="New Password" required>
                @error('new_password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <input class="form-control" type="password" name="new_password_confirmation" placeholder="Confirm New Password" required>
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-block" onclick="OnLogout()">Submit</button>
            </div>

            <a class="ForgotPassword" href="{{route ('forgot.password')}}" style="float: right">Forgot Password?</a>
        </form>
    </div>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>

    </script>

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
            background-color: #0f0f00;
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

        .login-dark .ForgotPassword {
            display: block;
            font-size: 12px;
            color: #6f7a85;
            text-decoration: none;
            margin-top: 10px;
        }

        .login-dark .ForgotPassword:hover {
            color: #fff;
        }

        body {
            overflow: hidden;
        }
    </style>
</body>
</html>
