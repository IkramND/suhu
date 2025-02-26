{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Change Password</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body>
    <div class="changePass-dark" style="height: 800px;">
        <form onsubmit="return false;">
            <h2 class="sr-only">Change Password Form</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group">
                <input id="username" class="form-control" type="text" name="name" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input id="otp" class="form-control" type="text" name="otp" placeholder="OTP" required style="display: none;">
            </div>
            <div class="form-group">
                <input id="password" class="form-control" type="password" name="newPassword" placeholder="New Password" required style="display: none;">
            </div>
            <div class="form-group">
                <button type="button" onclick="sendOTP()" class="btn btn-primary btn-block">Send OTP</button>
            </div>
            <div class="form-group">
                <button type="button" onclick="doChangePass()" class="btn btn-primary btn-block" style="display: none;">Submit</button>
            </div>
        </form>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>

async function sendOTP() {
    let username = document.getElementById("username").value;
    console.log(username);


    if (!username) {
        alert("Please enter your username.");
        return;
    }

    try {
        let response = await fetch("{{ route('sendEmail') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ name: username })
        });

        let result = await response.json();

        console.log(result)

        if (result) {

            sendEmail(result)
            // Show OTP & password input
            document.getElementById("otp").style.display = "block";
            document.getElementById("password").style.display = "block";
            document.querySelector("button[onclick='sendOTP()']").style.display = "none";
            document.querySelector("button[onclick='doChangePass()']").style.display = "block";
        } else {
            alert("Error: " + result.message);
        }
    } catch (error) {
        console.error("Error sending OTP:", error);
    }
}

function sendEmail(email) {
    fetch("/sendOtp", { // Langsung pakai "/sendOtp" tanpa blade route()
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ email: email }) // Kirim email dengan benar
    })
    .then(response => {
        // Periksa apakah response berupa JSON
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text); });
        }
        return response.json();
    })
    .then(result => {
        if (result.success) {
            alert("OTP sent to: " + result.email);
            // document.getElementById("otp").style.display = "block";
            // document.getElementById("password").style.display = "block";
            // document.querySelector("button[onclick='sendOTP()']").style.display = "none";
            // document.querySelector("button[onclick='doChangePass()']").style.display = "block";
        } else {
            alert("Error: " + result.message);
        }
    })
    .catch(error => console.error("Error sending OTP:", error));
}




        async function doChangePass() {
            let username = document.getElementById("username").value;
            let otp = document.getElementById("otp").value;
            let newPassword = document.getElementById("password").value;

            if (!otp || !newPassword) {
                alert("Please enter OTP and new password.");
                return;
            }

            try {
                let response = await fetch('/verifyChangePass', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: username,
                        otp: otp,
                        newPassword: newPassword
                    })
                });

                let result = await response.json();

                if (result.success) {
                    alert("Password successfully changed! Please login.");
                    window.location.href = "/login";
                } else {
                    alert("Error: " + result.message);
                }
            } catch (error) {
                console.error("Error changing password:", error);
            }
        }
    </script>

    <style>
        .changePass-dark {
            height: 1000px;
            background-size: cover;
            position: relative;
        }

        .changePass-dark form {
            max-width: 320px;
            width: 90%;
            background-color: #1e2833;
            padding: 40px;
            border-radius: 4px;
            transform: translate(-50%, -50%);
            position: absolute;
            top: 40%;
            left: 50%;
            color: #fff;
            box-shadow: 3px 3px 4px rgba(0,0,0,0.2);
        }

        .changePass-dark .illustration {
            text-align: center;
            padding: 15px 0 20px;
            font-size: 100px;
            color: #2980ef;
        }

        .changePass-dark form .form-control {
            background: none;
            border: none;
            border-bottom: 1px solid #434a52;
            border-radius: 0;
            box-shadow: none;
            outline: none;
            color: inherit;
        }

        .changePass-dark form .btn-primary {
            background: #214a80;
            border: none;
            border-radius: 4px;
            padding: 11px;
            box-shadow: none;
            margin-top: 26px;
            text-shadow: none;
            outline: none;
        }

        .changePass-dark form .btn-primary:hover,
        .changePass-dark form .btn-primary:active {
            background: #214a80;
            outline: none;
        }

        .changePass-dark form .btn-primary:active {
            transform: translateY(1px);
        }

        body {
            overflow: hidden;
        }
    </style>
</body>
</html> --}}
