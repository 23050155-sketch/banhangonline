<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = Review::with(['user', 'product'])
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', (int)$request->status);
            })
            ->when($request->filled('product_id'), function ($query) use ($request) {
                $query->where('product_id', (int)$request->product_id);
            })
            ->latest();

        $reviews = $q->paginate(10)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function toggle(Review $review)
    {
        $review->status = $review->status ? 0 : 1;
        $review->save();

        return back()->with('success', 'Đã cập nhật trạng thái đánh giá!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Đã xóa đánh giá!');
    }
}
