<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đặt lại mật khẩu</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
  <div class="auth">
    <div class="card">
      <div class="card-head">
        <h1 class="title">Đặt lại mật khẩu</h1>
        <p class="sub">Đổi pass mới cho chắc kèo 🔒</p>
      </div>

      <div class="card-body">
        @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert error">{{ session('error') }}</div> @endif

        @if($errors->any())
          <ul class="ul-errors">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        @endif

        <form class="form" method="POST" action="{{ route('password.update') }}">
  @csrf

  <input type="hidden" name="token" value="{{ $token }}">
  <input type="hidden" name="email" value="{{ request('email') }}">

  <div class="field">
    <label>Mật khẩu mới</label>
    <input class="input" name="password" type="password" required autocomplete="new-password">
  </div>

  <div class="field">
    <label>Nhập lại mật khẩu mới</label>
    <input class="input" name="password_confirmation" type="password" required autocomplete="new-password">
  </div>

  <button class="btn" type="submit">Cập nhật mật khẩu</button>

  <p class="help">
    <a href="{{ route('login') }}">Về đăng nhập</a>
  </p>
</form>

      </div>
    </div>
  </div>
</body>
</html>
