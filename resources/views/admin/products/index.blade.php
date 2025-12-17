<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Sản phẩm</title></head>
<body>
<h1>Danh sách sản phẩm</h1>

<p><a href="{{ route('admin.products.create') }}">+ Thêm sản phẩm</a></p>
@if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th><th>Ảnh</th><th>Tên</th><th>Danh mục</th><th>Giá</th><th>Tồn</th><th>Hành động</th>
    </tr>
    @foreach($products as $p)
    <tr>
        <td>{{ $p->id }}</td>
        <td>
            @if($p->image)
                <img src="{{ asset('storage/'.$p->image) }}" width="60">
            @endif
        </td>
        <td>
            <a href="{{ route('admin.products.show', $p->id) }}">
                {{ $p->name }}
            </a>
        </td>

        <td>{{ $p->category?->name }}</td>
        <td>{{ number_format($p->price) }} đ</td>
        <td>{{ $p->stock }}</td>
        <td>
            <a href="{{ route('admin.products.edit', $p->id) }}">Sửa</a>
            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button onclick="return confirm('Xóa sản phẩm này nha?')" type="submit">Xóa</button>
            </form>
            <form action="{{ route('cart.add', $p->id) }}" method="POST" style="display:inline">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit">Thêm vào giỏ</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<div style="margin-top:12px">{{ $products->links() }}</div>
</body>
</html>
