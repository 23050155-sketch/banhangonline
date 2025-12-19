@extends('layouts.app')

@section('title', 'ĐBDK2T - Trang chủ')

@section('content')
    <!-- HERO -->
    <section class="hero-slider">
        <div class="container">
            <div class="slider-container">
                <div class="slider">

                    <!-- Slide 1 -->
                    <div class="slide active">
                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1600&q=80">
                        <div class="slide-content">
                            <h3>Laptop Chính Hãng</h3>
                            <p>Học tập - Làm việc - Gaming</p>
                            <a href="{{ route('laptops.page') }}" class="btn btn-accent">
                                Xem Laptop
                            </a>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="slide">
                        <img src="https://images.unsplash.com/photo-1520975958225-4d934f1a07a8?auto=format&fit=crop&w=1600&q=80">
                        <div class="slide-content">
                            <h3>Thời Trang Trendy</h3>
                            <p>Quần áo mới mỗi tuần</p>
                            <a href="{{ route('clothes.page') }}" class="btn btn-accent">
                                Xem Quần Áo
                            </a>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="slide">
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1600&q=80">
                        <div class="slide-content">
                            <h3>Xe Hơi & Ô Tô</h3>
                            <p>Chọn xe theo nhu cầu</p>
                            <a href="{{ route('cars.page') }}" class="btn btn-accent">
                                Xem Xe
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- CATEGORIES -->
    <section class="categories">
        <div class="container">
            <h2 class="section-title">Danh mục nổi bật</h2>

            <div class="category-grid">

                <a href="{{ route('phones.page') }}" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-mobile-alt icon-default"></i>
                        <i class="fas fa-arrow-right icon-hover"></i>
                    </div>
                    <div class="category-name">Điện thoại</div>
                </a>

                <a href="{{ route('laptops.page') }}" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-laptop icon-default"></i>
                        <i class="fas fa-arrow-right icon-hover"></i>
                    </div>
                    <div class="category-name">Laptop</div>
                </a>

                <a href="{{ route('clothes.page') }}" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-tshirt icon-default"></i>
                        <i class="fas fa-arrow-right icon-hover"></i>
                    </div>
                    <div class="category-name">Thời Trang</div>
                </a>

                <a href="{{ route('cars.page') }}" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-car icon-default"></i>
                        <i class="fas fa-arrow-right icon-hover"></i>
                    </div>
                    <div class="category-name">Phương Tiện</div>
                </a>

            </div>
        </div>
    </section>

    <!-- BRAND / INFO -->
    <section class="brands">
        <div class="container">
            <h2 class="section-title">Vì sao chọn chúng tôi?</h2>

            <div class="brand-slider-container">
                <div class="brand-slider">
                    <div class="brand-item">✔ Sản phẩm chính hãng</div>
                    <div class="brand-item">✔ Giá tốt mỗi ngày</div>
                    <div class="brand-item">✔ Giao hàng nhanh</div>
                    <div class="brand-item">✔ Hỗ trợ 24/7</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ⭐ FEATURED -->
    <section class="home-products">
        <div class="container">
            <div class="section-head keep-right">
                <div class="head-center">
                    <h2 class="section-title">🌟 Sản phẩm nổi bật</h2>
                </div>

                <a class="btn ghost" href="{{ route('products.featured') }}">
                    Xem tất cả →
                </a>
            </div>


            <div class="product-grid-home">
                @forelse($featuredProducts as $p)
                    <a href="{{ route('products.show', $p) }}" class="product-card-home">
                        <div class="thumb">
                            @if($p->image)
                                <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}">
                            @else
                                <div class="no-img">No image</div>
                            @endif
                            <span class="badge badge-featured">Nổi bật</span>
                        </div>

                        <div class="info">
                            <h3 class="name">{{ $p->name }}</h3>
                            <div class="meta">
                                @if(!empty($p->brand))
                                    <span class="chip">{{ $p->brand }}</span>
                                @endif
                                <span class="chip">👁 {{ (int)($p->view_count ?? 0) }}</span>
                            </div>
                            <div class="price">{{ number_format((int)$p->price) }} đ</div>
                        </div>
                    </a>
                @empty
                    <p class="empty">Chưa có sản phẩm nổi bật.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 🔥 HOT -->
    <section class="home-products">
        <div class="container">
            <div class="section-head keep-right">
                <div class="head-center">
                    <h2 class="section-title">🔥 Sản phẩm hot</h2>
                </div>

                <a class="btn ghost" href="{{ route('products.hot') }}">
                    Xem tất cả →
                </a>
            </div>


            <div class="product-grid-home">
                @forelse($hotProducts as $p)
                    <a href="{{ route('products.show', $p) }}" class="product-card-home">
                        <div class="thumb">
                            @if($p->image)
                                <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}">
                            @else
                                <div class="no-img">No image</div>
                            @endif
                            <span class="badge badge-hot">Hot</span>
                        </div>

                        <div class="info">
                            <h3 class="name">{{ $p->name }}</h3>
                            <div class="meta">
                                @if(!empty($p->brand))
                                    <span class="chip">{{ $p->brand }}</span>
                                @endif
                                <span class="chip">👁 {{ (int)($p->view_count ?? 0) }}</span>
                            </div>
                            <div class="price">{{ number_format((int)$p->price) }} đ</div>
                        </div>
                    </a>
                @empty
                    <p class="empty">Chưa có sản phẩm hot.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 🛒 BEST SELLER -->
    <section class="home-products">
        <div class="container">
            <div class="section-head keep-right">
                <div class="head-center">
                    <h2 class="section-title">🛒 Bán chạy nhất</h2>
                </div>

                <a class="btn ghost" href="{{ route('products.best') }}">
                    Xem tất cả →
                </a>
            </div>


            <div class="product-grid-home">
                @forelse($bestSellerProducts as $p)
                    <a href="{{ route('products.show', $p) }}" class="product-card-home">
                        <div class="thumb">
                            @if($p->image)
                                <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}">
                            @else
                                <div class="no-img">No image</div>
                            @endif
                            <span class="badge badge-best">Best</span>
                        </div>

                        <div class="info">
                            <h3 class="name">{{ $p->name }}</h3>
                            <div class="meta">
                                @if(!empty($p->brand))
                                    <span class="chip">{{ $p->brand }}</span>
                                @endif
                                @if(isset($p->total_sold))
                                    <span class="chip">🛒 {{ (int)$p->total_sold }} đã bán</span>
                                @endif
                            </div>
                            <div class="price">{{ number_format((int)$p->price) }} đ</div>
                        </div>
                    </a>
                @empty
                    <p class="empty">Chưa có sản phẩm bán chạy.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
