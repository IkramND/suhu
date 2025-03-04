<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text.js" src="{{asset('js/script.js')}}"></script>
    <script>
        let globalVarOTP = '';

        function validatePassword() {
            let password = document.getElementById("new_password").value;
            let confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                alert("Password tidak sama");
                event.preventDefault();
                return false;
            }
            return true;
        }

        async function encrypt(text, key) {
            const encoder = new TextEncoder();
            const encodedText = encoder.encode(text);
            const iv = crypto.getRandomValues(new Uint8Array(12));

            const cryptoKey = await crypto.subtle.importKey(
                "raw",
                encoder.encode(key),
                { name: "AES-GCM" },
                false,
                ["encrypt"]
            );

            const encryptedData = await crypto.subtle.encrypt(
                { name: "AES-GCM", iv },
                cryptoKey,
                encodedText
            );

            return {
                iv: Array.from(iv),
                data: Array.from(new Uint8Array(encryptedData))
            };
        }

        async function decrypt(encrypted, key) {
            const encoder = new TextEncoder();
            const cryptoKey = await crypto.subtle.importKey(
                "raw",
                encoder.encode(key),
                { name: "AES-GCM" },
                false,
                ["decrypt"]
            );

            const iv = new Uint8Array(encrypted.iv);
            const encryptedData = new Uint8Array(encrypted.data);

            const decryptedBuffer = await crypto.subtle.decrypt(
                { name: "AES-GCM", iv },
                cryptoKey,
                encryptedData
            );

            return new TextDecoder().decode(decryptedBuffer);
        }

        async function myEncrypt(val) {
            const key = "mysecretkey12345";
            try {
                const encryptedResult = await encrypt(val, key);
                console.log("Encrypted Data:", encryptedResult);
                return encryptedResult;
            } catch (error) {
                console.error("Encryption failed:", error);
                return null;
            }
        }

        async function myDecrypt(val) {
            const key = "mysecretkey12345";
            try {
                const decryptedResult = await decrypt(val, key);
                console.log("Decrypted Data:", decryptedResult);
                return decryptedResult;
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
                console.log("Form OTP ditemukan");

                form.addEventListener("submit", async function (event) {
                    event.preventDefault();
                    console.log("Form OTP Submitted");

                    const formData = new FormData(form);

                    fetch("{{ route('validate.user') }}".replace(/&amp;/g, "&"), {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(async data => {
                        console.log("Response dari backend:", data);

                        if (data.success) {
                            localStorage.setItem("otpCode", JSON.stringify(await myEncrypt(data.otp)));
                            localStorage.setItem("name", JSON.stringify(await myEncrypt(data.name)));
                            localStorage.setItem("email", JSON.stringify(await myEncrypt(data.email)));

                            console.log("OTP yang diterima:", data.otp);
                            window.location.href = '/reset-password';
                        } else {
                            alert("User not found!");
                        }
                    })
                    .catch(error => alert("Invalid Login"));
                });
            }

            if (formReset) {
                console.log("Form Reset Password ditemukan");

                formReset.addEventListener("submit", async function (event) {
                    event.preventDefault();
                    console.log("Form Reset Password Submitted");

                    const newPassword = document.getElementById("new_password").value;
                    const confirmPassword = document.getElementById("confirm_password").value;
                    const otp = document.getElementById("otp").value;

                    const savedOtp = await myDecrypt(JSON.parse(localStorage.getItem("otpCode")));
                    const name = await myDecrypt(JSON.parse(localStorage.getItem("name")));
                    const email = await myDecrypt(JSON.parse(localStorage.getItem("email")));

                    console.log("New Password:", newPassword);
                    console.log("Confirm Password:", confirmPassword);
                    console.log("OTP:", otp);
                    console.log("OTP OLD:", savedOtp);

                    if (otp !== savedOtp) {
                        alert("OTP Is Not Match!");
                        return;
                    }

                    const formData = new FormData();
                    formData.append("new_password", newPassword);
                    formData.append("name", name);
                    formData.append("email", email);
                    formData.append("new_password_confirmation", confirmPassword);

                    fetch("{{ route('reset.password.func') }}".replace(/&amp;/g, "&"), {
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
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="max-width: 400px;">
        <h4 class="text-center">Forgot Password</h4>

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

        @if($step == 1)
        <form id="otpForm">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Username </label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
        @endif

        @if($step == 2)
        <form id="otpFormReset">
            @csrf
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" name="new_password_confirmation" id="confirm_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="otp" class="form-label">OTP</label>
                <input type="text" name="otp" id="otp" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Ganti Password</button>
        </form>
        @endif
    </div>
</body>
</html>
