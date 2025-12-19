<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    // ====== HOME ======
    public function home()
    {
        // ⭐ Nổi bật (admin tick is_featured)
        $featuredProducts = Product::where('status', 1)
            ->where('is_featured', 1)
            ->latest()
            ->take(8)
            ->get();

        // 🔥 Hot (xem nhiều: view_count)
        $hotProducts = Product::where('status', 1)
            ->orderByDesc('view_count')
            ->latest() // nếu view_count bằng nhau thì ưu tiên mới
            ->take(8)
            ->get();

        // 🛒 Bán chạy (sum quantity từ order_items)
        $bestSellerProducts = Product::query()
            ->where('products.status', 1)
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->select('products.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->orderByDesc('products.id')
            ->take(8)
            ->get();

        return view('home', compact('featuredProducts', 'hotProducts', 'bestSellerProducts'));
    }

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

        $brand = $request->query('brand');
        if ($brand) {
            $products = $category->products()
                ->where('status', 1)
                ->where('brand', $brand)
                ->latest()
                ->paginate(12)
                ->withQueryString();

            return view($view, compact('category', 'products', 'brand'));
        }

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


    public function featuredPage()
    {
        $products = Product::where('status', 1)
            ->where('is_featured', 1)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $title = '🌟 Sản phẩm nổi bật';
        $subtitle = 'Tất cả sản phẩm được admin chọn';
        return view('public.special_list', compact('products', 'title', 'subtitle'));
    }

    public function hotPage()
    {
        $products = Product::where('status', 1)
            ->orderByDesc('view_count')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $title = '🔥 Sản phẩm hot';
        $subtitle = 'Những sản phẩm được xem nhiều nhất';
        return view('public.special_list', compact('products', 'title', 'subtitle'));
    }

    public function bestPage()
    {
        $products = Product::query()
            ->where('products.status', 1)
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->select('products.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->orderByDesc('products.id')
            ->paginate(12)
            ->withQueryString();

        $title = '🛒 Sản phẩm bán chạy';
        $subtitle = 'Những sản phẩm được mua nhiều nhất';
        return view('public.special_list', compact('products', 'title', 'subtitle'));
    }


}
