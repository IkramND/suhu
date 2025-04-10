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

            try {
                const response = await fetch("/validate-user", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                const data = await response.json();
                console.log("Response dari backend:", data);

                if (data.success) {
                    const encryptedOtp = await encrypt(data.otp);
                    const encryptedName = await encrypt(data.name);
                    const encryptedEmail = await encrypt(data.email);

                    localStorage.setItem("otpCode", encryptedOtp);
                    localStorage.setItem("name", encryptedName);
                    localStorage.setItem("email", encryptedEmail);

                    window.location.href = '/reset-password';
                } else {
                    alert("User not found!");
                }
            } catch (error) {
                alert("Terjadi kesalahan saat memproses permintaan.");
                console.error(error);
            }
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

            // Ambil data dari localStorage
            const savedOtpEnc = localStorage.getItem("otpCode");
            const savedNameEnc = localStorage.getItem("name");
            const savedEmailEnc = localStorage.getItem("email");

            if (!savedOtpEnc || !savedNameEnc || !savedEmailEnc) {
                alert("Data tidak ditemukan di penyimpanan lokal!");
                return;
            }

            const savedOtp = await decrypt(savedOtpEnc);
            const name = await decrypt(savedNameEnc);
            const email = await decrypt(savedEmailEnc);

            console.log("Decrypted OTP:", savedOtp);

            if (otp !== savedOtp) {
                alert("OTP code does not match!");
                return;
            }

            const formData = new FormData();
            formData.append("new_password", newPassword);
            formData.append("name", name);
            formData.append("email", email);
            formData.append("new_password_confirmation", confirmPassword);

            try {
                const response = await fetch("/reset-password-func", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    localStorage.clear(); // Hapus data setelah berhasil
                    window.location.href = '/login';
                } else {
                    alert("Gagal mengubah password!");
                }
            } catch (error) {
                alert("An error occurred while sending the request.");
                console.error(error);
            }
        });
    }
});

/**
 * Fungsi untuk mengenkripsi teks dengan AES-GCM dan menyimpan dalam Base64
 */
async function encrypt(text) {
    const encoder = new TextEncoder();
    const data = encoder.encode(text);
    const keyMaterial = await window.crypto.subtle.importKey(
        "raw",
        encoder.encode("mysecretkey12345"),
        { name: "AES-GCM" },
        false,
        ["encrypt"]
    );
    const iv = window.crypto.getRandomValues(new Uint8Array(12)); // Initialization vector
    const encrypted = await window.crypto.subtle.encrypt(
        { name: "AES-GCM", iv: iv },
        keyMaterial,
        data
    );

    let buffer = new Uint8Array([...iv, ...new Uint8Array(encrypted)]);
    return btoa(String.fromCharCode(...buffer));
}

/**
 * Fungsi untuk mendekripsi teks terenkripsi dengan AES-GCM
 */
async function decrypt(encryptedText) {
    try {
        const binaryString = atob(encryptedText);
        const buffer = new Uint8Array([...binaryString].map(c => c.charCodeAt(0)));

        if (buffer.length < 13) {
            throw new Error("Data terlalu kecil untuk didekripsi");
        }

        const iv = buffer.slice(0, 12);
        const data = buffer.slice(12);

        const encoder = new TextEncoder();
        const keyMaterial = await window.crypto.subtle.importKey(
            "raw",
            encoder.encode("mysecretkey12345"),
            { name: "AES-GCM" },
            false,
            ["decrypt"]
        );

        const decrypted = await window.crypto.subtle.decrypt(
            { name: "AES-GCM", iv: iv },
            keyMaterial,
            data
        );

        return new TextDecoder().decode(decrypted);
    } catch (error) {
        console.error("Decryption failed:", error);
        return null;
    }







    document.addEventListener("DOMContentLoaded", function () {
        const emailForm = document.getElementById("EmailForm");
        const reportForm = document.getElementById("ReportForm");

        // Menyimpan email ke localStorage saat user mengisi step 1
        if (emailForm) {
            emailForm.addEventListener("submit", function (e) {
                e.preventDefault(); // Mencegah form terkirim langsung

                const emailInput = emailForm.querySelector("input[name='email']").value;
                localStorage.setItem("userEmail", emailInput); // Simpan email di localStorage

                alert("Email tersimpan! Lanjutkan ke langkah berikutnya.");
                window.location.href = "URL_STEP_2"; // Ganti dengan URL step 2
            });
        }

        // Memasukkan email ke dalam form step 2 sebelum dikirim
        if (reportForm) {
            const userEmail = localStorage.getItem("userEmail");
            if (userEmail) {
                // Tambahkan input hidden untuk menyertakan email saat submit
                const emailInputHidden = document.createElement("input");
                emailInputHidden.type = "hidden";
                emailInputHidden.name = "email";
                emailInputHidden.value = userEmail;
                reportForm.appendChild(emailInputHidden);
            }

            reportForm.addEventListener("submit", function () {
                localStorage.removeItem("userEmail"); // Hapus email setelah form dikirim
            });
        }
    });

}
