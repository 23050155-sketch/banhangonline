<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng ký</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
  <div class="auth">
    <div class="card">
      <div class="card-head">
        <h1 class="title">Đăng ký</h1>
        <p class="sub">Tạo tài khoản cái là chiến 😌</p>
      </div>

      <div class="card-body">
        @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert error">{{ session('error') }}</div> @endif

        @if($errors->any())
          <ul class="ul-errors">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        @endif

        <form class="form" method="POST" action="{{ route('register.post') }}">
          @csrf

          <div class="field">
            <label>Họ tên</label>
            <input class="input" name="name" value="{{ old('name') }}" required autocomplete="name">
          </div>

          <div class="field">
            <label>Email</label>
            <input class="input" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
          </div>

          <div class="field">
            <label>Mật khẩu</label>
            <input class="input" name="password" type="password" required autocomplete="new-password">
          </div>

          <div class="field">
            <label>Nhập lại mật khẩu</label>
            <input class="input" name="password_confirmation" type="password" required autocomplete="new-password">
          </div>

          <button class="btn" type="submit">Tạo tài khoản</button>

          <p class="help">
            Đã có tài khoản?
            <a href="{{ route('login') }}">Đăng nhập</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
