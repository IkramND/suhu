async function sendOTP() {
    let username = document.getElementById("username").value;

    if (!username) {
        alert("Please enter your username.");
        return;
    }

    try {
        let response = await fetch('/sendEmail', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ name: username })
        });

        let result = await response.json();

        if (result.success) {
            console.log(result);
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

async function sendEmail(email) {
    if (!email) {
        alert("Please enter an email!");
        return;
    }

    try {
        let response = await fetch("/sendEmail", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ email: email })
        });

        let result = await response.json();

        if (result.success) {
            document.getElementById("otp-message").innerText = "OTP sent to: " + email;
            document.getElementById("otp-message").style.display = "block";
        } else {
            alert("Failed to send OTP!");
        }
    } catch (error) {
        console.error("Error sending email:", error);
    }
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
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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

// Fungsi untuk enkripsi AES-GCM
async function encrypt(text, key) {
    const encoder = new TextEncoder();
    const encodedText = encoder.encode(text);
    const iv = crypto.getRandomValues(new Uint8Array(12)); // Inisialisasi IV

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

// Fungsi untuk dekripsi AES-GCM
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

    try {
        const decryptedBuffer = await crypto.subtle.decrypt(
            { name: "AES-GCM", iv },
            cryptoKey,
            encryptedData
        );

        return new TextDecoder().decode(decryptedBuffer);
    } catch (error) {
        console.error("Decryption failed:", error);
        return null;
    }
}
