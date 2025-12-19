<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
  <div class="auth">
    <div class="card">
      <div class="card-head">
        <h1 class="title">Đăng nhập</h1>
        <p class="sub">Vào mua sắm thoi nào 🛒</p>
      </div>

      <div class="card-body">
        @if(session('success'))
          <div class="alert success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
          <ul class="ul-errors">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        @endif

        <form class="form" method="POST" action="{{ route('login.post') }}">
          @csrf

          <div class="field">
            <label>Email</label>
            <input class="input" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
          </div>

          <div class="field">
            <label>Mật khẩu</label>
            <input class="input" name="password" type="password" required autocomplete="current-password">
          </div>

          <div class="row">
            <a class="link" href="{{ route('password.request') }}">Quên mật khẩu?</a>
          </div>

          <button class="btn" type="submit">Đăng nhập</button>

          <p class="help">
            Chưa có tài khoản?
            <a href="{{ route('register') }}">Đăng ký</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
