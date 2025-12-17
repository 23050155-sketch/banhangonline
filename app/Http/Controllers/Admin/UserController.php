<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $users = User::query()
            ->when($q, fn($qr) => $qr->where('name','like',"%$q%")
                                  ->orWhere('email','like',"%$q%"))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users','q'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => ['required', Rule::in(['admin','customer'])],
            'status' => 'required|integer|in:0,1',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
        ]);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Tạo user thành công!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role' => ['required', Rule::in(['admin','customer'])],
            'status' => 'required|integer|in:0,1',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
        ]);

        // nếu không nhập password thì giữ nguyên
        if (empty($data['password'])) {
            unset($data['password']);
        }

        // chặn tự khóa chính mình (optional nhưng nên có)
        if ($user->id === auth()->id() && (int)$data['status'] === 0) {
            return back()->with('error', 'Không được tự khóa chính mình 😭');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật user thành công!');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Không được tự khóa chính mình 😭');
        }

        $user->update(['status' => $user->status ? 0 : 1]);

        return back()->with('success', 'Đã đổi trạng thái user!');
    }
}
