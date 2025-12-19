<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function updateInfo(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'phone' => ['nullable','string','max:20'],
            'address' => ['nullable','string','max:255'],
        ]);

        $user->update($data);

        return back()->with('success', 'Cập nhật thông tin cá nhân thành công.');
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required','string','min:6','confirmed'], 
            // confirmed => cần field new_password_confirmation
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->with('error', 'Mật khẩu cũ không đúng.');
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công.');
    }
}
