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
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
        <a class="navbar-brand" href="#" style="color: #1E40AF; font-weight: bold;">Monitoring System</a>
    </nav>
    <div class="d-flex">
        <div class="sidebar bg-primary text-white" style="width: 250px; height: 100vh; background-color: #1E40AF; padding: 20px;">
            <h4 class="text-center">Menu</h4>
            <ul class="list-unstyled">
                <li><a href="#" class="text-white">Dashboard</a></li>
                <li><a href="#" class="text-white">Settings</a></li>
                <li><a href="#" class="text-white">Logout</a></li>
            </ul>
        </div>
        <div class="login-dark flex-grow-1 d-flex align-items-center justify-content-center" style="background: #F4F6F9; height: 100vh;">
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
                <div class="form-group"><button class="btn btn-primary btn-block" style="background-color:#1E40AF">Log In</button></div>
                <a class="ForgotPassword" href="{{route ('forgot.password')}}" style="float: right">Forgot Password?</a>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        .login-dark form {
          max-width: 320px;
          width: 90%;
          background-color: white;
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
    </style>
</body>
</html>
