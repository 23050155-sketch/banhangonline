<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lịch sử đơn hàng</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/public.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/order_history.css') }}" />
</head>
<body>
    <!-- Họa tiết trang trí -->
    <div class="decoration-top-left"></div>
    <div class="decoration-top-right"></div>
    <div class="decoration-bottom-left"></div>
    <div class="decoration-bottom-right"></div>

    <main class="order-history-page">
        <div class="container">
            <div class="page-header">
                <h1>Lịch Sử Đơn Hàng</h1>
                <p>Xem lại các đơn hàng bạn đã đặt</p>
            </div>

            <div class="order-history-content">

                {{-- Nếu có đơn --}}
                @if($orders->count() > 0)
                    <div id="ordersContainer" class="orders-container">
                        @foreach($orders as $order)
                            @php
                                $orderCode = 'DH' . str_pad((string)$order->id, 6, '0', STR_PAD_LEFT);

                                $statusText = match($order->status) {
                                    'pending' => 'Chờ xử lý',
                                    'processing' => 'Đang xử lý',
                                    'shipping' => 'Đang giao',
                                    'completed', 'done' => 'Hoàn thành',
                                    'cancelled', 'canceled' => 'Đã hủy',
                                    default => $order->status,
                                };

                                $statusClass = match($order->status) {
                                    'pending' => 'status-cho-xu-ly',
                                    'processing','shipping' => 'status-dang-xu-ly',
                                    'completed','done' => 'status-hoan-thanh',
                                    'cancelled','canceled' => 'status-da-huy',
                                    default => '',
                                };
                            @endphp

                            <div class="order-card">
                                <div class="order-card-header">
                                    <div class="left">
                                        <div class="order-code">{{ $orderCode }}</div>
                                        <div class="order-date">
                                            <i class="fa-regular fa-calendar"></i>
                                            {{ $order->created_at?->format('d/m/Y H:i') }}
                                        </div>
                                    </div>

                                    <div class="right">
                                        <span class="order-status {{ $statusClass }}">{{ $statusText }}</span>
                                    </div>
                                </div>

                                <div class="order-card-body">
                                    <div class="order-meta">
                                        <div class="meta-item">
                                            <span class="label">Số món</span>
                                            <span class="value">{{ $order->items_count ?? $order->items->count() }}</span>
                                        </div>

                                        <div class="meta-item">
                                            <span class="label">Thanh toán</span>
                                            <span class="value">{{ strtoupper($order->payment_method) }}</span>
                                        </div>

                                        <div class="meta-item">
                                            <span class="label">Tổng tiền</span>
                                            <span class="value price">{{ number_format($order->total) }} đ</span>
                                        </div>
                                    </div>

                                    <div class="order-actions">
                                        <a class="btn btn-secondary" href="{{ route('orders.show', $order->id) }}">
                                            <i class="fa-regular fa-eye"></i>
                                            Xem chi tiết
                                        </a>

                                        <a class="btn btn-primary" href="{{ route('home') }}">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                            Mua tiếp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                {{-- Empty state --}}
                @else
                    <div class="empty-state" id="emptyState">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>Chưa có đơn hàng nào</h3>
                        <p>Hãy mua sắm và tạo đơn hàng đầu tiên của bạn</p>
                        <a class="btn btn-primary" href="{{ route('home') }}">
                            <i class="fas fa-shopping-cart"></i>
                            Mua Sắm Ngay
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </main>
</body>
</html>
