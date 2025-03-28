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
use Illuminate\Contracts\Mail\Mailer;

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

    return redirect('/admin')->with('success', 'Registrasi berhasil! Silakan login.');
}

// Login
public function login(Request $request)
{
    $credentials = $request->only('name', 'password');

    if (Auth::attempt($credentials)) {
        session()->regenerate(); // Pastikan session diperbarui setelah login

        // Jika berhasil login, redirect ke dashboard
        return redirect()->route('card.index');
    }

    // Jika gagal login, kembalikan ke halaman login dengan pesan error
    return back()->withErrors(['name' => ' * Wrong Username or Password']);
}



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

    public function showForgotPasswordForm2()
    {
        return view('auth.forgot-password',['step' => 2]);
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

        if ($user)
        {
            $otp = rand(1000000,9999999);
            $userEmail = $request->email;
            Mail::raw("Your Otp Code : $otp", function ($message) use ($userEmail) {
                $message->to($userEmail)->subject('Testing Email');
            });

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'email' => $request->email,
                'name' => $request->name,
                'otp' => $otp
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


            return response()->json([
                'success' => true,
                'message' => 'Change Password Success!'
            ]);

        }if(!$user){

        return back()->with('error', 'Terjadi kesalahan, coba lagi.');
    }
    }


public function sendEmail (Request $request)
{

















// Logout
public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'Logout berhasil.');


}
}
