<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('js/script.js') }}" defer></script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="max-width: 400px;">
        <h4 class="text-center">Lupa Password</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- @if($step == 1) --}}
        <form id="otpForm">
            @csrf
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Send To Email" required></div>
            <div class="form-group"><button class="btn btn-primary btn-block" style="background-color:blue">Log In</button>
            </div>
        </form>
        {{-- @endif --}}

        {{-- @if($step == 2) --}}
        <form id="otpFormReset">
            @csrf
            <div class="login-dark" style="height: 100vh;">

                <form action="{{ route('generate.pdf') }}" method="POST">

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
                    {{-- <div class="form-group"><input class="form-control" type="text" name="ip_address" placeholder="IP Address" required></div>
                    <div class="form-group"><input class="form-control" type="text" name="lokasi" placeholder="Location" required></div> --}}
                    <div class="form-group">
                        <input class="form-control" type="date" name="start_date" required>
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="date" name="end_date" required>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-block" style="background-color:blue">Submit</button>
                    </div>
                </form>
            </div>
        </form>
        {{-- @endif --}}
    </div>
</body>
</html>
