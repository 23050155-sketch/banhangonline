<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'ĐBDK2T - Cửa hàng điện tử & công nghệ')</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/public.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">


    @yield('head')
</head>
<body>

<!-- Họa tiết -->
<div class="decoration-top-left"></div>
<div class="decoration-top-right"></div>
<div class="decoration-bottom-left"></div>
<div class="decoration-bottom-right"></div>

<!-- HEADER (copy từ index.html, chỉ sửa link) -->
<header role="banner">
    <div class="main-header">
        <div class="container">
            <div class="header-content">

                <a href="{{ route('home') }}" class="logo">
                    <i class="fas fa-microchip"></i> KDB Shop
                </a>

                <nav>
                      <ul class="nav-menu">
                          <li class="nav-item">
                              <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                                  <i class="fas fa-home"></i> Trang chủ
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('phones.page') }}" class="nav-link {{ request()->routeIs('phones.*') ? 'active' : '' }}">
                                  Điện Thoại
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('laptops.page') }}" class="nav-link {{ request()->routeIs('laptops.*') ? 'active' : '' }}">
                                  Laptop
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('clothes.page') }}" class="nav-link {{ request()->routeIs('clothes.*') ? 'active' : '' }}">
                                  Thời Trang
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('cars.page') }}" class="nav-link {{ request()->routeIs('cars.*') ? 'active' : '' }}">
                                  Phương Tiện
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                                  Liên hệ
                              </a>
                          </li>
                      </ul>
                  </nav>

                <div class="header-actions">
                    @auth
                        <div class="user-menu">
                            <button type="button" class="user-btn">
                            <i class="fas fa-user"></i>
                            {{ auth()->user()->name }}
                            <i class="fas fa-chevron-down caret"></i>
                            </button>

                            <div class="user-dropdown">
                            <a href="{{ route('profile.show') }}" class="ud-item">
                                <i class="fas fa-id-card"></i> Hồ sơ cá nhân
                            </a>

                            <a href="{{ route('orders.history') }}" class="ud-item">
                                <i class="fas fa-receipt"></i> Lịch sử đơn hàng
                            </a>


                            <div class="ud-line"></div>

                            <form action="{{ route('logout') }}" method="POST" class="ud-form">
                                @csrf
                                <button type="submit" class="ud-item ud-logout">
                                <i class="fas fa-right-from-bracket"></i> Đăng xuất
                                </button>
                            </form>
                            </div>
                        </div>
                        @else
                        <a href="{{ route('login') }}" class="login-btn">
                            <i class="fas fa-user"></i> Đăng nhập
                        </a>
                    @endauth



                    <button class="header-action"
                        onclick="window.location.href='{{ route('cart.index') }}'">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="search-section">
        <div class="container">
            <form class="search-container" action="{{ route('search') }}" method="GET">
                <input class="search-input" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm sản phẩm...">

                <select name="category" class="search-input search-select">
                    <option value="">Tất cả danh mục</option>
                    @foreach(($globalCategories ?? []) as $c)
                    <option value="{{ $c->id }}" {{ (string)request('category') === (string)$c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                    @endforeach
                </select>

                <button class="search-btn" type="submit">Tìm kiếm</button>
            </form>
        </div>
    </div>
</header>

<!-- NỘI DUNG TRANG -->
<main>
    @yield('content')
</main>

<!-- FOOTER -->
<footer role="contentinfo">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Về ĐBDK2T Điện Tử</h3>
                    <p>
                        ĐBDK2T Điện Tử - Nơi cung cấp các sản phẩm điện tử chính hãng với
                        giá cả cạnh tranh và dịch vụ hậu mãi tốt nhất.
                    </p>
                </div>
                <div class="footer-column">
                    <h3>Liên Kết Nhanh</h3>
                    <ul class="footer-links">
                        <li><a href="dienthoai.html">Điện Thoại</a></li>
                        <li><a href="laptop.html">Laptop</a></li>
                        <li><a href="quanao.html">Thời Trang</a></li>
                        <li><a href="lego.html">Phương tiện</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Liên Hệ MXH</h3>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <i class="fab fa-github" aria-hidden="true"></i>Github
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-youtube" aria-hidden="true"></i>Youtube
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-tiktok" aria-hidden="true"></i>TikTok
                        </a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Thông Tin Liên Hệ</h3>
                    <ul class="contact-info-footer">
                        <li>
                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                            <span>504 Đại lộ Bình Dương</span>
                        </li>
                        <li>
                            <i class="fas fa-phone" aria-hidden="true"></i>
                            <span>01234567890</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                            <span>info@dbdk2tdientu.vn</span>
                        </li>
                        <li>
                            <i class="fas fa-clock" aria-hidden="true"></i>
                            <span>Thứ 2 - Chủ nhật: 8:00 - 20:00</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 ĐBDK2T Điện Tử. Tất cả các quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

{{-- JS --}}
<script src="{{ asset('assets/js/script.js') }}" defer></script>
<script src="{{ asset('assets/js/public.js') }}" defer></script>
<script src="{{ asset('assets/js/cart.js') }}" defer></script>

@yield('scripts')
</body>
</html>
