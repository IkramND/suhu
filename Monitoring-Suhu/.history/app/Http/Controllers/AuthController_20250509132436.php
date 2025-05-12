<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Alat;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use function Laravel\Prompts\select;

class AuthController extends Controller
{

// Register

public function register(){
$roles = Role::all();
return view('auth.register', compact('roles'));
}

public function registers(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:users,name',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'role_id' => 'required'
    ]);

    $role = Role::find($request->role_id);

    if (!$role){
        return back()->withErrors(['role_id' => 'Role not found']);
    }

    if ($role->role === 'Operator' || $role->role === 'operator') {
        $alats = Alat::all()->sortBy('id_mesin');

        session([
            'user' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id
            ]
        ]);

        return view('auth.acess', compact('alats'));
    }

    if ($role->role === 'Admin' || $role->role === 'admin'){

        $otp = rand(100000,999999);
        $adminEmail = Notification::pluck('email')->toArray();

        session([
            'user' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'otp' => $otp
            ]
            ]);

            $botToken = config('services.telegram.bot_token');
                $chatId = config('services.telegram.chat_id');


                 // Kirim pesan ke Telegram
                // $response
                Http::timeout(5)->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                        'chat_id' => $chatId,
                        'text' => $otp,
                        'parse_mode' => 'Markdown'
                    ]);


            Mail::raw("Your Otp Code : $otp", function ($message) use ($adminEmail) {
                $message->to($adminEmail)->subject('OTP Code For Register');
            });
        return view('auth.registervalidation');


}
}

public function acess(){
    return view('auth.acess');
}

public function acesssubmit(Request $request){
$request->validate([
    'acess' => 'required'
]);

$user = session('user');
if (!$user){
    return redirect()->route('register')->withErrors(['session' => 'Session Expired']);
}

 $otp = rand(100000,999999);
 $user['otp'] = $otp;
 $user['acess'] = $request->acess;
 session(['user' => $user]);


 $adminEmail = Notification::pluck('email')->toArray();

 Mail::raw("Your Otp Code : $otp", function ($message) use ($adminEmail) {
    $message->to($adminEmail)->subject('OTP Code For Register');
});


return view('auth.registervalidation');
}

public function otpvalidation(Request $request){
    $request->validate([
        'otp' => 'required|digits:6'
    ]);
    $users = session('user');
    $role = Role::find($users['role_id']);

    if($request->otp == $users['otp']){
        if($role->role === 'Admin' || $role->role === 'admin' ){
        User::create([
        'name' => $users['name'],
        'email' => $users['email'],
        'password' => $users['password'],
        'role_id' => $users['role_id'],
        'acess' => '["ALL"]'
    ]);
    session()->forget('user');
    if(Auth::check()){
        $loginrole = Role::find(Auth::user()->role_id);
        if($loginrole->role == 'Admin' || $loginrole == 'admin'){
            return redirect('/admin');
        }

        if($loginrole->role == 'Operator' || $loginrole == 'operator'){
            return redirect('/');
        }
    return redirect('/login')->with('success', 'Register Success');
    }
}

    if($role->role === 'Operator' || $role->role === 'operator'){
        user::create([
            'name' => $users['name'],
            'email' => $users['email'],
            'password' => $users['password'],
            'role_id' => $users['role_id'],
            'acess' => json_encode($users['acess'])
        ]);
        session()->forget('user');
        if(Auth::check()){
            $loginrole = Role::find(Auth::user()->role_id);
            if($loginrole->role == 'Admin' || $loginrole == 'admin'){
                return redirect('/admin');
            }

            if($loginrole->role == 'Operator' || $loginrole == 'operator'){
                return redirect('/');
            }
        return redirect('/login')->with('success',' Register Success' );
    }
    return redirect('/login')->with('success',' Register Success' );

}
}

if ($request->otp != $users['otp']){
return back()->withErrors(['otp' => 'OTP not match or expired']);
}
}

// Login
public function login(Request $request)
{
    $credentials = $request->only('name', 'password');

    if (Auth::attempt($credentials)) {
        session()->regenerate();

        $user = Auth::user();

        if($user->role->role === 'Admin' || $user->role->role === 'admin'){
            return redirect()->route('card.index');
        }

        if($user->role->role === 'Operator' || $user->role->role === 'operator'){
            return redirect()->route('dashboard');
        }
    }




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
    return redirect('/login')->with('success', 'Password berhasil diperbarui. Silakan login kembali.');
}



// ForgotPass


public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function showForgotPasswordForm2()
    {
        return view('auth.forgot-password2');
    }
    public function showForgotPasswordForm3()
    {
        return view('auth.forgot-password3');
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



        if ($user)
        {
            $otp = rand(100000,999999);
            Session::put('otp', $otp);
            Session::put('otp_expires_at', now()->addMinutes(5));
            Session::put('user_id', $user->id);
            $userEmail = $request->email;
            Mail::raw("Your Otp Code : $otp", function ($message) use ($userEmail) {
                $message->to($userEmail)->subject('OTP code');
            });

            return redirect()->route('forgot.password2')->with('success', 'OTP has been sent to your email');


        } else {
            return back()->withErrors(['name' => 'Username and Email not match!']);
        }
    }

    public function validateUser2(Request $request){

        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $otp = Session::get('otp');
        $otpExpires = Session::get('otp_expires_at');

        if(!$otp || !$otpExpires){
            return redirect()->route('forgot.password2')->withErrors([
                'otp' => 'OTP session not found. Please request again.',
            ]);
        }

        if(now()->greaterThan(Session::get('otp_expires_at'))){
            Session::forget(['otp', 'otp_expires_at', 'user_id']);
            return redirect()->route('forgot.password2')->withErrors(['otp' => 'OTP EXPIRED']);
        }


        if($request->otp != Session::get('otp') ){
            return back()->withErrors(['otp' => 'OTP is incorrect']);
        }

        return redirect()->route('forgot.password3');
    }

    public function validateUser3(){
            return view('auth.forgot-password3');

    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::find(Session::get('user_id'));
        $user->password = bcrypt($request->password);
        $user->save();


        if($user){
            $user->password = Hash::make($request->new_password);
            $user->save();

            Session::forget('otp');
            Session::forget('user_id');
            Session::forget('otp_expired_at');


            return redirect()->route('login')->with('success', 'Password reset success');

        }if(!$user){

        return back()->with('error', 'Terjadi kesalahan, coba lagi.');
    }
    }

// Logout
public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'Logout berhasil.');


}
}
