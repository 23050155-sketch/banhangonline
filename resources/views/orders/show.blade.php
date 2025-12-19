<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chi tiết đơn hàng</title>
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body class="center-page">
  <div class="container">
    <div class="header">
      <div class="brand">
        <div class="dot"></div>
        <div>
          <h1>Đơn #{{ $order->id }}</h1>
          <p>Chi tiết đơn hàng của bạn</p>
        </div>
      </div>

      <div class="right-actions">
        <a class="btn ghost" href="{{ route('orders.my') }}">← Quay lại</a>
      </div>
    </div>

    <div class="grid">
      <div class="card">
        <div class="card-hd">
          <b>Thông tin đơn</b>
          <span class="pill">{{ $order->status }}</span>
        </div>

        <div class="card-bd summary">
          <div class="line">
            <span>Ngày đặt</span>
            <b>{{ $order->created_at->format('d/m/Y H:i') }}</b>
          </div>

          <div class="line">
            <span>Tổng tiền</span>
            <b>{{ number_format($order->total) }} đ</b>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-hd">
          <b>Sản phẩm</b>
          <span class="pill">{{ $order->items->count() }} món</span>
        </div>

        <div class="card-bd">
          @foreach($order->items as $item)
            <div class="line">
              <span>
                <b>{{ optional($item->product)->name ?? '[Đã xóa]' }}</b><br>
                <span class="note">SL: {{ $item->quantity }}</span>
              </span>
              <b>{{ number_format($item->line_total) }} đ</b>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</body>
</html>
