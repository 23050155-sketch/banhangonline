@extends('layouts.app')

@section('title', 'Tìm kiếm sản phẩm')

@section('content')
<section class="home-products" style="margin-top:24px;">
  <div class="container">

    {{-- HEADER trang search: luôn hiện --}}
    <div class="search-page-head">
      <div class="sp-left">
        <h2 class="sp-title">Kết quả tìm kiếm</h2>

        <p class="sp-sub">
          @php
            $qText = trim((string)($q ?? request('q', '')));
            $catId = request('category');
            $catName = '';

            if (!empty($catId) && isset($categories)) {
              $found = $categories->firstWhere('id', (int)$catId);
              $catName = $found?->name ?? '';
            }
          @endphp

          @if($qText === '' && empty($catId))
            Nhập từ khóa hoặc chọn danh mục để tìm sản phẩm.
          @else
            Đang lọc:
            @if($qText !== '')
              <b>Từ khóa:</b> “{{ $qText }}”
            @endif
            @if(!empty($catId))
              <span style="opacity:.7">•</span>
              <b>Danh mục:</b> {{ $catName ?: 'Đã chọn' }}
            @endif
          @endif
        </p>
     

    

    {{-- RESULTS --}}
    <div class="product-grid-home">
      @forelse($products as $p)
        <a href="{{ route('products.show', $p) }}" class="product-card-home">
          <div class="thumb">
            @if($p->image)
              <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" loading="lazy">
            @else
              <div class="no-img">No image</div>
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
        <p class="empty">Không có sản phẩm phù hợp.</p>
      @endforelse
    </div>

    <div style="margin-top:16px">
      {{ $products->links() }}
    </div>

  </div>
</section>
@endsection

@push('head')
<style>
  /* ===== Search page head ===== */
  .search-page-head{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:12px;
    margin-bottom:14px;
  }
  .sp-title{
    margin:0;
    font-size:24px;
    font-weight:800;
  }
  .sp-sub{
    margin:6px 0 0;
    color:rgba(0,0,0,.65);
    font-size:14px;
  }

  /* ===== Filter bar ===== */
  .search-filter-bar{
    display:grid;
    grid-template-columns: 1fr 260px auto;
    gap:12px;
    align-items:center;
    margin: 12px 0 18px;
  }
  .sf-input{
    width:100%;
    height:44px;
    border-radius:14px;
    border:1px solid rgba(0,0,0,.15);
    padding:0 14px;
    outline:none;
    background:#fff;
  }
  .sf-btn{
    height:44px;
    border-radius:14px;
    border:none;
    padding:0 16px;
    cursor:pointer;
  }

  @media (max-width: 768px){
    .search-page-head{
      flex-direction:column;
      align-items:flex-start;
    }
    .search-filter-bar{
      grid-template-columns:1fr;
    }
  }
</style>
@endpush
