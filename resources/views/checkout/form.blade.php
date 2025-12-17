<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Thanh toán</title>
</head>
<body>
<h1>Thanh toán</h1>

@if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

<h3>Đơn hàng</h3>
<ul>
@foreach($cart->items as $item)
    <li>
        {{ $item->product->name ?? '[Đã xóa]' }} -
        SL: {{ $item->quantity }} -
        {{ number_format($item->price * $item->quantity) }} đ
    </li>
@endforeach
</ul>


<h3>Mã giảm giá</h3>

@if($coupon)
    <p>
        Đang áp mã: <b>{{ $coupon->code }}</b>
        (giảm: {{ number_format($discountAmount) }} đ)
    </p>

    <form method="POST" action="{{ route('checkout.coupon.remove') }}">
        @csrf
        @method('DELETE')
        <button type="submit">Gỡ mã</button>
    </form>
@else
    <form method="POST" action="{{ route('checkout.coupon.apply') }}">
        @csrf
        <input name="code" placeholder="Nhập mã (VD: SALE10)">
        <button type="submit">Áp mã</button>
    </form>
@endif





<p>Tạm tính: <b>{{ number_format($subtotal) }} đ</b></p>
<p>Ship: <b>{{ number_format($shippingFee) }} đ</b></p>
<p>Tổng: <b>{{ number_format($total) }} đ</b></p>

<hr>

<form method="POST" action="{{ route('checkout.place') }}">
    @csrf

    <p>
        Họ tên: <br>
        <input name="customer_name" value="{{ old('customer_name') }}" required>
    </p>

    <p>
        Số điện thoại: <br>
        <input name="customer_phone" value="{{ old('customer_phone') }}" required>
    </p>

    <p>
        Email (không bắt buộc): <br>
        <input name="customer_email" value="{{ old('customer_email') }}">
    </p>

    <p>
        Địa chỉ: <br>
        <input name="customer_address" value="{{ old('customer_address') }}" required style="width:400px">
    </p>

    <p>
        Ghi chú: <br>
        <textarea name="note" rows="3" cols="50">{{ old('note') }}</textarea>
    </p>

    <p>
        Thanh toán: <br>
        <select name="payment_method">
            <option value="cod">COD (nhận hàng trả tiền)</option>
            <option value="bank">Chuyển khoản</option>
        </select>
    </p>

    <button type="submit">Đặt hàng</button>
</form>

</body>
</html>
