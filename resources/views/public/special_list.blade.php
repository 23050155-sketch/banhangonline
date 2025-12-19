@extends('layouts.app')

@section('title', $title)

@section('content')
<section class="home-products" style="margin-top:24px;">
    <div class="container">

        <div class="section-head">
            <div>
                <h2 class="section-title">{{ $title }}</h2>
                <p class="section-sub">{{ $subtitle }}</p>
            </div>

            <a class="btn ghost" href="{{ route('home') }}">← Về trang chủ</a>
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

                            @if(isset($p->total_sold))
                                <span class="chip">🛒 {{ (int)$p->total_sold }} đã bán</span>
                            @endif
                        </div>

                        <div class="price">{{ number_format((int)$p->price) }} đ</div>
                    </div>
                </a>
            @empty
                <p class="empty">Chưa có sản phẩm.</p>
            @endforelse
        </div>

        <div style="margin-top:16px">
            {{ $products->links() }}
        </div>

    </div>
</section>
@endsection
