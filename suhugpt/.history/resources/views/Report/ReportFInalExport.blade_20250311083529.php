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
            <button type="submit" class="btn btn-primary w-100">Verifikasi</button>
        </form>
        {{-- @endif --}}

        {{-- @if($step == 2) --}}
        <form id="otpFormReset">
            @csrf
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru:</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password:</label>
                <input type="password" name="new_password_confirmation" id="confirm_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="otp" class="form-label">OTP</label>
                <input type="text" name="otp" id="otp" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Ganti Password</button>
        </form>
        {{-- @endif --}}
    </div>
</body>
</html>
