<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


use Illuminate\Support\Facades\Validator;
use App\Mail\OtpMail;
use App\Models\Otp;
use Carbon\Carbon;

use function Laravel\Prompts\select;

class AuthController extends Controller
{

// Register
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
    ]);

    return redirect('/')->with('success', 'Registrasi berhasil! Silakan login.');
}

// Login
public function login(Request $request)
{
    $credentials = $request->only('name', 'password');

    if (Auth::attempt($credentials)) {
        session()->regenerate(); // Pastikan session diperbarui setelah login

        // Jika berhasil login, redirect ke dashboard
        return redirect()->route('utama');
    }

    // Jika gagal login, kembalikan ke halaman login dengan pesan error
    return back()->withErrors(['name' => 'Username atau password salah.']);
}

//changePassword

// public function changePassword()
//     {
//         return view('auth.changepassword');
//     }
//     public function update(Request $request)
//     {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'current_password' => 'required',
//             'new_password' => 'required|min:6|confirmed',
//         ]);

//         $user = Auth::users();

//         if (!Hash::check($request->current_password, $user->password)) {
//             return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
//         }

//         $user->name = $request->name;
//         $user->password = Hash::make($request->new_password);
//         // dd($user);
//         // dd('Debugging berjalan');

//         $user->update();
//         return back()->with('success', 'Nama dan password berhasil diperbarui');
//     }




public function showChangePasswordForm()
{
    return view('auth.changepasswordd');
}



public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required', 'current_password'],
        'new_password' => ['required', 'min:8', 'confirmed'],
    ]);

    // Update password langsung di database
    User::where('id', Auth::id())->update([
        'password' => Hash::make($request->new_password),
    ]);

    // Logout user setelah password diubah
    Auth::logout();

    // Redirect ke halaman utama dengan pesan sukses
    return redirect('/')->with('success', 'Password berhasil diperbarui. Silakan login kembali.');
}



// ForgotPass

public function showForgotPasswordForm()
    {
        return view('auth.forgot-password',['step' => 1]);
    }

    public function validateUser(Request $request)
    {



        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        // Cek apakah username dan email cocok di database
        $user = User::where('name', $request->name)
                    ->where('email', $request->email)
                    ->first();

                    // dd($request->method());

        if ($user){
            return view('auth.forgot-password',[
            'name' => $request->name,
            'email' => $request->email,
            'step' => 2, // Step 2 untuk menampilkan form password baru
        ]);
        } else {
            return back()->with('error', 'Username dan Email tidak cocok!');
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = user::where('name',$request->name)
                    ->where('email', $request->email)
                    ->first();


        if($user){
            $user->password = Hash::make($request->new_password);
            $user->save();


            return redirect()->route('login')->with('success', 'Password berhasil diperbarui! Silakan login.');
        }if(!$user){

        return back()->with('error', 'Terjadi kesalahan, coba lagi.');
    }
    }
    // public function processForgotPassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|exists:users,email',
    //         'name' => 'required|exists:users,name'
    //     ]);

    //     // Cek apakah email dan username cocok
    //     $user = User::where('email', $request->email)
    //                 ->where('name', $request->name)
    //                 ->first();

    //                 if ($user) {
    //                     // Hash dan update password baru
    //                     $user->password = Hash::make($request->new_password);
    //                     $user->save();

    //                     return back()->with('success', 'Password berhasil diperbarui! Silakan login dengan password baru.');
    //                 } else {
    //                     return back()->with('error', 'Email dan Username tidak cocok!');
    //                 }
    // }

public function sendEmail (Request $request)
{

//     $user = User::where('name', $request->name)->first();

//     if (!$user) {
//         return back()->with('error', 'User not found.');
//     }

//     $email = $user->email;

//     return response()->json(['email' => $email]);
// }


// public function sendOTP(Request $request)
// {
//     Log::info('TESTTTTTTT');
//     // Validasi email
//     $validator = Validator::make($request->all(), [
//         'email' => 'required|email'
//     ]);

//     if ($validator->fails()) {
//         Log::warning("OTP request failed: " . json_encode($validator->errors()));
//         return response()->json([
//             'success' => false,
//             'message' => $validator->errors()->first()
//         ], 422);
//     }

//     // try {
//         // Generate OTP 6 digit
        $otp = '112233';
        // $otp = rand(100000, 999999);
        $email = $request->email;

        // Simpan log OTP
        Log::info("Generated OTP: $otp for email: $email");

        // Kirim email menggunakan Laravel Mail
        Mail::raw("Your OTP code is: $otp", function ($message) use ($email) {
            $message->to($email)->subject("Your OTP Code");
        });

//         Log::info("OTP email successfully sent to: $email");

        return response()->json([
            'success' => true,
            'email' => $email,
            'otp' => $otp // Kembalikan OTP dalam response hanya untuk keperluan debug (hapus di produksi)
        ]);

//     // } catch (\Exception $e) {
//         // Log::error("Error sending OTP: " . $e->getMessage());
//         // return response()->json([
//         //     'success' => false,
//         //     'message' => 'Failed to send OTP.'
//         // ], 500);
//     // }

        return redirect('/login')->with('succes', 'Already Succes Change Password, Please go to login');
}


//change password
// public function changePass(Request $request)
// {

//     $request->validate([
//         'name' => 'required|string|max:255',
//         'otp' => 'required|string|email|max:255|unique:users',
//         'password' => 'required|string|min:8|confirmed'
//     ]);

//     $user = User::updated([
//         'name' => $request->name,
//         'password' => Hash::make($request->password)
//     ]);

//     return redirect('/login')->with('success', 'Change Password Complete! Please do login.');
// }

// public function login(Request $request)
// {
//     $request->validate([
//         'name' => 'required|string',
//         'password' => 'required'
//     ]);

//     if (Auth::attempt($request->only('name', 'password'))) {
//         return redirect('/utama');
//     }

//     return back()->withErrors(['name' => 'Username atau password salah.']);
// }













// Logout
public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'Logout berhasil.');

























}
}
