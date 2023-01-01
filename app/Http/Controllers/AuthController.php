<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        Log::info("request is:", [$request]);
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'min:6'],

        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user_id = Auth::id();

            Log::info("user id is:", [$user_id]);
            $request->session()->regenerate();
            $id = Auth::id();
            Log::info(" id is:", [$id]);
            return  redirect()->intended('home');
        }
        return redirect('login')->withError('Invalid credentials');
    }
    public function register_view()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'min:6'],

        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            //encrypt the password
            'password' => Hash::make($request->password),


        ]);

        // if auth is valid
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('home');
        }
        return redirect('register')->withError('Error');
    }
    public function home()
    {

        return view('home');
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }
}
