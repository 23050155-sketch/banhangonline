@if(session('success'))
  <div class="alert success">{{ session('success') }}</div>
@endif

<div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
  <div>
    <div style="color:var(--muted);font-size:13px">Đơn hàng</div>
    <div style="font-size:18px;font-weight:700">#{{ $order->id }}</div>
  </div>

  <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
    <span class="btn btn-outline" style="cursor:default">
      {{ strtoupper($order->payment_method) }}
    </span>
    <span class="btn btn-outline" style="cursor:default">
      {{ $order->status }}
    </span>
  </div>
</div>

<hr style="border:none;border-top:1px solid var(--line);margin:12px 0">

<div class="grid-2">
  <div>
    <div class="card" style="box-shadow:none">
      <div class="card-header"><b>Thông tin khách hàng</b></div>
      <div class="card-body" style="color:var(--muted)">
        <div><b style="color:var(--text)">Tên:</b> {{ $order->customer_name }}</div>
        <div><b style="color:var(--text)">Điện thoại:</b> {{ $order->customer_phone }}</div>
        <div><b style="color:var(--text)">Email:</b> {{ $order->customer_email ?? '—' }}</div>
        <div style="margin-top:8px"><b style="color:var(--text)">Địa chỉ:</b> {{ $order->customer_address }}</div>
        <div style="margin-top:8px"><b style="color:var(--text)">Ghi chú:</b> {{ $order->note ?? '—' }}</div>
      </div>
    </div>
  </div>

  <div>
    <div class="card" style="box-shadow:none">
      <div class="card-header"><b>Tổng kết</b></div>
      <div class="card-body" style="color:var(--muted)">
        <div><b style="color:var(--text)">Tạm tính:</b> {{ number_format($order->subtotal) }} đ</div>
        <div><b style="color:var(--text)">Phí ship:</b> {{ number_format($order->shipping_fee) }} đ</div>

        @if(($order->discount_amount ?? 0) > 0)
          <div style="margin-top:6px">
            <b style="color:var(--text)">Giảm giá:</b> -{{ number_format($order->discount_amount) }} đ
            @if(!empty($order->coupon_code))
              (Mã: <b style="color:var(--text)">{{ $order->coupon_code }}</b>)
            @endif
          </div>
        @endif

        <div style="margin-top:10px;font-size:16px">
          <b style="color:var(--text)">Tổng cộng:</b> <b>{{ number_format($order->total) }} đ</b>
        </div>

        <div style="margin-top:10px">
          <b style="color:var(--text)">Thanh toán:</b> {{ strtoupper($order->payment_method) }}
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card" style="margin-top:12px;box-shadow:none">
  <div class="card-header"><b>Sản phẩm trong đơn</b></div>
  <div class="card-body table-wrap">
    <table class="table" style="min-width:700px">
      <thead>
        <tr>
          <th>Sản phẩm</th>
          <th>Giá</th>
          <th>Số lượng</th>
          <th>Thành tiền</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
          <tr>
            <td>{{ $item->product->name ?? '[Đã xóa]' }}</td>
            <td>{{ number_format($item->price) }} đ</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->line_total) }} đ</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="card" style="margin-top:12px;box-shadow:none">
  <div class="card-header"><b>Cập nhật trạng thái</b></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.orders.status', $order->id) }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
      @csrf
      @method('PATCH')

      <select class="input" name="status" style="max-width:260px">
        <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Chờ xử lý</option>
        <option value="confirmed" {{ $order->status=='confirmed'?'selected':'' }}>Đã xác nhận</option>
        <option value="shipping" {{ $order->status=='shipping'?'selected':'' }}>Đang giao</option>
        <option value="done" {{ $order->status=='done'?'selected':'' }}>Hoàn thành</option>
        <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Hủy</option>
      </select>

      <button class="btn" type="submit">Cập nhật</button>
      <button class="btn btn-outline" type="button" onclick="closeModal()">Đóng</button>
    </form>
  </div>
</div>
