<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <form id="otpForm">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Username :</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email"  class="form-label">Email :</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Verifikasi</button>
        </form>
        @endif

        @if($step == 2)
        <!-- Step 2: Form Reset Password -->
        <form id="otpFormReset">
            @csrf
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru:</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required autocomplete="new-password">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password:</label>
                <input type="password" name="new_password_confirmation" id="confirm_password" class="form-control" required autocomplete="new-password">
            </div>
            <div class="mb-3">
                <label for="otp" class="form-label">OTP</label>
                <input type="text" name="otp" id="otp" class="form-control" required autocomplete="one-time-code">
            </div>
            <button type="submit" class="btn btn-success w-100">Ganti Password</button>
        </form>
        @endif
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        async function validatePassword(event) {
            let password = document.getElementById("new_password").value;
            let confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                alert("Password tidak sama");
                event.preventDefault();
                return false;
            }
            return true;
        }

        async function myEncrypt(val) {
            const key = "mysecretkey12345";
            try {
                return await encrypt(val, key);
            } catch (error) {
                console.error("Encryption failed:", error);
                return null;
            }
        }

        async function myDecrypt(val) {
            const key = "mysecretkey12345";
            try {
                return await decrypt(val, key);
            } catch (error) {
                console.error("Decryption failed:", error);
                return null;
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            console.log("JavaScript Loaded!");

            const form = document.getElementById("otpForm");
            const formReset = document.getElementById("otpFormReset");

            if (form) {
                form.addEventListener("submit", async function (event) {
                    event.preventDefault();

                    const formData = new FormData(form);
                    const csrfTokenElement = document.querySelector('input[name="_token"]');

                    if (!csrfTokenElement) {
                        alert("CSRF token tidak ditemukan.");
                        return;
                    }

                    const csrfToken = csrfTokenElement.value;

                    fetch("{{ route('validate.user') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(async data => {
                        if (data.success) {
                            localStorage.setItem("otpCode", await myEncrypt(data.otp));
                            localStorage.setItem("name", await myEncrypt(data.name));
                            localStorage.setItem("email", await myEncrypt(data.email));

                            window.location.href = '/reset-password';
                        } else {
                            alert("User not found!");
                        }
                    })
                    .catch(error => alert("Invalid Login"));
                });
            }

            if (formReset) {
                formReset.addEventListener("submit", async function (event) {
                    event.preventDefault();

                    const newPassword = document.getElementById("new_password").value;
                    const confirmPassword = document.getElementById("confirm_password").value;
                    const otp = document.getElementById("otp").value;

                    const savedOtp = await myDecrypt(localStorage.getItem("otpCode"));
                    const name = await myDecrypt(localStorage.getItem("name"));
                    const email = await myDecrypt(localStorage.getItem("email"));

                    if (otp !== savedOtp) {
                        alert("OTP Tidak Cocok!");
                        return;
                    }

                    const formData = new FormData();
                    formData.append("new_password", newPassword);
                    formData.append("name", name);
                    formData.append("email", email);
                    formData.append("new_password_confirmation", confirmPassword);

                    fetch("{{ route('reset.password.func') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '/login';
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>
