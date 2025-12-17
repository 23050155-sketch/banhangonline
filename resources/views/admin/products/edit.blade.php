<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Sửa sản phẩm</title></head>
<body>
<h1>Sửa sản phẩm</h1>

@if($errors->any())
<ul style="color:red">
@foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
</ul>
@endif

<form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <p>
        <label>Danh mục</label><br>
        <select name="category_id">
            @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ $product->category_id == $c->id ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </p>

    <div class="mb-3">
        <label class="form-label">Thương hiệu</label><br>
        <input type="text" name="brand" class="form-control"
            value="{{ old('brand', $product->brand) }}"
            placeholder="VD: Apple, Samsung, Xiaomi">
    </div>

    <p><label>Tên sản phẩm</label><br><input name="name" value="{{ old('name', $product->name) }}"></p>
    <p><label>Giá</label><br><input name="price" value="{{ old('price', $product->price) }}"></p>
    <p><label>Giá gốc (tuỳ chọn)</label><br><input name="compare_price" value="{{ old('compare_price', $product->compare_price) }}"></p>
    <p><label>Tồn kho</label><br><input name="stock" value="{{ old('stock', $product->stock) }}"></p>
    <p><label>Mô tả</label><br><textarea name="description">{{ old('description', $product->description) }}</textarea></p>

    <p>
        <label>Ảnh hiện tại:</label><br>
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" width="120">
        @else
            <i>Chưa có ảnh</i>
        @endif
    </p>

    <p><label>Đổi ảnh</label><br><input type="file" name="image"></p>

    <p>
        <label><input type="checkbox" name="status" value="1" {{ $product->status ? 'checked' : '' }}> Đang bán</label>
        <label><input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}> Nổi bật</label>
    </p>

    <button type="submit">Cập nhật</button>
    <a href="{{ route('admin.products.index') }}">Quay lại</a>
</form>
</body>
</html>
