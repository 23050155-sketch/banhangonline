<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Giỏ hàng</title>
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="brand">
        <div class="dot"></div>
        <div>
          <h1>Giỏ hàng</h1>
          <p>Kiểm tra sản phẩm trước khi thanh toán nha.</p>
        </div>
      </div>

      <div class="right-actions">
        <a class="btn ghost" href="{{ route('home') }}">Trở về trang chủ →</a>
      </div>
    </div>

    @if(session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert error">{{ session('error') }}</div>
    @endif

    <div class="grid">
      <div class="card">
        <div class="card-hd">
          <b>Danh sách sản phẩm</b>
          <span class="pill">{{ $cart->items->count() }} món</span>
        </div>

        <div class="card-bd">
          @if($cart->items->count() == 0)
            <div class="alert">Giỏ hàng trống 😭 <span class="note">Chọn vài món rồi quay lại nha.</span></div>
          @else
            <div style="overflow:auto">
              <table class="table" style="min-width:760px">
                <thead>
                  <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Tồn</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($cart->items as $item)
                    @php
                      $stock = $item->product->stock ?? 0;
                      $stockPill = $stock <= 0 ? 'out' : ($stock <= 5 ? 'low' : 'ok');
                    @endphp
                    <tr>
                      <td>
                        <div class="row-title">
                          <div class="name">{{ $item->product->name ?? '[Đã xóa]' }}</div>
                          <div class="sub">ID sp: {{ $item->product_id }}</div>
                        </div>
                      </td>

                      <td>{{ number_format($item->price) }} đ</td>

                      <td>
                        <span class="pill {{ $stockPill }}">
                          Tồn: {{ $stock }}
                        </span>
                      </td>

                      <td>
                        <form class="qty" action="{{ route('cart.update', $item->product->slug) }}" method="POST">
                        @csrf
                        <input class="input" type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="999">
                        <button class="btn small" type="submit">Cập nhật</button>
                        </form>


                      </td>

                      <td><b>{{ number_format($item->price * $item->quantity) }} đ</b></td>

                      <td style="text-align:right">
                        <form action="{{ route('cart.remove', $item->product->slug) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn small danger" type="submit" onclick="return confirm('Xóa sản phẩm này?')">
                            Xóa
                        </button>
                        </form>

                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="divider"></div>

            <div class="actions">
              <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn danger" onclick="return confirm('Xóa hết giỏ hàng?')" type="submit">
                  Xóa hết
                </button>
              </form>
              <a class="btn primary" href="{{ route('checkout.form') }}">Thanh toán ngay</a>
            </div>
          @endif
        </div>
      </div>

      <div class="card">
        <div class="card-hd">
          <b>Tóm tắt</b>
          <span class="badge">Giá gốc</span>
        </div>
        <div class="card-bd summary">
          <div class="line">
            <span>Tạm tính</span>
            <b>{{ number_format($subtotal) }} đ</b>
          </div>
          <div class="total">
            <span>Tổng dự kiến</span>
            <b>{{ number_format($subtotal) }} đ</b>
          </div>
          <div class="note">
            * Mã giảm giá + phí ship sẽ tính ở bước <b>Thanh toán</b>.
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
