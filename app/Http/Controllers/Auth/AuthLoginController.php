<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserOtp;
use App\Mail\VerifyUserMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;

class AuthLoginController extends Controller
{
    public function loginPage()
    {
        return view('pages.auth.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ],[
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return response()->json(['success' => 'Login Successful, redirecting...']);
        } else {
            return response()->json(['error' => 'Given Credentials are Incorrct']);
        }
    }

    public function registerPage(){
        return view('pages.auth.register');
    }

    public function registerPost(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ],[
            'name.required' => 'Last Name is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Confirm your Password',
        ]
    );

        $user = User::create($credentials);
        Auth::login($user);

        event(new Registered($user));

        return response()->json(['success' => 'Registration Successful, redirecting...']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
