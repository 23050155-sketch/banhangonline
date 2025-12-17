<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Thêm mã giảm giá</title>
</head>
<body>

<h1>Thêm mã giảm giá</h1>

<a href="{{ route('admin.coupons.index') }}">← Quay lại</a>

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('admin.coupons.store') }}">
    @csrf

    <p>
        Mã coupon:<br>
        <input name="code" required>
    </p>

    <p>
        Loại giảm:<br>
        <select name="type">
            <option value="percent">Giảm %</option>
            <option value="fixed">Giảm tiền</option>
        </select>
    </p>

    <p>
        Giá trị:<br>
        <input type="number" name="value" required>
    </p>

    <p>
        Đơn tối thiểu:<br>
        <input type="number" name="min_order">
    </p>

    <p>
        Số lượt dùng:<br>
        <input type="number" name="max_uses">
    </p>

    <p>
        Bắt đầu:<br>
        <input type="date" name="starts_at" required>
    </p>

    <p>
        Kết thúc:<br>
        <input type="date" name="ends_at">
    </p>

    <p>
        <label>
            <input type="checkbox" name="is_active" value="1" checked>
            Kích hoạt
        </label>
    </p>

    <button type="submit">Lưu coupon</button>
</form>

</body>
</html>
