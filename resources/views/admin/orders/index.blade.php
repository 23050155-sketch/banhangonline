<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đơn hàng</title>
</head>
<body>
    <h1>Danh sách đơn hàng</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if($orders->count() == 0)
        <p>Chưa có đơn hàng nào.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Điện thoại</th>
                <th>Tổng tiền</th>
                <th>Thanh toán</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>

            @foreach($orders as $o)
                <tr>
                    <td>#{{ $o->id }}</td>
                    <td>{{ $o->customer_name }}</td>
                    <td>{{ $o->customer_phone }}</td>
                    <td>{{ number_format($o->total) }} đ</td>
                    <td>{{ strtoupper($o->payment_method) }}</td>
                    <td>{{ $o->status }}</td>
                    <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $o->id) }}">Xem</a>
                    </td>
                </tr>
            @endforeach
        </table>

        <div style="margin-top:12px">
            {{ $orders->links() }}
        </div>
    @endif
</body>
</html>
