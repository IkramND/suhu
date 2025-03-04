<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<<<<<<< HEAD
    <script type="text/javascript" src="{{ asset('js/script.js') }}">    <script>
=======
    <script type="text/javascript" src="{{ asset('js/script.js') }}">
>>>>>>> f5236cc9daae3fae1d66776329b573c9ff75f4af

        let globalVarOTP = '';

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

        async function myEncrypt(val) {
              const text = val;
              const key = "mysecretkey12345";
<<<<<<< HEAD

=======
          
>>>>>>> f5236cc9daae3fae1d66776329b573c9ff75f4af
              try {
                  const encryptedResult = await encrypt(text, key);
                  console.log("Encrypted Data:", encryptedResult);
              } catch (error) {
                  console.error("Encryption failed:", error);
              }

              return encryptedResult;
          }

          async function myDecrypt(val) {
              const text = val;
              const key = "mysecretkey12345";
<<<<<<< HEAD

              try {
                  const dencryptedResult = await decrypt(text, key);
                  console.log("Encrypted Data:", encryptedResult);
                  console.log("Decrypted Data:", encryptedResult);
              } catch (error) {
                  console.error("Encryption failed:", error);
=======
          
              try {
                  const dencryptedResult = await decrypt(text, key);
                  console.log("Decrypted Data:", encryptedResult);
              } catch (error) {
>>>>>>> f5236cc9daae3fae1d66776329b573c9ff75f4af
                  console.error("Decrypted failed:", error);
              }

              return dencryptedResult;
<<<<<<< HEAD
=======
          }
>>>>>>> f5236cc9daae3fae1d66776329b573c9ff75f4af

        document.addEventListener("DOMContentLoaded", function () {
        console.log("JavaScript Loaded!");

        const form = document.getElementById("otpForm");
        const formReset = document.getElementById("otpFormReset");

        if (form) {
            console.log("Form OTP ditemukan");

            form.addEventListener("submit", function (event) {
                event.preventDefault();
                console.log("Form OTP Submitted");

                const formData = new FormData(form);

                fetch("{{ route('validate.user') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Response dari backend:", data);

                    if (data.success) {
                        localStorage.setItem("otpCode", myEncrypt(data.otp));
                        localStorage.setItem("name", myEncrypt(data.name));
                        localStorage.setItem("email", myEncrypt(data.email));
                        // globalVarOTP = data.otp;
                        console.log("OTP yang diterima:", globalVarOTP);
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

                formReset.addEventListener("submit", function (event) {
                event.preventDefault();
                console.log("Form Reset Password Submitted");

                const newPassword = document.getElementById("new_password").value;
                const confirmPassword = document.getElementById("confirm_password").value;
                const otp = document.getElementById("otp").value;
                const savedOtp = myDecrypt(localStorage.getItem("otpCode"));
                const name = myDecrypt(localStorage.getItem("name"));
                const email = myDecrypt(localStorage.getItem("email"));
                // localStorage.removeItem("otpCode");

                console.log("New Password:", newPassword);
                console.log("Confirm Password:", confirmPassword);
                console.log("OTP:", otp);
                console.log("OTP OLD:", savedOtp);

                if (otp != savedOtp) {
                    alert("OTP Is Not Match!");
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
                    if(data.success)
                    {
                        window.location.href = '/login';
                    }
                })
            });
        }
    });



    </script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="max-width: 400px;">
        <h4 class="text-center">Forgot Password</h4>

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
                <label for="name" class="form-label">Username </label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email"  class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
                {{-- <input type="text"  name="otp"   id="otp"    class="form-control" required style="display: none"> --}}
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>

        @endif

        @if($step == 2)
        <!-- Step 2: Form Reset Password -->
        <form id="otpFormReset">
            @csrf
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required autocomplete="new-password">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
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
</body>
</html>
