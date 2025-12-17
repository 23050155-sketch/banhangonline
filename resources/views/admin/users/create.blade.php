<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Tạo user</title></head>
<body>
<h1>Thêm user</h1>

@if($errors->any())
  <ul style="color:red">
    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
  </ul>
@endif

<form method="POST" action="{{ route('admin.users.store') }}">
  @csrf
  <p>Name</p><input name="name" value="{{ old('name') }}">
  <p>Email</p><input name="email" type="email" value="{{ old('email') }}">
  <p>Password</p><input name="password" type="password">

  <p>Role</p>
  <select name="role">
    <option value="customer">customer</option>
    <option value="admin">admin</option>
  </select>

  <p>Status</p>
  <select name="status">
    <option value="1">active</option>
    <option value="0">blocked</option>
  </select>

  <p>Phone</p><input name="phone" value="{{ old('phone') }}">
  <p>Address</p><input name="address" value="{{ old('address') }}">

  <button type="submit">Lưu</button>
</form>

<p><a href="{{ route('admin.users.index') }}">← Quay lại</a></p>
</body>
</html>
