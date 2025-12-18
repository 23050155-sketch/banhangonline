@if ($errors->any())
  <div class="alert error">
    @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
    @endforeach
  </div>
@endif

<form method="POST" action="{{ route('admin.coupons.store') }}">
  @csrf

  <div class="grid-2">
    <div>
      <label class="form-label">Mã coupon</label>
      <input class="input" name="code" value="{{ old('code') }}" required placeholder="VD: SALE10, FREESHIP...">
    </div>

    <div>
      <label class="form-label">Loại giảm</label>
      <select class="input" name="type">
        <option value="percent" @selected(old('type')==='percent')>Giảm %</option>
        <option value="fixed" @selected(old('type')==='fixed')>Giảm tiền</option>
      </select>
    </div>
  </div>

  <div class="grid-2" style="margin-top:12px">
    <div>
      <label class="form-label">Giá trị</label>
      <input class="input" type="number" name="value" value="{{ old('value') }}" required>
    </div>

    <div>
      <label class="form-label">Đơn tối thiểu</label>
      <input class="input" type="number" name="min_order" value="{{ old('min_order') }}" placeholder="0 nếu không giới hạn">
    </div>
  </div>

  <div class="grid-2" style="margin-top:12px">
    <div>
      <label class="form-label">Số lượt dùng</label>
      <input class="input" type="number" name="max_uses" value="{{ old('max_uses') }}" placeholder="Để trống = không giới hạn">
    </div>

    <div style="display:flex;gap:10px;align-items:center;padding-top:26px">
      <label style="display:flex;gap:8px;align-items:center;color:rgba(255,255,255,.8)">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
        Kích hoạt
      </label>
    </div>
  </div>

  <div class="grid-2" style="margin-top:12px">
    <div>
      <label class="form-label">Bắt đầu</label>
      <input class="input" type="date" name="starts_at" value="{{ old('starts_at') }}" required>
    </div>

    <div>
      <label class="form-label">Kết thúc</label>
      <input class="input" type="date" name="ends_at" value="{{ old('ends_at') }}">
    </div>
  </div>

  <div style="margin-top:14px;display:flex;gap:10px;justify-content:flex-end">
    <button class="btn" type="submit">Lưu coupon</button>
    <button class="btn btn-outline" type="button" onclick="closeModal()">Hủy</button>
  </div>
</form>
