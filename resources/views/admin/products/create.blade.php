<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Thêm sản phẩm</title></head>
<body>
<h1>Thêm sản phẩm</h1>

@if($errors->any())
<ul style="color:red">
@foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
</ul>
@endif

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">

    @csrf

    <p>
        <label>Danh mục</label><br>
        <select name="category_id">
            @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
    </p>
    <p><label class="form-label">Thương hiệu</label><br>
        <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" 
        placeholder="VD: Apple, Samsung, Xiaomi">
    </p>
    <p><label>Tên sản phẩm</label><br><input name="name" value="{{ old('name') }}"></p>
    <p><label>Giá</label><br><input name="price" value="{{ old('price', 0) }}"></p>
    <p><label>Giá gốc (tuỳ chọn)</label><br><input name="compare_price" value="{{ old('compare_price') }}"></p>
    <p><label>Tồn kho</label><br><input name="stock" value="{{ old('stock', 0) }}"></p>
    <p><label>Mô tả</label><br><textarea name="description">{{ old('description') }}</textarea></p>

    <p><label>Ảnh</label><br><input type="file" name="image"></p>

    <p>
        <label><input type="checkbox" name="status" value="1" checked> Đang bán</label>
        <label><input type="checkbox" name="is_featured" value="1"> Nổi bật</label>
    </p>

    <button type="submit">Lưu</button>
    <a href="{{ route('admin.products.index') }}">Quay lại</a>
</form>
</body>
</html>
