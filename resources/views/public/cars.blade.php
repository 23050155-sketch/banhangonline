@extends('layouts.app')

@section('title', 'Ô Tô')

@section('content')

<section class="hero-slider">
    <div class="container">
        <h2 class="section-title" style="margin:18px 0;">Ô Tô</h2>
    </div>
</section>

<section class="products" style="margin-top:24px;">
    <div class="container">

        {{-- MODE B: /cars?brand=... --}}
        @if(request()->filled('brand') && isset($products))
            <div class="brand-head">
                <h2 class="section-title">{{ $category->name }} / {{ request('brand') }}</h2>

                <a class="brand-viewall" href="{{ route('cars.page') }}">
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

        {{-- MODE A: /cars (group brand) --}}
        @else
            <h2 class="section-title">{{ $category->name }}</h2>

            @foreach($productsByBrand as $brand => $items)
                <div class="brand-section">
                    <div class="brand-head">
                        <h3 class="brand-title">{{ $brand }}</h3>

                        <a class="brand-viewall"
                           href="{{ route('cars.page', ['brand' => $brand]) }}">
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
