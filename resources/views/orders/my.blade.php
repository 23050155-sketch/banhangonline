<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đơn hàng của tôi</title>
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body class="center-page">
  <div class="container">
    <div class="header">
      <div class="brand">
        <div class="dot"></div>
        <div>
          <h1>Đơn hàng của tôi</h1>
          <p>Xem lại những đơn bạn đã đặt 🧾</p>
        </div>
      </div>

      <div class="right-actions">
        <a class="btn ghost" href="{{ route('home') }}">← Trang chủ</a>
      </div>
    </div>

    @if($orders->count() == 0)
      <div class="card">
        <div class="card-bd">
          <div class="alert">
            Bạn chưa có đơn hàng nào 😭  
            <br>
            <a class="btn primary" style="margin-top:12px" href="{{ route('home') }}">
              Mua sắm ngay
            </a>
          </div>
        </div>
      </div>
    @else
      <div class="card">
        <div class="card-hd">
          <b>Lịch sử đơn hàng</b>
          <span class="pill">{{ $orders->count() }} đơn</span>
        </div>

        <div class="card-bd">
          @foreach($orders as $order)
            <div class="line">
              <span>
                <b>#{{ $order->id }}</b><br>
                <span class="note">
                  {{ $order->created_at->format('d/m/Y H:i') }} •
                  {{ $order->items_count }} sản phẩm
                </span>
              </span>

              <span style="text-align:right">
                <b>{{ number_format($order->total) }} đ</b><br>
                <span class="pill">{{ $order->status }}</span>
              </span>

              <a class="btn small ghost"
                 href="{{ route('orders.show', $order->id) }}">
                Xem
              </a>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</body>
</html>
