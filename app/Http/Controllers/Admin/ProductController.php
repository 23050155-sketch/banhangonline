<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'description'   => 'nullable|string',
            'status'        => 'nullable|boolean',
            'is_featured'   => 'nullable|boolean',
            'image'         => 'nullable|image|max:2048',
            'brand' => 'nullable|string|max:100',

        ]);

        // ✅ slug (unique) để khỏi lỗi "slug doesn't have default value"
        $data['slug'] = $this->makeUniqueSlug($data['name']);

        // ✅ upload ảnh
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // ✅ boolean an toàn
        $data['status'] = $request->boolean('status');
        $data['is_featured'] = $request->boolean('is_featured');

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'description'   => 'nullable|string',
            'status'        => 'nullable|boolean',
            'is_featured'   => 'nullable|boolean',
            'image'         => 'nullable|image|max:2048',
            'brand' => 'nullable|string|max:100',
        ]);

        // ✅ đổi tên thì update slug (unique) theo tên mới
        $newSlug = $this->makeUniqueSlug($data['name'], $product->id);
        $data['slug'] = $newSlug;

        // ✅ upload ảnh mới + xóa ảnh cũ
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['status'] = $request->boolean('status');
        $data['is_featured'] = $request->boolean('is_featured');

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(Product $product)
    {
        // ✅ CÁCH 1: xóa con trước để không dính FK cart_items_product_id_foreign
        CartItem::where('product_id', $product->id)->delete();

        // ✅ xóa ảnh
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Xóa sản phẩm thành công!');
    }
}
