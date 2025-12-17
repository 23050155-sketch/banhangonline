<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>{{ $product->name }}</title>
</head>
<body>

<p><a href="{{ route('products.index') }}">← Quay lại</a></p>

<h1>{{ $product->name }}</h1>

<p>Giá: <b>{{ number_format($product->price) }} đ</b></p>
<p>Tồn: <b>{{ $product->stock }}</b></p>

@if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif
@if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif
@if($errors->any())
  <ul style="color:red">
    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
  </ul>
@endif

<hr>

<h3>Đánh giá ({{ $product->reviews->count() }})</h3>

@php $avg = $product->avgRating(); @endphp
<p>⭐ Trung bình: <b>{{ $avg ? number_format($avg, 1) : '0.0' }}/5</b></p>

{{-- List reviews --}}
@forelse($product->reviews as $r)
  <div style="border-bottom:1px solid #ddd; padding:8px 0">
    <b>{{ $r->user->name ?? 'User' }}</b> — {{ $r->rating }} ⭐
    @if($r->comment)
      <p>{{ $r->comment }}</p>
    @endif
    <small>{{ $r->created_at?->format('d/m/Y H:i') }}</small>
  </div>
@empty
  <p>Chưa có đánh giá nào.</p>
@endforelse

<hr>

<h3>Viết đánh giá</h3>

@auth
<form method="POST" action="{{ route('reviews.store', $product) }}">
  @csrf

  <p>
    Số sao:
    <select name="rating" required>
      @for($i=5;$i>=1;$i--)
        <option value="{{ $i }}">{{ $i }} ⭐</option>
      @endfor
    </select>
  </p>

  <p>
    Nhận xét:
    <br>
    <textarea name="comment" rows="4" cols="60" maxlength="1000"></textarea>
  </p>

  <button type="submit">Gửi đánh giá</button>
</form>
@else
  <p>Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để đánh giá.</p>
@endauth

</body>
</html>
