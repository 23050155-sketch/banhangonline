<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Login</title>
</head>
<body>
<h1>Login</h1>

@if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif
@if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

<form method="POST" action="{{ route('login.post') }}">
  @csrf
  <p>Email</p>
  <input name="email" type="email" value="{{ old('email') }}" required>

  <p>Password</p>
  <input name="password" type="password" required>

  <button type="submit">Đăng nhập</button>
</form>
</body>
</html>
