<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <script src="{{ asset('js/script.js') }}" defer></script>
    <style>
        .login-dark {
            height: 100vh;
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
</head>
<body>
    <div class="login-dark">
        @if($step == 1)
        <form id="EmailForm" method="POST" action="{{ route('report.processStep1') }}">
            @csrf
            <div class="illustration"><i class="icon ion-ios-email"></i></div>
            @if ($errors->any())
            <div style="color: red; padding: 10px; border-radius: 5px;">
                    @foreach ($errors->all() as $error)
                        <p><i>{{" * $error "}}</i></p>
                    @endforeach

            </div>
        @endif
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Send To Email" required></div>
            <div class="form-group"><button class="btn btn-primary btn-block">Send Email</button></div>
        </form>
        @endif

        @if($step == 2)
        <input type="hidden" name="email">
        <form id="ReportForm" method="POST" action="{{ route('report.processStep2') }}">
            @csrf
            <div class="illustration"><i class="ion-clipboard"></i></div>
            @if ($errors->any())
                <div style="color: red; padding: 10px; border-radius: 5px;">
                    @foreach ($errors->all() as $error)
                        <p><i>{{" * $error "}}</i></p>
                    @endforeach
                </div>
            @endif
            <div class="form-group"><input class="form-control" type="text" name="id_mesin" placeholder="Machine ID" required></div>
            <div class="form-group"><input class="form-control" type="date" name="start_date" required></div>
            <div class="form-group"><input class="form-control" type="date" name="end_date" required></div>
            <div class="form-group"><button class="btn btn-primary btn-block">Submit</button></div>
        </form>
        @endif
    </div>
</body>
</html>
