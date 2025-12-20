@extends('layouts.app')

@section('title', 'Laptop')

@section('content')

{{-- ===== Hero / banner ===== --}}
<section class="hero-slider">
  <div class="container">
    <div class="slider-container" id="heroSlider" data-interval="3500">
      <div class="slider">

        <div class="slide active">
          <img src="https://images.pexels.com/photos/18105/pexels-photo.jpg" alt="Điện thoại thông minh" />
          <div class="slide-content">
            <h3>Điện Thoại Thông Minh</h3>
            <p>Mới nhất 2025</p>
            <a href="#" class="btn btn-accent">Khám phá ngay</a>
          </div>
        </div>

        <div class="slide">
          <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/e/text_ng_n_5__9_286.png" alt="Giảm giá hot" />
          <div class="slide-content">
            <h3>Sale cuối tuần</h3>
            <p>Giảm tới 30% cho nhiều mẫu</p>
            <a href="#" class="btn btn-accent">Xem ưu đãi</a>
          </div>
        </div>

        <div class="slide">
          <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/e/text_ng_n_15_15_1.png" alt="Hàng mới" />
          <div class="slide-content">
            <h3>Hàng mới về</h3>
            <p>Full box - chính hãng</p>
            <a href="#" class="btn btn-accent">Xem ngay</a>
          </div>
        </div>

        <div class="slide">
          <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/e/text_ng_n_7__4_146.png" alt="Trả góp" />
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


{{-- ===== PRODUCTS ===== --}}
<section class="home-products" style="margin-top:24px;">
    <div class="container">

        {{-- MODE B: /laptops?brand=Apple --}}
        @if(request()->filled('brand') && isset($products))
            <div class="section-head keep-right">
                <div class="head-center">
                    <h2 class="section-title">{{ $category->name }} / {{ request('brand') }}</h2>
                    <p class="section-sub">Đang lọc theo thương hiệu</p>
                </div>

                <a class="btn ghost" href="{{ route('laptops.page') }}">
                    ← Quay về tất cả
                </a>
            </div>

            <div class="product-grid-home">
                @forelse($products as $p)
                    <a href="{{ route('products.show', $p) }}" class="product-card-home">
                        <div class="thumb">
                            @if($p->image)
                                <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" loading="lazy">
                            @else
                                <div class="no-img">No image</div>
                            @endif

                            @if((int)($p->is_featured ?? 0) === 1)
                                <span class="badge badge-featured">Nổi bật</span>
                            @endif
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
                    <p class="empty">Chưa có sản phẩm nào.</p>
                @endforelse
            </div>

            <div style="margin-top:16px">
                {{ $products->links() }}
            </div>

        {{-- MODE A: /laptops (group theo brand) --}}
        @else
            <div class="section-head keep-right">
                <div class="head-center">
                    <h2 class="section-title">{{ $category->name }}</h2>
                    <p class="section-sub">Chọn thương hiệu để xem nhanh</p>
                </div>
            </div>

            @foreach($productsByBrand as $brand => $items)
                <div class="brand-section" style="margin-top:16px;">
                    <div class="section-head">
                        <div>
                            <h3 class="section-title" style="font-size:18px;margin:0;">{{ $brand }}</h3>
                        </div>

                        <a class="btn ghost"
                           href="{{ route('laptops.page', ['brand' => $brand]) }}">
                            Xem tất cả ({{ $brandCounts[$brand] ?? $items->count() }})
                        </a>
                    </div>

                    <div class="product-grid-home">
                        @foreach($items->take(8) as $p)
                            <a href="{{ route('products.show', $p) }}" class="product-card-home">
                                <div class="thumb">
                                    @if($p->image)
                                        <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" loading="lazy">
                                    @else
                                        <div class="no-img">No image</div>
                                    @endif

                                    @if((int)($p->is_featured ?? 0) === 1)
                                        <span class="badge badge-featured">Nổi bật</span>
                                    @endif
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
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif

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