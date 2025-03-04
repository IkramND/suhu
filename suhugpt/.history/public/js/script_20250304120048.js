async function sendOTP() {
    let username = document.getElementById("username").value;

    if (!username) {
        alert("Please enter your username.");
        return;
    }

    try {
        let response = await fetch('/sendEmail', {
            method: 'POST',
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
    // let email = email; // Removed redundant declaration
    if (!email) {
        alert("Please enter an email!");
        return;
    }

    fetch("/sendEmail", {
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

async function encrypt(text, key) {
    const encoder = new TextEncoder();
    const encodedText = encoder.encode(text);
<<<<<<< HEAD

    // Generate IV (Initialization Vector)
    // Generate IV (Initialization Vector)
    const iv = crypto.getRandomValues(new Uint8Array(12));

=======

    // Generate IV (Initialization Vector)
    const iv = crypto.getRandomValues(new Uint8Array(12));

>>>>>>> f5236cc9daae3fae1d66776329b573c9ff75f4af
    // Import Key
    const cryptoKey = await crypto.subtle.importKey(
      "raw",
      encoder.encode(key),
      { name: "AES-GCM" },
      false,
      ["encrypt"]
    );
<<<<<<< HEAD

=======

>>>>>>> f5236cc9daae3fae1d66776329b573c9ff75f4af
    // Encrypt
    const encryptedData = await crypto.subtle.encrypt(
      { name: "AES-GCM", iv },
      cryptoKey,
      encodedText
    );
<<<<<<< HEAD

=======

>>>>>>> f5236cc9daae3fae1d66776329b573c9ff75f4af
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
<<<<<<< HEAD

    // Decrypt
    const iv = new Uint8Array(encrypted.iv);
    const encryptedData = new Uint8Array(encrypted.data);

=======

    const iv = new Uint8Array(encrypted.iv);
    const encryptedData = new Uint8Array(encrypted.data);

>>>>>>> f5236cc9daae3fae1d66776329b573c9ff75f4af
    // Decrypt
    const decryptedBuffer = await crypto.subtle.decrypt(
      { name: "AES-GCM", iv },
      cryptoKey,
      encryptedData
    );
<<<<<<< HEAD

=======

>>>>>>> f5236cc9daae3fae1d66776329b573c9ff75f4af
    return new TextDecoder().decode(decryptedBuffer); // Return decrypted text
  }
