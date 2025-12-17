<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($data)) {
            return back()->with('error', 'Sai email hoặc mật khẩu!');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ((int)$user->status === 0) {
            Auth::logout();
            return back()->with('error', 'Tài khoản đã bị khóa!');
        }

        // admin thì đá vào admin users hoặc orders tuỳ bạn
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index');
        }

        return redirect('/')->with('success', 'Đăng nhập thành công!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Đã đăng xuất!');
    }
}
