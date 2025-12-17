<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // ✅ GET: list reviews + avg rating
    public function index(Product $product)
    {
        $query = $product->reviews()->where('status', 1);

        return response()->json([
            'product_id'    => $product->id,
            'avg_rating'    => round((float) $query->avg('rating'), 1),
            'total_reviews' => (int) $query->count(),
            'reviews'       => $query->latest()->get(),
        ]);
    }

    // ✅ POST: create/update review
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đánh giá.');
        }

        $bought = OrderItem::where('product_id', $product->id)
            ->whereHas('order', function ($q) use ($user) {
                $q->where('status', 'done') 
                ->where(function ($qq) use ($user) {
                    $qq->where('user_id', $user->id)
                        ->orWhere('customer_email', $user->email);
                });
            })
            ->exists();


        if (!$bought) {
            return back()->with('error', 'Bạn chỉ được đánh giá khi đơn hàng đã hoàn thành.');
        }

        Review::updateOrCreate(
            [
                'user_id'    => $user->id,
                'product_id' => $product->id,
            ],
            [
                'rating'  => (int) $request->rating,
                'comment' => $request->comment,
                'status'  => 1,
            ]
        );

        return back()->with('success', 'Đánh giá thành công!');
    }
}
