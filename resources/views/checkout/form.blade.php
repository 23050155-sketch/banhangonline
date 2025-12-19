<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thanh toán</title>
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="brand">
        <div class="dot"></div>
        <div>
          <h1>Thanh toán</h1>
          <p>Điền thông tin là chốt đơn liền 😌</p>
        </div>
      </div>

      <div class="right-actions">
        <a class="btn ghost" href="{{ route('cart.index') }}">← Về giỏ hàng</a>
      </div>
    </div>

    @if(session('error'))
      <div class="alert error">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif

    <div class="grid">
      <div class="card">
        <div class="card-hd">
          <b>Thông tin giao hàng</b>
          <span class="pill">COD / Chuyển khoản</span>
        </div>

        <div class="card-bd">
          <form method="POST" action="{{ route('checkout.place') }}">
            @csrf

            <div class="form-grid">
              <div class="field">
                <label>Họ tên</label>
                <input name="customer_name" value="{{ old('customer_name') }}" required>
              </div>

              <div class="field">
                <label>Số điện thoại</label>
                <input name="customer_phone" value="{{ old('customer_phone') }}" required>
              </div>

              <div class="field">
                <label>Email (không bắt buộc)</label>
                <input name="customer_email" value="{{ old('customer_email') }}">
              </div>

              <div class="field">
                <label>Thanh toán</label>
                <select name="payment_method">
                  <option value="cod">COD (nhận hàng trả tiền)</option>
                  <option value="bank">Chuyển khoản</option>
                </select>
              </div>

              <div class="field" style="grid-column: 1 / -1;">
                <label>Địa chỉ</label>
                <input name="customer_address" value="{{ old('customer_address') }}" required>
              </div>

              <div class="field" style="grid-column: 1 / -1;">
                <label>Ghi chú</label>
                <textarea name="note" rows="3" cols="50">{{ old('note') }}</textarea>
              </div>
            </div>

            <div class="divider"></div>

            <div class="actions">
              <button class="btn primary" type="submit">Đặt hàng</button>
              <a class="btn" href="{{ route('cart.index') }}">Xem lại giỏ</a>
            </div>
          </form>
        </div>
      </div>

      <div>
        <div class="card" style="margin-bottom:18px">
          <div class="card-hd">
            <b>Đơn hàng</b>
            <span class="pill">{{ $cart->items->count() }} món</span>
          </div>

          <div class="card-bd">
            @foreach($cart->items as $item)
              <div class="line">
                <span>
                  <b>{{ $item->product->name ?? '[Đã xóa]' }}</b><br>
                  <span class="note">SL: {{ $item->quantity }}</span>
                </span>
                <b>{{ number_format($item->price * $item->quantity) }} đ</b>
              </div>
            @endforeach
          </div>
        </div>

        <div class="card" style="margin-bottom:18px">
          <div class="card-hd">
            <b>Mã giảm giá</b>
            <span class="pill">Optional</span>
          </div>

          <div class="card-bd">
            @if($coupon)
              <div class="alert success" style="margin:0 0 12px 0">
                Đang áp mã: <b>{{ $coupon->code }}</b> — giảm: <b>{{ number_format($discountAmount) }} đ</b>
              </div>

              <form method="POST" action="{{ route('checkout.coupon.remove') }}">
                @csrf
                @method('DELETE')
                <button class="btn danger" type="submit">Gỡ mã</button>
              </form>
            @else
              <form method="POST" action="{{ route('checkout.coupon.apply') }}" class="qty">
                @csrf
                <input class="input" name="code" placeholder="Nhập mã (VD: SALE10)">
                <button class="btn" type="submit">Áp mã</button>
              </form>
              <div class="note" style="margin-top:10px">
                * Nhập mã xong tổng tiền sẽ tự cập nhật.
              </div>
            @endif
          </div>
        </div>

        <div class="card">
          <div class="card-hd">
            <b>Tổng kết</b>
            <span class="pill">Final</span>
          </div>

          <div class="card-bd summary">
            <div class="line">
              <span>Tạm tính</span>
              <b>{{ number_format($subtotal) }} đ</b>
            </div>

            <div class="line">
              <span>Giảm giá</span>
              <b>-{{ number_format($discountAmount ?? 0) }} đ</b>
            </div>

            <div class="line">
              <span>Ship</span>
              <b>{{ number_format($shippingFee) }} đ</b>
            </div>

            <div class="total">
              <span>Tổng thanh toán</span>
              <b>{{ number_format($total) }} đ</b>
            </div>

            <div class="note">
              
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</body>
</html>
