@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
<section class="home-products" style="margin-top:24px;">
  <div class="container">
    <h2 class="section-title">Hồ sơ cá nhân</h2>

    {{-- Alert --}}
    @if(session('success'))
      <div class="pd-alert pd-alert-success" style="margin:12px 0;">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="pd-alert pd-alert-error" style="margin:12px 0;">
        {{ session('error') }}
      </div>
    @endif
    @if($errors->any())
      <div class="pd-alert pd-alert-error" style="margin:12px 0;">
        <ul style="margin:0; padding-left:18px;">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="profile-grid" style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
      {{-- Thông tin cá nhân --}}
      <div class="card" style="padding:18px;border-radius:16px;background:#fff;">
        <h3 style="margin:0 0 12px;">Thông tin cá nhân</h3>

        <form method="POST" action="{{ route('profile.update') }}">
          @csrf

          <div style="display:grid; gap:10px;">
            <div>
              <label style="font-weight:600;">Họ tên</label>
              <input class="search-input" style="width:100%;" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div>
              <label style="font-weight:600;">Email</label>
              <input class="search-input" style="width:100%;" value="{{ $user->email }}" disabled>
              <small style="opacity:.7;">Email hiện chưa cho sửa.</small>
            </div>

            <div>
              <label style="font-weight:600;">Số điện thoại</label>
              <input class="search-input" style="width:100%;" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="VD: 09xxxxxxx">
            </div>

            <div>
              <label style="font-weight:600;">Địa chỉ</label>
              <input class="search-input" style="width:100%;" name="address" value="{{ old('address', $user->address) }}" placeholder="Nhập địa chỉ...">
            </div>

            <button class="search-btn" type="submit" style="width:max-content;">Lưu thông tin</button>
          </div>
        </form>
      </div>

      {{-- Đổi mật khẩu --}}
      <div class="card" style="padding:18px;border-radius:16px;background:#fff;">
        <h3 style="margin:0 0 12px;">Đổi mật khẩu</h3>

        <form method="POST" action="{{ route('profile.password') }}">
          @csrf

          <div style="display:grid; gap:10px;">
            <div>
              <label style="font-weight:600;">Mật khẩu cũ</label>
              <input class="search-input" style="width:100%;" type="password" name="current_password" required>
            </div>

            <div>
              <label style="font-weight:600;">Mật khẩu mới</label>
              <input class="search-input" style="width:100%;" type="password" name="new_password" required>
            </div>

            <div>
              <label style="font-weight:600;">Xác nhận mật khẩu mới</label>
              <input class="search-input" style="width:100%;" type="password" name="new_password_confirmation" required>
            </div>

            <button class="search-btn" type="submit" style="width:max-content;">Đổi mật khẩu</button>
            <small style="opacity:.7;">Lưu ý: Hãy nhớ mật khẩu sau khi đổi !!!</small>
          </div>
        </form>
      </div>
    </div>

  </div>
</section>

<style>
@media (max-width: 900px){
  .profile-grid{ grid-template-columns: 1fr !important; }
}
</style>
@endsection
