<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Giỏ hàng</title>
</head>
<body>
<h1>Giỏ hàng</h1>

@if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif
@if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

@if($cart->items->count() == 0)
    <p>Giỏ hàng trống.</p>
@else
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Tồn</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th>Hành động</th>
        </tr>
        @foreach($cart->items as $item)
            <tr>
                <td>{{ $item->product->name ?? '[Đã xóa]' }}</td>
                <td>{{ number_format($item->price) }} đ</td>
                <td>{{ $item->product->stock ?? 0 }}</td>

                <td>
                    <form action="{{ route('cart.update', $item->product_id) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="999" style="width:70px">
                        <button type="submit">Cập nhật</button>
                    </form>
                </td>

                <td>{{ number_format($item->price * $item->quantity) }} đ</td>

                <td>
                    <form action="{{ route('cart.remove', $item->product_id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Xóa sản phẩm này?')" type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <h3>Tạm tính: {{ number_format($subtotal) }} đ</h3>

    <p>
        <a href="{{ route('checkout.form') }}">👉 Thanh toán</a>
    </p>


    <form action="{{ route('cart.clear') }}" method="POST">
        @csrf
        @method('DELETE')
        <button onclick="return confirm('Xóa hết giỏ hàng?')" type="submit">Xóa hết</button>
    </form>
@endif

</body>
</html>
