<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    {{-- <link rel="stylesheet" href="assets/css/Login-Form-Dark.css"> --}}
    <title>Document</title>
</head>
<body>
    <div class="login-dark" style="height: 800px;">
        <form action="{{ route('admin.add.notification') }}" method="POST">
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger">
                 {{ $errors->first() }}
            </div>
            @endif
            <div class="illustration"><i class="ion-email"></i></div>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email" required></div>
            <div class="form-group"><button class="btn btn-primary btn-block" style="background-color:blue">Submit</button>
            </div>
            <br>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        .login-dark {
  height: 1000px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-size: cover;
  position: relative;
  background: #1e2833;

}

.login-dark form {
  max-width: 320px;
  width: 90%;
  background-color: #252d37;
  padding: 40px;
  border-radius: 4px;
  top: 80%;
  left: 50%;
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

.login-dark form .btn-primary:hover, .login-dark form .btn-primary:active {
  background: #214a80;
  outline: none;
}

.login-dark form .ChangePasswordd,.login-dark form .ForgotPassword {
  display: block;
  text-align: center;
  font-size: 12px;
  color: #6f7a85;
  opacity: 0.9;
  text-decoration: none;
}

.login-dark form .forgot:hover, .login-dark form .forgot:active {
  opacity: 1;
  text-decoration: none;
}

.login-dark form .btn-primary:active {
  transform: translateY(1px);
}
body{
    overflow: hidden;
}
    </style>
</body>
</html>




