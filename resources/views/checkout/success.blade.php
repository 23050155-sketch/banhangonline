<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đặt hàng thành công</title>
</head>
<body>
<h1>Đặt hàng thành công ✅</h1>

@if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif

<p>Mã đơn: <b>#{{ $order->id }}</b></p>
<p>Trạng thái: <b>{{ $order->status }}</b></p>
<p>Tổng tiền: <b>{{ number_format($order->total) }} đ</b></p>

<h3>Chi tiết</h3>
<ul>
@foreach($order->items as $item)
    <li>
        {{ $item->product->name ?? '[Đã xóa]' }} -
        SL: {{ $item->quantity }} -
        {{ number_format($item->line_total) }} đ
    </li>
@endforeach
</ul>

<p>
    <a href="{{ route('cart.index') }}">Về giỏ hàng</a> |
    <a href="{{ route('admin.orders.index') }}">Admin xem đơn (nếu bạn cho phép)</a>
</p>
</body>
</html>
