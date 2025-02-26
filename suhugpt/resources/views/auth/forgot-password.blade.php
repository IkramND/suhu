<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validatePassword(){
            let password = document.getElementById("new_password").value;
            let confirmPassword = document.getElementById("confirm_password").value

            if(password !== confirmPassword){
                alert("Password tidak sama");
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="max-width: 400px;">
        <h4 class="text-center">Lupa Password</h4>

        <!-- Notifikasi Berhasil -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Notifikasi Error -->
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Tampilkan Error Validasi -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($step == 1)
        <!-- Step 1: Form Verifikasi Username & Email -->
        <form action="{{ route('validate.user') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Username :</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Verifikasi</button>
        </form>

        @endif

        @if($step == 2)
        <!-- Step 2: Form Reset Password -->
        <form action="{{ route('reset.password') }}" method="POST" id="resetPasswordForm" onsubmit="return validatePassword(event)">
            @csrf
            <input type="hidden" name="name" value="{{ $name }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru:</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password:</label>
                <input type="password" name="new_password_confirmation" id="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Ganti Password</button>
        </form>
        @endif
    </div>
</body>
</html>
