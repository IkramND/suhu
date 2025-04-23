// document.addEventListener("DOMContentLoaded", function () {
//     console.log("JavaScript Loaded!");

//     const form = document.getElementById("otpForm");
//     const formReset = document.getElementById("otpFormReset");

//     if (form) {
//         console.log("Form OTP ditemukan");

//         form.addEventListener("submit", async function (event) {
//             event.preventDefault();
//             console.log("Form OTP Submitted");

//             const formData = new FormData(form);

//             try {
//                 const response = await fetch("/validate-user", {
//                     method: "POST",
//                     headers: {
//                         "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
//                     },
//                     body: formData
//                 });

//                 const data = await response.json();
//                 console.log("Response dari backend:", data);

//                 if (data.success) {
//                     const encryptedOtp = await encrypt(data.otp);
//                     const encryptedName = await encrypt(data.name);
//                     const encryptedEmail = await encrypt(data.email);

//                     localStorage.setItem("otpCode", encryptedOtp);
//                     localStorage.setItem("name", encryptedName);
//                     localStorage.setItem("email", encryptedEmail);

//                     window.location.href = '/reset-password';
//                 } else {
//                     alert("User not found!");
//                 }
//             } catch (error) {
//                 alert("Terjadi kesalahan saat memproses permintaan.");
//                 console.error(error);
//             }
//         });
//     }

//     if (formReset) {
//         console.log("Form Reset Password ditemukan");

//         formReset.addEventListener("submit", async function (event) {
//             event.preventDefault();
//             console.log("Form Reset Password Submitted");

//             const newPassword = document.getElementById("new_password").value;
//             const confirmPassword = document.getElementById("confirm_password").value;
//             const otp = document.getElementById("otp").value;

//             // Ambil data dari localStorage
//             const savedOtpEnc = localStorage.getItem("otpCode");
//             const savedNameEnc = localStorage.getItem("name");
//             const savedEmailEnc = localStorage.getItem("email");

//             if (!savedOtpEnc || !savedNameEnc || !savedEmailEnc) {
//                 alert("Data tidak ditemukan di penyimpanan lokal!");
//                 return;
//             }

//             const savedOtp = await decrypt(savedOtpEnc);
//             const name = await decrypt(savedNameEnc);
//             const email = await decrypt(savedEmailEnc);

//             console.log("Decrypted OTP:", savedOtp);

//             if (otp !== savedOtp) {
//                 alert("OTP code does not match!");
//                 return;
//             }

//             const formData = new FormData();
//             formData.append("new_password", newPassword);
//             formData.append("name", name);
//             formData.append("email", email);
//             formData.append("new_password_confirmation", confirmPassword);

//             try {
//                 const response = await fetch("/reset-password-func", {
//                     method: "POST",
//                     headers: {
//                         "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
//                     },
//                     body: formData
//                 });

//                 const data = await response.json();
//                 if (data.success) {
//                     localStorage.clear(); // Hapus data setelah berhasil
//                     window.location.href = '/login';
//                 } else {
//                     alert("Gagal mengubah password!");
//                 }
//             } catch (error) {
//                 alert("An error occurred while sending the request.");
//                 console.error(error);
//             }
//         });
//     }
// });

// /**
//  * Fungsi untuk mengenkripsi teks dengan AES-GCM dan menyimpan dalam Base64
//  */
// async function encrypt(text) {
//     const encoder = new TextEncoder();
//     const data = encoder.encode(text);
//     const keyMaterial = await window.crypto.subtle.importKey(
//         "raw",
//         encoder.encode("mysecretkey12345"),
//         { name: "AES-GCM" },
//         false,
//         ["encrypt"]
//     );
//     const iv = window.crypto.getRandomValues(new Uint8Array(12)); // Initialization vector
//     const encrypted = await window.crypto.subtle.encrypt(
//         { name: "AES-GCM", iv: iv },
//         keyMaterial,
//         data
//     );

//     let buffer = new Uint8Array([...iv, ...new Uint8Array(encrypted)]);
//     return btoa(String.fromCharCode(...buffer));
// }

// /**
//  * Fungsi untuk mendekripsi teks terenkripsi dengan AES-GCM
//  */
// async function decrypt(encryptedText) {
//     try {
//         const binaryString = atob(encryptedText);
//         const buffer = new Uint8Array([...binaryString].map(c => c.charCodeAt(0)));

//         if (buffer.length < 13) {
//             throw new Error("Data terlalu kecil untuk didekripsi");
//         }

//         const iv = buffer.slice(0, 12);
//         const data = buffer.slice(12);

//         const encoder = new TextEncoder();
//         const keyMaterial = await window.crypto.subtle.importKey(
//             "raw",
//             encoder.encode("mysecretkey12345"),
//             { name: "AES-GCM" },
//             false,
//             ["decrypt"]
//         );

//         const decrypted = await window.crypto.subtle.decrypt(
//             { name: "AES-GCM", iv: iv },
//             keyMaterial,
//             data
//         );

//         return new TextDecoder().decode(decrypted);
//     } catch (error) {
//         console.error("Decryption failed:", error);
//         return null;
//     }
// }


document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("otpForm");
    const formReset = document.getElementById("otpFormReset");

    // Step 1: Validasi user dan kirim OTP
    if (form) {
        form.addEventListener("submit", async function (event) {
            event.preventDefault();

            const formData = new FormData(form);

            try {
                const response = await fetch("/validate-user", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // Simpan email di localStorage untuk verifikasi tahap selanjutnya
                    localStorage.setItem("reset_email", formData.get("email"));
                    window.location.href = '/reset-password';
                } else {
                    alert("User tidak ditemukan!");
                }
            } catch (error) {
                alert("Terjadi kesalahan saat mengirim permintaan.");
                console.error(error);
            }
        });
    }

    // Step 2: Submit Reset Password + OTP
    if (formReset) {
        formReset.addEventListener("submit", async function (event) {
            event.preventDefault();

            const newPassword = document.getElementById("new_password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const otp = document.getElementById("otp").value;
            const email = localStorage.getItem("reset_email");

            if (!email) {
                alert("Data email tidak tersedia, silakan ulangi proses.");
                return;
            }

            if (newPassword !== confirmPassword) {
                alert("Password dan konfirmasi password tidak cocok!");
                return;
            }

            const formData = new FormData();
            formData.append("new_password", newPassword);
            formData.append("new_password_confirmation", confirmPassword);
            formData.append("otp", otp);
            formData.append("email", email);

            try {
                const response = await fetch("/reset-password-func", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    localStorage.clear();
                    alert("Password berhasil diubah!");
                    window.location.href = '/login';
                } else {
                    alert("OTP salah atau kadaluarsa!");
                }
            } catch (error) {
                alert("Terjadi kesalahan saat mengirim data.");
                console.error(error);
            }
        });
    }
});


