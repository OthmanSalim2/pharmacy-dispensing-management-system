<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('albaraka.login'); // Assuming you have a login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            flash()->success('تم تسجيل الدخول بنجاح ✅');
            return redirect()->route('home'); // Or your desired redirect
        }

        flash()->error('بيانات الدخول غير صحيحة ❌');
        return back()->onlyInput('username');
//        return back()->withErrors([
//            'username' => 'إن بيانات الاعتماد المقدمة لا تتطابق مع سجلاتنا.', // Or 'email'
//        ])->onlyInput('username'); // Or 'email'
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        flash()->info('تم تسجيل الخروج بنجاح 👋');
        return redirect()->route('login');
    }
}
