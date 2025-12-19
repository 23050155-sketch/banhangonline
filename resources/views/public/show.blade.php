@extends('layouts.app')

@section('title', $product->name)

@section('content')
<section class="product-detail">
    <div class="container">

        {{-- Breadcrumb --}}
        <div class="pd-breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span>/</span>
            @if($product->category)
                <span>{{ $product->category->name }}</span>
            @endif
            <span>/</span>
            <strong>{{ $product->name }}</strong>
        </div>

        <div class="pd-grid">
            {{-- LEFT --}}
            <div class="pd-left">
                <div class="pd-image">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div class="pd-image-empty">No image</div>
                    @endif
                </div>

                <div class="pd-mini">
                    <div class="pd-chip">👁 {{ (int)($product->view_count ?? 0) }} lượt xem</div>

                    @if((int)($avgRating ?? 0) > 0)
                        <div class="pd-chip">⭐ {{ $avgRating }}/5 ({{ $totalReviews }} đánh giá)</div>
                    @else
                        <div class="pd-chip">⭐ Chưa có đánh giá</div>
                    @endif

                    @if((int)$product->is_featured === 1)
                        <div class="pd-chip pd-chip-featured">✨ Nổi bật</div>
                    @endif
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="pd-right">
                <h1 class="pd-title">{{ $product->name }}</h1>

                <div class="pd-meta">
                    @if($product->brand)
                        <div><span>Thương hiệu:</span> <strong>{{ $product->brand }}</strong></div>
                    @endif

                    <div>
                        <span>Tình trạng:</span>
                        @if((int)$product->stock > 0)
                            <strong class="text-ok">Còn hàng ({{ (int)$product->stock }})</strong>
                        @else
                            <strong class="text-bad">Hết hàng</strong>
                        @endif
                    </div>
                </div>

                <div class="pd-pricebox">
                    <div class="pd-price">{{ number_format($product->price) }} đ</div>

                    @if(!empty($product->compare_price) && (int)$product->compare_price > (int)$product->price)
                        <div class="pd-compare">{{ number_format($product->compare_price) }} đ</div>
                        @php
                            $discount = round((1 - ($product->price / $product->compare_price)) * 100);
                        @endphp
                        <div class="pd-discount">-{{ $discount }}%</div>
                    @endif
                </div>

                {{-- Add to cart --}}
                <form class="pd-actions" method="POST" action="{{ route('cart.add', $product) }}">
                    @csrf

                    <div class="pd-qty">
                        <button type="button" class="qty-btn" data-qty="-1">-</button>
                        <input type="number" name="quantity" value="1" min="1" max="{{ max(1, (int)$product->stock) }}">
                        <button type="button" class="qty-btn" data-qty="+1">+</button>
                    </div>

                    <button type="submit" class="btn btn-accent" {{ (int)$product->stock <= 0 ? 'disabled' : '' }}>
                        Thêm vào giỏ
                    </button>
                </form>

                {{-- Mô tả --}}
                <div class="pd-desc">
                    <h3>Mô tả sản phẩm</h3>

                    <div class="pd-desc-text scroll">
                        {!! nl2br(e($product->description ?? 'Chưa có mô tả cho sản phẩm này.')) !!}
                    </div>

                </div>

            </div>
        </div>

        {{-- REVIEWS --}}
        <div class="pd-reviews">
            <div class="pd-reviews-head">
                <h2>Đánh giá ({{ (int)$totalReviews }})</h2>
                @if((float)$avgRating > 0)
                    <div class="pd-rating">⭐ {{ $avgRating }}/5</div>
                @endif
            </div>

            @if($product->reviews && $product->reviews->count())
                <div class="pd-review-list">
                    @foreach($product->reviews as $rv)
                        <div class="pd-review">
                            <div class="pd-review-top">
                                <strong>{{ $rv->user->name ?? 'Người dùng' }}</strong>
                                <span class="pd-stars">
                                    @for($i=1; $i<=5; $i++)
                                        {!! $i <= (int)$rv->rating ? '⭐' : '☆' !!}
                                    @endfor
                                </span>
                                <span class="pd-date">{{ optional($rv->created_at)->format('d/m/Y') }}</span>
                            </div>

                            @if(!empty($rv->comment))
                                <div class="pd-review-comment">{{ $rv->comment }}</div>
                            @else
                                <div class="pd-review-comment pd-muted">Không có bình luận.</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="pd-empty">Chưa có đánh giá nào cho sản phẩm này.</div>
            @endif
        </div>

        @if(session('error'))
            <div class="pd-alert pd-alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="pd-alert pd-alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORM ĐÁNH GIÁ --}}
        <div class="pd-review-form">
            @guest
                <div class="pd-empty">
                    Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để đánh giá.
                </div>
            @else
                <form method="POST" action="{{ route('reviews.store', $product) }}">
                    @csrf

                    <div class="rf-row">
                        <label>Chọn sao:</label>
                        <select name="rating" required>
                            <option value="">-- chọn --</option>
                            <option value="5">5 ⭐⭐⭐⭐⭐</option>
                            <option value="4">4 ⭐⭐⭐⭐</option>
                            <option value="3">3 ⭐⭐⭐</option>
                            <option value="2">2 ⭐⭐</option>
                            <option value="1">1 ⭐</option>
                        </select>
                    </div>

                    <div class="rf-row">
                        <label>Bình luận:</label>
                        <textarea name="comment" rows="3" placeholder="Viết cảm nhận..."></textarea>
                    </div>

                    <button class="btn btn-accent" type="submit">Gửi đánh giá</button>
                </form>
            @endguest
        </div>


        {{-- SẢN PHẨM LIÊN QUAN --}}
        @if($relatedProducts->count())
        <section class="related-section">
            <div class="container">
                <h2 class="section-title">
                    <span>Sản phẩm liên quan</span>
                </h2>

                <div class="related-grid">
                    @foreach($relatedProducts as $item)
                        <a href="{{ route('products.show', $item) }}" class="related-card">

                            <div class="related-image">
                                <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}">
                                <span class="related-badge">HOT</span>
                            </div>

                            <div class="related-info">
                                <h3 class="related-name">{{ $item->name }}</h3>

                                <div class="related-price">
                                    {{ number_format($item->price) }} đ
                                </div>

                                <div class="related-meta">
                                    👁 {{ $item->view_count }} lượt xem
                                </div>
                            </div>

                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif





    </div>
</section>

{{-- nhỏ gọn: JS tăng/giảm số lượng --}}
<script>
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.parentElement.querySelector('input[name="quantity"]');
            const max = parseInt(input.getAttribute('max') || '999', 10);
            const min = parseInt(input.getAttribute('min') || '1', 10);
            const val = parseInt(input.value || '1', 10);
            const delta = btn.dataset.qty === '+1' ? 1 : -1;
            let next = val + delta;
            if (next < min) next = min;
            if (next > max) next = max;
            input.value = next;
        });
    });
</script>
@endsection
