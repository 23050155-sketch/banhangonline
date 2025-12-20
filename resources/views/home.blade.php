@extends('layouts.app')

@section('title', 'ĐBDK2T - Trang chủ')

@section('content')
    <!-- HERO -->
    <section class="hero-slider">
    <div class="container">
        <div class="slider-container" id="heroSlider" data-interval="3500">
        <div class="slider">

            <div class="slide active">
            <img src="https://image.viettimes.vn/w800/Uploaded/2025/bqmvlcvo/2023_10_21/capture-7654.png" alt="Điện thoại thông minh" />
            <div class="slide-content">
                <h3>Điện Thoại Thông Minh</h3>
                <p>Mới nhất 2025</p>
                <a href="#" class="btn btn-accent">Khám phá ngay</a>
            </div>
            </div>

            <div class="slide">
            <img src="https://images.pexels.com/photos/18105/pexels-photo.jpg" alt="Giảm giá hot" />
            <div class="slide-content">
                <h3>Sale cuối tuần</h3>
                <p>Giảm tới 30% cho nhiều mẫu</p>
                <a href="#" class="btn btn-accent">Xem ưu đãi</a>
            </div>
            </div>

            <div class="slide">
            <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/e/text_ng_n_2__9_254.png" alt="Hàng mới" />
            <div class="slide-content">
                <h3>Hàng mới về</h3>
                <p>Full box - chính hãng</p>
                <a href="#" class="btn btn-accent">Xem ngay</a>
            </div>
            </div>

            <div class="slide">
            <img src="https://images.unsplash.com/photo-1512499617640-c2f999098c01?auto=format&fit=crop&w=1600&q=80" alt="Trả góp" />
            <div class="slide-content">
                <h3>Trả góp 0%</h3>
                <p>Thủ tục nhanh, duyệt lẹ</p>
                <a href="#" class="btn btn-accent">Tìm hiểu</a>
            </div>
            </div>

        </div>

        <button class="slider-btn prev-btn" type="button" aria-label="Previous">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slider-btn next-btn" type="button" aria-label="Next">
            <i class="fas fa-chevron-right"></i>
        </button>

        <div class="slider-dots">
            <span class="dot active" data-index="0"></span>
            <span class="dot" data-index="1"></span>
            <span class="dot" data-index="2"></span>
            <span class="dot" data-index="3"></span>
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
@section('scripts')
<script>
(() => {
  const root = document.getElementById('heroSlider');
  if (!root) return;

  const slides = Array.from(root.querySelectorAll('.slide'));
  const dots = Array.from(root.querySelectorAll('.dot'));
  const prevBtn = root.querySelector('.prev-btn');
  const nextBtn = root.querySelector('.next-btn');

  if (slides.length <= 1) return;

  let index = slides.findIndex(s => s.classList.contains('active'));
  if (index < 0) index = 0;

  const intervalMs = parseInt(root.dataset.interval || '3500', 10);
  let timer = null;

  const show = (i) => {
    slides[index].classList.remove('active');
    dots[index]?.classList.remove('active');

    index = (i + slides.length) % slides.length;

    slides[index].classList.add('active');
    dots[index]?.classList.add('active');
  };

  const next = () => show(index + 1);
  const prev = () => show(index - 1);

  const start = () => {
    stop();
    timer = setInterval(next, intervalMs);
  };

  const stop = () => {
    if (timer) clearInterval(timer);
    timer = null;
  };

  prevBtn?.addEventListener('click', () => { prev(); start(); });
  nextBtn?.addEventListener('click', () => { next(); start(); });

  dots.forEach(d => {
    d.addEventListener('click', () => {
      const i = parseInt(d.dataset.index || '0', 10);
      show(i);
      start();
    });
  });

  root.addEventListener('mouseenter', stop);
  root.addEventListener('mouseleave', start);

  start();
})();
</script>
@endsection