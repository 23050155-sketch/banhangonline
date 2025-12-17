<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:1',
            'min_order_total' => 'nullable|numeric|min:0',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'status' => 'boolean',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_total' => $request->min_order_total ?? 0,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'status' => $request->boolean('status'),
        ]);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Tạo coupon thành công!');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:1',
            'min_order_total' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_total' => $request->min_order_total ?? 0,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'status' => $request->boolean('status'),
        ]);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Cập nhật coupon thành công!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Đã xóa coupon!');
    }

    public function toggle(Coupon $coupon)
    {
        $coupon->update([
            'status' => !$coupon->status
        ]);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Đã đổi trạng thái coupon!');
    }
}
