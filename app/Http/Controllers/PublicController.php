<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // ====== Pages ======
    public function phones(Request $request)
    {
        return $this->categoryPage($request, 'dien-thoai', 'public.phones');
    }

    public function laptops(Request $request)
    {
        return $this->categoryPage($request, 'laptop', 'public.laptops');
    }

    public function clothes(Request $request)
    {
        return $this->categoryPage($request, 'thoi-trang', 'public.clothes');
    }

    public function cars(Request $request)
    {
        return $this->categoryPage($request, 'o-to', 'public.cars');
    }

    // ====== Core logic (group brand + optional filter) ======
    private function categoryPage(Request $request, string $slug, string $view)
    {
        $category = Category::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        // Nếu có brand -> show full (paginate)
        $brand = $request->query('brand');
        if ($brand) {
            $products = $category->products()
                ->where('status', 1)
                ->where('brand', $brand)
                ->latest()
                ->paginate(12)
                ->withQueryString();

            // view vẫn là public.phones/public.laptops... tuỳ bạn,
            // chỉ cần trong blade kiểm tra có $brand thì render kiểu "lọc"
            return view($view, compact('category', 'products', 'brand'));
        }

        // Không có brand -> group theo brand (giống ảnh)
        $allProducts = $category->products()
            ->where('status', 1)
            ->orderByRaw("COALESCE(NULLIF(brand,''),'zzz')")
            ->latest()
            ->get();

        $productsByBrand = $allProducts->groupBy(function ($p) {
            return $p->brand ? trim($p->brand) : 'Khác';
        });

        $brandCounts = $productsByBrand->map(fn($items) => $items->count());

        return view($view, compact('category', 'productsByBrand', 'brandCounts'));
    }
}
