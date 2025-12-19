@extends('layouts.app')

@section('title', 'Điện Thoại')

@section('content')

{{-- ===== Hero Slider ===== --}}
<section class="hero-slider">
    <div class="container">
        <div class="slider-container">
            <div class="slider">
                <div class="slide active">
                    <img src="https://image.viettimes.vn/w800/Uploaded/2025/bqmvlcvo/2023_10_21/capture-7654.png" alt="Điện thoại thông minh" />
                    <div class="slide-content">
                        <h3>Điện Thoại Thông Minh</h3>
                        <p>Mới nhất 2025</p>
                        <a href="#" class="btn btn-accent">Khám phá ngay</a>
                    </div>
                </div>
            </div>
            <button class="slider-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
            <button class="slider-btn next-btn"><i class="fas fa-chevron-right"></i></button>
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

        {{-- =========================
           MODE B: /phones?brand=Apple
           ========================= --}}
        @if(request()->filled('brand'))
            <div class="section-head keep-right">
                <div class="head-center">
                    <h2 class="section-title">{{ $category->name }} / {{ request('brand') }}</h2>
                    <p class="section-sub">Đang lọc theo thương hiệu</p>
                </div>

                <a class="btn ghost" href="{{ route('phones.page') }}">
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
                           href="{{ route('phones.page', ['brand' => $brand]) }}">
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
