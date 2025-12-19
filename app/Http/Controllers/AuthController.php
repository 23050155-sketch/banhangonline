<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
            'status' => 1, // active
        ]);

        // 👉 QUAY VỀ LOGIN
        return redirect()
            ->route('login')
            ->with('success', 'Đăng ký thành công, đăng nhập liền nha 😉');
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

        // admin thì về admin dashboard (hoặc intended trong admin)
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        // customer: quay về trang chủ
        return redirect()->intended('/trangchu')->with('success', 'Đăng nhập thành công!');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Đã đăng xuất!');
    }

    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Đã gửi link đặt lại mật khẩu (check email nha).')
            : back()->with('error', 'Email này chưa tồn tại trong hệ thống.');
    }

    public function showReset(string $token)
    {
        $email = request('email');

        if (!$email) {
            return redirect()->route('password.request')
                ->with('error', 'Link đặt lại mật khẩu thiếu email. Vui lòng gửi lại yêu cầu quên mật khẩu.');
        }

        return view('auth.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->password = $request->password; // User model casts 'password' => 'hashed' :contentReference[oaicite:6]{index=6}
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Đổi mật khẩu xong rồi, đăng nhập lại nha 😌')
            : back()->with('error', 'Token không hợp lệ hoặc đã hết hạn.');
    }
}
