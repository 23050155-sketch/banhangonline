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
                    <div class="category-name">Quần áo</div>
                </a>

                <a href="{{ route('cars.page') }}" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-car icon-default"></i>
                        <i class="fas fa-arrow-right icon-hover"></i>
                    </div>
                    <div class="category-name">Xe hơi</div>
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
@endsection
