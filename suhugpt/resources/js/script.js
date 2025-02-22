async function sendOTP() {
    let username = document.getElementById("username").value;

    if (!username) {
        alert("Please enter your username.");
        return;
    }

    try {
        let response = await fetch('/sendEmail', {
            method: 'GET',
            body: JSON.stringify({ name: username })
        });

        let result = await response.json();

        if (result.success) {

            console.log(result)
            console.log();

            // sendEmail(result.data.email);
            alert("OTP sent to: " + result.email);

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
    let email = email;
    if (!email) {
        alert("Please enter an email!");
        return;
    }

    fetch("{{ route('send.otp') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            document.getElementById("otp-message").innerText = "OTP sent to: " + email;
            document.getElementById("otp-message").style.display = "block";
        } else {
            alert("Failed to send OTP!");
        }
    })
    .catch(error => console.error("Error:", error));
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
