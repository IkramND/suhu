<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use App\Models\User;
// use Illuminate\Support\Facades\Mail;

// class OTPController extends Controller
// {
//     public function validateUser(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|email',  // Validasi email
//         ]);

//         $user = User::where('email', $request->email)->first();

//         if (!$user) {
//             return response()->json(['success' => false, 'message' => 'User tidak ditemukan']);
//         }

//         $otp = rand(100000, 999999);

//         session([
//             'otp' => $otp,
//             'otp_email' => $user->email,
//             'otp_name' => $user->name,
//             'otp_expired_at' => now()->addMinutes(5),
//         ]);

//         // Send OTP via email (dummy atau Mail::send)
//         // Mail::to($user->email)->send(new OTPSentMail($otp));
//         logger("OTP untuk {$user->email}: $otp");

//         return response()->json([
//             'success' => true,
//             'message' => 'OTP berhasil dikirim'
//         ]);
//     }

//     public function resetPassword(Request $request)
//     {
//         $request->validate([
//             'new_password' => 'required|string|min:8|confirmed', // Validasi password
//             'otp' => 'required|numeric',
//             'email' => 'required|email'
//         ]);

//         if (
//             session('otp') !== $request->otp ||
//             session('otp_email') !== $request->email ||
//             now()->greaterThan(session('otp_expired_at'))
//         ) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'OTP tidak valid atau kadaluarsa'
//             ]);
//         }

//         $user = User::where('email', $request->email)->first();

//         if ($user) {
//             $user->password = Hash::make($request->new_password);
//             $user->save();

//             session()->forget(['otp', 'otp_email', 'otp_name', 'otp_expired_at']);

//             return response()->json(['success' => true, 'message' => 'Password berhasil diubah']);
//         }

//         return response()->json(['success' => false, 'message' => 'User tidak ditemukan']);
//     }
// }
