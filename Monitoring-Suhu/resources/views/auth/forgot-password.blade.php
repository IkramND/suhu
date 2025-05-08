<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    {{-- <script src="{{ asset('js/script.js') }}" defer></script> --}}
    <style>

        .login-dark {
            height: 100vh;
            background: #000000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-dark form {
            max-width: 320px;
            width: 100%;
            background-color: #0f0f0f;
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
        .login-dark form .btn-primary, .login-dark form .btn-success {
            background: #214a80;
            border: none;
            border-radius: 4px;
            padding: 11px;
            box-shadow: none;
            margin-top: 26px;
            text-shadow: none;
            outline: none;
        }
        .login-dark form .btn-primary:hover, .login-dark form .btn-success:hover {
            background: #1a3b6e;
        }
    </style>
</head>
<body>
    <div class="login-dark">
        <form method="POST" action="{{route('validate.user')}}">
            @csrf
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert" style="background: transparent">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div style="color: red; padding: 10px; border-radius: 5px;">
                    @foreach ($errors->all() as $error)
                        <p><i>* {{ $error }}</i></p>
                    @endforeach
                </div>
            @endif


                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" style="background: blue">Submit</button>
                </div>
        </form>
    </div>
</body>
</html>
