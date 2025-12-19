<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private function getCart(): Cart
    {
        $sessionId = session()->getId();
        $userId = Auth::check() ? Auth::id() : null;

        if ($userId) {
            $cart = Cart::firstOrCreate(
                ['user_id' => $userId],
                ['session_id' => $sessionId]
            );

            if ($cart->session_id !== $sessionId) {
                $cart->update(['session_id' => $sessionId]);
            }

            return $cart;
        }

        return Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => null]
        );
    }

    private function calcDiscount(?Coupon $coupon, int $subtotal): int
    {
        if (!$coupon) return 0;

        if ($subtotal < (int) $coupon->min_order_total) return 0;

        $discount = 0;

        if ($coupon->type === 'fixed') {
            $discount = (int) $coupon->value;
        } else { // percent
            $discount = (int) floor($subtotal * ((int) $coupon->value) / 100);

            if (!is_null($coupon->max_discount)) {
                $discount = min($discount, (int) $coupon->max_discount);
            }
        }

        // không cho discount vượt subtotal
        return max(0, min($discount, $subtotal));
    }

    private function getAppliedCoupon(): ?Coupon
    {
        $code = session('applied_coupon');
        if (!$code) return null;

        return Coupon::where('code', $code)->first();
    }

    public function form()
    {
        $cart = $this->getCart()->load('items.product');

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống, không thể đặt hàng!');
        }

        $subtotal = (int) $cart->items->sum(fn ($i) => $i->price * $i->quantity);
        $shippingFee = 0;

        $coupon = $this->getAppliedCoupon();
        $discountAmount = $this->calcDiscount($coupon, $subtotal);

        $total = max(0, $subtotal + $shippingFee - $discountAmount);

        return view('checkout.form', compact('cart', 'subtotal', 'shippingFee', 'coupon', 'discountAmount', 'total'));
    }

    // ✅ ÁP MÃ
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50'
        ]);

        $code = strtoupper(trim($request->code));

        $cart = $this->getCart()->load('items.product');
        if ($cart->items->count() === 0) {
            return back()->with('error', 'Giỏ hàng trống!');
        }

        $subtotal = (int) $cart->items->sum(fn ($i) => $i->price * $i->quantity);

        $coupon = Coupon::where('code', $code)->first();
        if (!$coupon || (int) $coupon->status !== 1) {
            return back()->with('error', 'Mã giảm giá không tồn tại hoặc đã tắt!');
        }

        $now = now();
        if ($coupon->starts_at && $now->lt($coupon->starts_at)) {
            return back()->with('error', 'Mã giảm giá chưa tới thời gian áp dụng!');
        }
        if ($coupon->ends_at && $now->gt($coupon->ends_at)) {
            return back()->with('error', 'Mã giảm giá đã hết hạn!');
        }

        if (!is_null($coupon->usage_limit) && (int) $coupon->used_count >= (int) $coupon->usage_limit) {
            return back()->with('error', 'Mã giảm giá đã hết lượt sử dụng!');
        }

        if ($subtotal < (int) $coupon->min_order_total) {
            return back()->with('error', 'Đơn hàng chưa đạt giá trị tối thiểu để dùng mã.');
        }

        session()->put('applied_coupon', $coupon->code);

        return back()->with('success', 'Áp mã giảm giá thành công!');
    }

    // ✅ GỠ MÃ
    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        return back()->with('success', 'Đã gỡ mã giảm giá!');
    }

    // ✅ ĐẶT HÀNG
    public function place(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_email'   => 'nullable|email|max:255',
            'customer_address' => 'required|string|max:255',
            'note'             => 'nullable|string|max:1000',
            'payment_method'   => 'required|string|in:cod,bank',
        ]);

        $cart = $this->getCart()->load('items.product');

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        return DB::transaction(function () use ($request, $cart) {

            $subtotal = (int) $cart->items->sum(fn ($i) => $i->price * $i->quantity);
            $shippingFee = 0;

            // ✅ khóa + check tồn kho chống tranh chấp
            foreach ($cart->items as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                if (!$product) {
                    return redirect()->route('cart.index')->with('error', 'Có sản phẩm không tồn tại trong giỏ.');
                }
                if (!(int) $product->status) {
                    return redirect()->route('cart.index')->with('error', "Sản phẩm {$product->name} đang tạm ẩn.");
                }
                if ((int) $product->stock < (int) $item->quantity) {
                    return redirect()->route('cart.index')->with(
                        'error',
                        "Sản phẩm {$product->name} không đủ tồn kho! Chỉ còn {$product->stock}."
                    );
                }
            }

            // ✅ trừ kho
            foreach ($cart->items as $item) {
                Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
            }

            // ✅ coupon: lock + validate lại (vì có thể session giữ mã tới lúc đặt mới hết hạn)
            $couponCode = session('applied_coupon');
            $coupon = null;

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->lockForUpdate()->first();
                $now = now();

                $invalid =
                    !$coupon ||
                    (int) $coupon->status !== 1 ||
                    (!is_null($coupon->usage_limit) && (int) $coupon->used_count >= (int) $coupon->usage_limit) ||
                    ($coupon->starts_at && $now->lt($coupon->starts_at)) ||
                    ($coupon->ends_at && $now->gt($coupon->ends_at)) ||
                    ($subtotal < (int) $coupon->min_order_total);

                if ($invalid) {
                    session()->forget('applied_coupon');
                    $coupon = null;
                }
            }

            $discountAmount = $this->calcDiscount($coupon, $subtotal);
            $total = max(0, $subtotal + $shippingFee - $discountAmount);

            // ✅ tạo order (🔥 đã lưu user_id để review check chắc hơn)
            $order = Order::create([
                'user_id'          => Auth::id(), // null nếu guest

                'customer_name'    => $request->customer_name,
                'customer_phone'   => $request->customer_phone,
                'customer_email'   => $request->customer_email,
                'customer_address' => $request->customer_address,
                'note'             => $request->note,

                'coupon_code'      => $coupon ? $coupon->code : null,
                'subtotal'         => $subtotal,
                'shipping_fee'     => $shippingFee,
                'discount_amount'  => $discountAmount,
                'total'            => $total,

                'payment_method'   => $request->payment_method,
                'status'           => 'pending',
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $item->product_id,
                    'price'       => $item->price,
                    'quantity'    => $item->quantity,
                    'line_total'  => $item->price * $item->quantity,
                ]);
            }

            // ✅ tăng used_count coupon (sau khi order tạo OK)
            if ($coupon) {
                $coupon->increment('used_count');
            }

            // clear cart + clear coupon session
            CartItem::where('cart_id', $cart->id)->delete();
            session()->forget('applied_coupon');

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Đặt hàng thành công!');
        });
    }

    public function success(Order $order)
    {
        $order->load('items.product');
        return view('checkout.success', compact('order'));
    }


    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->withCount('items')
            ->orderByDesc('created_at')
            ->get();

        return view('orders.my', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        // chặn xem đơn người khác
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

}
