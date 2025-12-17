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
<section class="products" style="margin-top:24px;">
    <div class="container">

        {{-- =========================
           MODE B: /phones?brand=Apple
           ========================= --}}
        @if(request()->filled('brand'))
            <div class="brand-head">
                <h2 class="section-title">{{ $category->name }} / {{ request('brand') }}</h2>

                <a class="brand-viewall" href="{{ route('phones.page') }}">
                    ← Quay về tất cả thương hiệu
                </a>
            </div>

            <div class="product-grid">
                @forelse($products as $p)
                    <a class="product-card" href="{{ route('products.show', $p->slug) }}">
                        <div class="product-thumb">
                            @if($p->image)
                                <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" loading="lazy">
                            @else
                                <div class="product-thumb--empty">No image</div>
                            @endif
                        </div>

                        <div class="product-info">
                            <div class="product-name">{{ $p->name }}</div>
                            @if($p->brand)
                                <div class="product-brand">{{ $p->brand }}</div>
                            @endif
                            <div class="product-price">{{ number_format($p->price) }} đ</div>
                        </div>
                    </a>
                @empty
                    <p>Chưa có sản phẩm nào.</p>
                @endforelse
            </div>

            <div style="margin-top:16px">
                {{ $products->links() }}
            </div>

        @else
            <h2 class="section-title">{{ $category->name }}</h2>

            @foreach($productsByBrand as $brand => $items)
                <div class="brand-section">
                    <div class="brand-head">
                        <h3 class="brand-title">{{ $brand }}</h3>

                        <a class="brand-viewall"
                           href="{{ route('phones.page', ['brand' => $brand]) }}">
                            Xem tất cả ({{ $brandCounts[$brand] ?? $items->count() }})
                        </a>
                    </div>

                    <div class="product-grid">
                        @foreach($items->take(5) as $p)
                            <a class="product-card" href="{{ route('products.show', $p->slug) }}">
                                <div class="product-thumb">
                                    @if($p->image)
                                        <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" loading="lazy">
                                    @else
                                        <div class="product-thumb--empty">No image</div>
                                    @endif
                                </div>

                                <div class="product-info">
                                    <div class="product-name">{{ $p->name }}</div>
                                    @if($p->brand)
                                        <div class="product-brand">{{ $p->brand }}</div>
                                    @endif
                                    <div class="product-price">{{ number_format($p->price) }} đ</div>
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
