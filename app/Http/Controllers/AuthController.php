<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('pages.auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('username','password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }

        return back()->withErrors(['username'=>'Username atau password salah']);
    }

    public function showRegister() {
        return view('pages.auth.register');
    }
    
    public function register(Request $request) {
        $request->validate([
            'username' => 'required|unique:user,username',
            'email' => 'required|unique:user,email',
            'password' => 'required|min:6|confirmed'
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal harus 6 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak sesuai.',
        ]);
    
        $user = \App\Models\User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
    
        Auth::login($user);
    
        return redirect()->route('login');
    }
    

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
