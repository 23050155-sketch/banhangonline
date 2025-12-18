@if($errors->any())
  <div class="alert error">
    @foreach($errors->all() as $e)
      <div>{{ $e }}</div>
    @endforeach
  </div>
@endif

<form method="POST" action="{{ route('admin.categories.store') }}">
  @csrf

  <div>
    <label class="form-label">Tên danh mục</label>
    <input class="input" type="text" name="name" value="{{ old('name') }}" placeholder="VD: Laptop, Điện thoại...">
  </div>

  <div style="margin-top:12px">
    <label style="display:flex;gap:10px;align-items:center">
      <input type="checkbox" name="status" value="1" checked>
      <span>Hiển thị</span>
    </label>
  </div>

  <div style="margin-top:14px;display:flex;gap:10px;justify-content:flex-end">
    <button class="btn" type="submit">Lưu</button>
    <button class="btn btn-outline" type="button" onclick="closeModal()">Hủy</button>
  </div>
</form>
