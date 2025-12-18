@if($errors->any())
  <div class="alert error">
    @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
  </div>
@endif

<form method="POST" action="{{ route('admin.users.store') }}">
  @csrf

  <div class="grid-2">
    <div>
      <label class="form-label">Name</label>
      <input class="input" name="name" value="{{ old('name') }}">
    </div>

    <div>
      <label class="form-label">Email</label>
      <input class="input" name="email" type="email" value="{{ old('email') }}">
    </div>
  </div>

  <div style="margin-top:12px">
    <label class="form-label">Password</label>
    <input class="input" name="password" type="password" autocomplete="new-password">
  </div>

  <div class="grid-2" style="margin-top:12px">
    <div>
      <label class="form-label">Role</label>
      <select class="input" name="role">
        <option value="customer" {{ old('role')==='customer' ? 'selected' : '' }}>customer</option>
        <option value="admin" {{ old('role')==='admin' ? 'selected' : '' }}>admin</option>
      </select>
    </div>

    <div>
      <label class="form-label">Status</label>
      <select class="input" name="status">
        <option value="1" {{ old('status','1')=='1' ? 'selected' : '' }}>active</option>
        <option value="0" {{ old('status')=='0' ? 'selected' : '' }}>blocked</option>
      </select>
    </div>
  </div>

  <div class="grid-2" style="margin-top:12px">
    <div>
      <label class="form-label">Phone</label>
      <input class="input" name="phone" value="{{ old('phone') }}">
    </div>

    <div>
      <label class="form-label">Address</label>
      <input class="input" name="address" value="{{ old('address') }}">
    </div>
  </div>

  <div style="margin-top:14px;display:flex;gap:10px;justify-content:flex-end">
    <button class="btn" type="submit">Lưu</button>
    <button class="btn btn-outline" type="button" onclick="closeModal()">Hủy</button>
  </div>
</form>
