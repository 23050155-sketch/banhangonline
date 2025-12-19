<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chi tiết đơn hàng</title>

  <link rel="stylesheet" href="{{ asset('css/public.css') }}">
  <link rel="stylesheet" href="{{ asset('css/order_detail.css') }}">
</head>
<body>
  <main class="order-detail-page">
    <div class="container">

      {{-- Header --}}
      <div class="order-detail-header">
        <div class="left">
          <h1>Đơn hàng #{{ $order->id }}</h1>
          <p>Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="right">
          <span class="order-status status-{{ $order->status }}">
            {{ strtoupper($order->status) }}
          </span>
          <a class="btn btn-secondary" href="{{ route('orders.my') }}">
            ← Quay lại
          </a>
        </div>
      </div>

      {{-- Danh sách sản phẩm --}}
      <div class="card">
        <div class="card-title">Sản phẩm đã đặt</div>

        <div class="order-items">
          @foreach($order->items as $item)
            <div class="order-item">
              <div class="item-image">
                @if(optional($item->product)->image)
                  <img src="{{ asset('storage/'.$item->product->image) }}" alt="">
                @else
                  <div class="no-image">No image</div>
                @endif
              </div>

              <div class="item-info">
                <div class="item-name">
                  {{ optional($item->product)->name ?? '[Sản phẩm đã xóa]' }}
                </div>

                <div class="item-meta">
                  <span>SL: {{ $item->quantity }}</span>
                  <span>Đơn giá: {{ number_format($item->price) }} đ</span>
                </div>
              </div>

              <div class="item-total">
                {{ number_format($item->line_total) }} đ
              </div>
            </div>
          @endforeach
        </div>
      </div>

      {{-- Tổng kết --}}
      <div class="card summary-card">
        <div class="card-title">Tổng kết đơn hàng</div>

        <div class="summary-line">
          <span>Tạm tính</span>
          <span>{{ number_format($order->subtotal) }} đ</span>
        </div>

        <div class="summary-line">
          <span>Giảm giá</span>
          <span>-{{ number_format($order->discount_amount) }} đ</span>
        </div>

        <div class="summary-line">
          <span>Phí ship</span>
          <span>{{ number_format($order->shipping_fee) }} đ</span>
        </div>

        <div class="summary-total">
          <span>Tổng thanh toán</span>
          <span>{{ number_format($order->total) }} đ</span>
        </div>
      </div>

    </div>
  </main>
</body>
</html>
