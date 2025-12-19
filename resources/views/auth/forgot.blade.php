<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quên mật khẩu</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
  <div class="auth">
    <div class="card">
      <div class="card-head">
        <h1 class="title">Quên mật khẩu</h1>
        <p class="sub">Nhập email để nhận link reset nè</p>
      </div>

      <div class="card-body">
        @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert error">{{ session('error') }}</div> @endif

        @if($errors->any())
          <ul class="ul-errors">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        @endif

        <form class="form" method="POST" action="{{ route('password.email') }}">
          @csrf

          <div class="field">
            <label>Email</label>
            <input class="input" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
          </div>

          <button class="btn" type="submit">Gửi link đặt lại mật khẩu</button>

          <p class="help">
            À nhớ ra mật khẩu rồi?
            <a href="{{ route('login') }}">Quay lại đăng nhập</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
