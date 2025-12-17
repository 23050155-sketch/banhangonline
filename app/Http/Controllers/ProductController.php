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

        $product->load([
            'category',
            'reviews' => function ($q) {
                $q->where('status', 1)->latest()->with('user');
            }
        ]);

        $avgRating = round((float) $product->reviews()->where('status', 1)->avg('rating'), 1);
        $totalReviews = (int) $product->reviews()->where('status', 1)->count();

        return view('products.show', compact('product', 'avgRating', 'totalReviews'));
    }
}
