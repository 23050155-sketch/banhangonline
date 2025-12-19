<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đặt hàng thành công</title>
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="brand">
        <div class="dot"></div>
        <div>
          <h1>Đặt hàng thành công 🎉</h1>
          <p>Đơn của bạn đã được ghi nhận, shop sẽ xử lý sớm nha.</p>
        </div>
      </div>

      <div class="right-actions">
        <a class="btn ghost" href="{{ route('home') }}">← Trang chủ</a>
      </div>
    </div>

    @if(session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif

    <div class="grid">
      <div class="card">
        <div class="card-hd">
          <b>Thông tin đơn hàng</b>
          <span class="pill ok">#{{ $order->id }}</span>
        </div>

        <div class="card-bd">
          <div class="line">
            <span>Trạng thái</span>
            <b>{{ $order->status }}</b>
          </div>

          <div class="line">
            <span>Tổng tiền</span>
            <b style="color:var(--primary)">
              {{ number_format($order->total) }} đ
            </b>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-hd">
          <b>Chi tiết sản phẩm</b>
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

    <div class="actions" style="margin-top:20px">
      <a class="btn ghost" href="{{ route('cart.index') }}">← Về giỏ hàng</a>
      <a class="btn primary" href="{{ route('home') }}">Tiếp tục mua sắm</a>
    </div>
  </div>
</body>
</html>
