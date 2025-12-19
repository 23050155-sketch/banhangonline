<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Xác nhận đơn hàng</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/public.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/confirmation.css') }}" />
</head>
<body>

  <div class="decoration-top-left"></div>
  <div class="decoration-top-right"></div>
  <div class="decoration-bottom-left"></div>
  <div class="decoration-bottom-right"></div>

  @php
    // Format mã đơn kiểu DH000012
    $orderCode = 'DH' . str_pad((string)$order->id, 6, '0', STR_PAD_LEFT);

    // Map status text
    $statusText = match($order->status) {
      'pending' => 'Chờ xử lý',
      'processing' => 'Đang xử lý',
      'shipping' => 'Đang giao',
      'completed', 'done' => 'Hoàn thành',
      'cancelled', 'canceled' => 'Đã hủy',
      default => $order->status,
    };

    // Map status class (dùng bộ class không dấu/không space)
    $statusClass = match($order->status) {
      'pending' => 'status-cho-xu-ly',
      'processing', 'shipping' => 'status-dang-xu-ly',
      'completed', 'done' => 'status-hoan-thanh',
      'cancelled', 'canceled' => 'status-da-huy',
      default => '',
    };
  @endphp

  <main class="confirmation-page">
    <div class="container">
      <div class="confirmation-content confirmation-like-shot">

        <div class="success-icon success-circle">
          <i class="fas fa-check"></i>
        </div>

        <h1>Đặt Hàng Thành Công!</h1>
        <p class="success-message">
          Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đang được xử lý và sẽ được giao đến bạn trong thời gian sớm nhất.
        </p>

        <div class="order-details order-box-shot">
          <h2 class="order-title-shot">Thông Tin Đơn Hàng</h2>

          <div class="order-info shot-grid">
            <div class="info-row">
              <span class="label">Mã đơn hàng:</span>
              <span class="value">{{ $orderCode }}</span>
            </div>

            <div class="info-row">
              <span class="label">Ngày đặt:</span>
              <span class="value">{{ $order->created_at?->format('d/m/Y') }}</span>
            </div>

            <div class="info-row">
              <span class="label">Tổng tiền:</span>
              <span class="value">{{ number_format($order->total) }} đ</span>
            </div>

            <div class="info-row">
              <span class="label">Trạng thái:</span>
              <span class="value"><span class="{{ $statusClass }}">{{ $statusText }}</span></span>
            </div>
          </div>
        </div>

        <div class="confirmation-actions actions-shot">
          <a class="btn btn-primary btn-shot" href="{{ route('home') }}">
            <i class="fas fa-home"></i>
            Về Trang Chủ
          </a>

          @auth
            <a class="btn btn-secondary btn-shot" href="{{ route('orders.my') }}">
              <i class="fas fa-history"></i>
              Xem Lịch Sử Đơn Hàng
            </a>
          @endauth
        </div>

      </div>
    </div>
  </main>

</body>
</html>
