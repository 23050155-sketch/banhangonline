<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Sửa user</title></head>
<body>
<h1>Sửa user #{{ $user->id }}</h1>

@if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

@if($errors->any())
  <ul style="color:red">
    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
  </ul>
@endif

<form method="POST" action="{{ route('admin.users.update', $user->id) }}">
  @csrf
  @method('PUT')

  <p>Name</p><input name="name" value="{{ old('name',$user->name) }}">
  <p>Email</p><input name="email" type="email" value="{{ old('email',$user->email) }}">

  <p>Password (để trống nếu không đổi)</p>
  <input name="password" type="password">

  <p>Role</p>
  <select name="role">
    <option value="customer" {{ $user->role==='customer'?'selected':'' }}>customer</option>
    <option value="admin" {{ $user->role==='admin'?'selected':'' }}>admin</option>
  </select>

  <p>Status</p>
  <select name="status">
    <option value="1" {{ (int)$user->status===1?'selected':'' }}>active</option>
    <option value="0" {{ (int)$user->status===0?'selected':'' }}>blocked</option>
  </select>

  <p>Phone</p><input name="phone" value="{{ old('phone',$user->phone) }}">
  <p>Address</p><input name="address" value="{{ old('address',$user->address) }}">

  <button type="submit">Cập nhật</button>
</form>

<p><a href="{{ route('admin.users.index') }}">← Quay lại</a></p>
</body>
</html>
