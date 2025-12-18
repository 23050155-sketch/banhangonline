{{-- resources/views/admin/products/edit.blade.php --}}
@if($errors->any())
  <div class="alert error" style="margin-bottom:12px">
    <ul style="margin:0; padding-left:18px">
      @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div style="display:grid; gap:10px">
    <div>
      <label class="form-label">Danh mục</label>
      <select name="category_id" class="input">
        @foreach($categories as $c)
          <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>
            {{ $c->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="form-label">Thương hiệu</label>
      <input type="text" name="brand" class="input"
             value="{{ old('brand', $product->brand) }}"
             placeholder="VD: Apple, Samsung, Xiaomi">
    </div>

    <div>
      <label class="form-label">Tên sản phẩm</label>
      <input name="name" class="input" value="{{ old('name', $product->name) }}">
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px">
      <div>
        <label class="form-label">Giá</label>
        <input name="price" class="input" value="{{ old('price', $product->price) }}">
      </div>
      <div>
        <label class="form-label">Giá gốc (tuỳ chọn)</label>
        <input name="compare_price" class="input" value="{{ old('compare_price', $product->compare_price) }}">
      </div>
    </div>

    <div>
      <label class="form-label">Tồn kho</label>
      <input name="stock" class="input" value="{{ old('stock', $product->stock) }}">
    </div>

    <div>
      <label class="form-label">Mô tả</label>
      <textarea name="description" class="input" rows="4">{{ old('description', $product->description) }}</textarea>
    </div>

    <div>
      <label class="form-label">Ảnh hiện tại</label>
      <div style="margin-top:6px">
        @if($product->image)
          <img src="{{ asset('storage/'.$product->image) }}" width="120" style="border-radius:10px">
        @else
          <i>Chưa có ảnh</i>
        @endif
      </div>
    </div>

    <div>
      <label class="form-label">Đổi ảnh</label>
      <input type="file" name="image" class="input">
    </div>

    <div style="display:flex; gap:14px; align-items:center; flex-wrap:wrap">
      <label style="display:flex; gap:8px; align-items:center">
        <input type="checkbox" name="status" value="1" @checked(old('status', $product->status))>
        Đang bán
      </label>

      <label style="display:flex; gap:8px; align-items:center">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))>
        Nổi bật
      </label>
    </div>

    <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:6px">
      <button class="btn" type="submit">
        <i class="fa-solid fa-floppy-disk"></i> Cập nhật
      </button>
      <button class="btn btn-outline" type="button" onclick="closeModal()">
        Hủy
      </button>
    </div>
  </div>
</form>
