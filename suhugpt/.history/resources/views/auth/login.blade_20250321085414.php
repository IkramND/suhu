<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <title>Login Page</title>
</head>
<body>
    <div class="login-dark">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            @if ($errors->any())
            <div class="alert" style="background: #252d37">
               <span style="color: red;"><i>{{  $errors->first()}}</i></span>
            </div>
            @endif
            <div class="form-group"><input class="form-control" type="text" name="name" placeholder="Username" required></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password" required></div>
            <div class="form-group"><button class="btn btn-primary btn-block" style="background-color:#1E40AF; border-color: #1E40AF;">Log In</button></div>
            <a class="ForgotPassword" href="{{route ('forgot.password')}}" style="float: right; color: #1E40AF;">Forgot Password?</a>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        .login-dark {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #1E40AF;
        }
        .login-dark form {
            max-width: 320px;
            width: 90%;
            background-color: #FFFFFF;
            padding: 40px;
            border-radius: 8px;
            color: #000;
            box-shadow: 3px 3px 10px rgba(0,0,0,0.1);
        }
        .login-dark .illustration {
            text-align: center;
            padding: 15px 0 20px;
            font-size: 100px;
            color: #1E40AF;
        }
        .login-dark form .form-control {
            border: 1px solid #1E40AF;
            color: #000;
        }
        .login-dark form .btn-primary:hover,
        .login-dark form .btn-primary:active {
            background: #162D67;
            border-color: #162D67;
        }
    </style>
</body>
</html>
