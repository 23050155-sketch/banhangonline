<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Chi tiết đơn hàng</title>
</head>
<body>
    <h1>Đơn hàng #{{ $order->id }}</h1>

    <p><a href="{{ route('admin.orders.index') }}">← Quay lại</a></p>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <h3>Thông tin khách hàng</h3>
    <ul>
        <li>Tên: {{ $order->customer_name }}</li>
        <li>Điện thoại: {{ $order->customer_phone }}</li>
        <li>Email: {{ $order->customer_email ?? '—' }}</li>
        <li>Địa chỉ: {{ $order->customer_address }}</li>
        <li>Ghi chú: {{ $order->note ?? '—' }}</li>
    </ul>

    <h3>Sản phẩm trong đơn</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>

        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name ?? '[Đã xóa]' }}</td>
                <td>{{ number_format($item->price) }} đ</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->line_total) }} đ</td>
            </tr>
        @endforeach
    </table>

    <h3>Tổng kết</h3>
    <ul>
        <li>Tạm tính: {{ number_format($order->subtotal) }} đ</li>
        <li>Phí ship: {{ number_format($order->shipping_fee) }} đ</li>

        @if(($order->discount_amount ?? 0) > 0)
            <li>Giảm giá:
                -{{ number_format($order->discount_amount) }} đ
                @if(!empty($order->coupon_code))
                    (Mã: <b>{{ $order->coupon_code }}</b>)
                @endif
            </li>
        @endif

        <li><b>Tổng cộng: {{ number_format($order->total) }} đ</b></li>
        <li>Thanh toán: {{ strtoupper($order->payment_method) }}</li>
    </ul>

    <h3>Cập nhật trạng thái đơn</h3>
    <form method="POST" action="{{ route('admin.orders.status', $order->id) }}">
        @csrf
        @method('PATCH')

        <select name="status">
            <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Chờ xử lý</option>
            <option value="confirmed" {{ $order->status=='confirmed'?'selected':'' }}>Đã xác nhận</option>
            <option value="shipping" {{ $order->status=='shipping'?'selected':'' }}>Đang giao</option>
            <option value="done" {{ $order->status=='done'?'selected':'' }}>Hoàn thành</option>
            <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Hủy</option>
        </select>

        <button type="submit">Cập nhật</button>
    </form>
</body>
</html>
