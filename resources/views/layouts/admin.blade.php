<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Admin')</title>

  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="admin-wrap">

  <aside class="sidebar" id="sidebar">
    <div class="brand">
      <div class="logo">SHOP ADMIN</div>
      <div class="sub">Admin Panel</div>
    </div>

    <a class="nav {{ request()->routeIs('admin.dashboard')?'active':'' }}"
       href="{{ route('admin.dashboard') }}">
      <i class="fa-solid fa-gauge"></i><span>Dashboard</span>
    </a>

    <div class="nav-group">
      <button class="nav-parent" type="button" id="manageToggle">
        <span><i class="fa-solid fa-gear"></i> Quản lý</span>
        <i class="fa-solid fa-chevron-down"></i>
      </button>

      <div class="nav-children" id="manageMenu">
        <a class="nav {{ request()->routeIs('admin.users.*')?'active':'' }}"
           href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users"></i><span>User</span></a>

        <a class="nav {{ request()->routeIs('admin.categories.*')?'active':'' }}"
           href="{{ route('admin.categories.index') }}"><i class="fa-solid fa-list"></i><span>Danh mục</span></a>

        <a class="nav {{ request()->routeIs('admin.products.*')?'active':'' }}"
           href="{{ route('admin.products.index') }}"><i class="fa-solid fa-box"></i><span>Sản phẩm</span></a>

        <a class="nav {{ request()->routeIs('admin.orders.*')?'active':'' }}"
           href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-receipt"></i><span>Đơn hàng</span></a>

        <a class="nav {{ request()->routeIs('admin.coupons.*')?'active':'' }}"
           href="{{ route('admin.coupons.index') }}"><i class="fa-solid fa-ticket"></i><span>Coupon</span></a>

        <a class="nav {{ request()->routeIs('admin.reviews.*')?'active':'' }}"
           href="{{ route('admin.reviews.index') }}"><i class="fa-solid fa-star"></i><span>Đánh giá</span></a>
      </div>
    </div>
  </aside>

  <main class="main">
    <header class="topbar">
      <button class="icon-btn" id="sidebarBtn"><i class="fa-solid fa-bars"></i></button>

      <div class="topbar-right">
        <div class="me">
          <i class="fa-solid fa-user-circle"></i>
          <span>{{ auth()->user()->name ?? 'Admin' }}</span>
        </div>

        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="btn btn-outline" type="submit">
            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
          </button>
        </form>
      </div>
    </header>

    <section class="content">
      @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
      @if(session('error')) <div class="alert error">{{ session('error') }}</div> @endif

      <div class="page-head">
        <h1>@yield('page_title','Admin')</h1>
        <div>@yield('page_actions')</div>
      </div>

      @yield('content')
    </section>
  </main>

</div>

<script>
  const sidebarBtn = document.getElementById('sidebarBtn');
  const sidebar = document.getElementById('sidebar');
  sidebarBtn?.addEventListener('click', ()=> sidebar.classList.toggle('open'));

  const manageToggle = document.getElementById('manageToggle');
  const manageMenu = document.getElementById('manageMenu');
  const hasActive = manageMenu?.querySelector('.active');
  if(!hasActive && manageMenu) manageMenu.style.display = 'none';
  manageToggle?.addEventListener('click', ()=>{
    if(!manageMenu) return;
    manageMenu.style.display = (manageMenu.style.display === 'none') ? 'block' : 'none';
  });
</script>

<script src="{{ asset('js/admin.js') }}?v={{ time() }}"></script>
@stack('scripts')
</body>
</html>

