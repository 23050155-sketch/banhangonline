<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getCart(): Cart
    {
        // đảm bảo có session id (dùng để nhận diện khách vãng lai)
        $sessionId = session()->getId();

        // Nếu có login thì ưu tiên user_id
        $userId = Auth::check() ? Auth::id() : null;

        // 1) Nếu user đã login => tìm cart theo user_id
        if ($userId) {
            $cart = Cart::firstOrCreate(
                ['user_id' => $userId],
                ['session_id' => $sessionId]
            );

            // đồng bộ session_id cho chắc (đề phòng đổi session)
            if ($cart->session_id !== $sessionId) {
                $cart->update(['session_id' => $sessionId]);
            }

            return $cart;
        }

        // 2) Khách chưa login => tìm cart theo session_id
        return Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => null]
        );
    }

    public function index()
    {
        $cart = $this->getCart()->load('items.product');

        $subtotal = $cart->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1|max:999',
        ]);

        $qty = (int)($request->quantity ?? 1);

        // nếu sản phẩm đang ẩn thì không cho add
        if (!$product->status) {
            return redirect()->back()->with('error', 'Sản phẩm đang tạm ẩn!');
        }

        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Sản phẩm đã hết hàng!');
        }

        $cart = $this->getCart();

        // Nếu item đã tồn tại thì + số lượng
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->update([
                'quantity' => $item->quantity + $qty,
                // price giữ nguyên lúc add lần đầu, hoặc cập nhật theo giá mới tùy bạn:
                // 'price' => $product->price,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $qty,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:999',
        ]);

        $cart = $this->getCart();

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->firstOrFail();

        // sản phẩm không khả dụng
        if (!$product->status) {
            return redirect()->back()->with('error', 'Sản phẩm hiện không khả dụng.');
        }

        // CHẶN TỒN KHO
        if ($request->quantity > $product->stock) {
            return redirect()->back()
                ->with('error', "Sản phẩm chỉ còn {$product->stock} cái.");
        }

        $item->update([
            'quantity' => (int) $request->quantity,
        ]);

        return redirect()->route('cart.index')
            ->with('success', 'Đã cập nhật số lượng!');
    }


    public function remove(Product $product)
    {
        $cart = $this->getCart();

        CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->delete();

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ!');
    }

    public function clear()
    {
        $cart = $this->getCart();

        CartItem::where('cart_id', $cart->id)->delete();

        return redirect()->route('cart.index')->with('success', 'Đã xóa hết giỏ hàng!');
    }
}
