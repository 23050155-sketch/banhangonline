<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        if (!(int) $product->status) {
            abort(404);
        }

        // HOT theo lượt xem: mỗi lần vào trang chi tiết +1
        $product->increment('view_count');

        $product->load([
            'category',
            'reviews' => function ($q) {
                $q->where('status', 1)->latest()->with('user');
            }
        ]);

        $avgRating = round((float) $product->reviews()->where('status', 1)->avg('rating'), 1);
        $totalReviews = (int) $product->reviews()->where('status', 1)->count();


        $relatedProducts = Product::query()
        ->where('status', 1)
        ->where('id', '!=', $product->id)
        ->when($product->category_id, fn($q) => $q->where('category_id', $product->category_id))
        ->inRandomOrder()
        ->take(8)
        ->get();



        return view('public.show', compact('product', 'avgRating', 'totalReviews', 'relatedProducts'));


    }
}
