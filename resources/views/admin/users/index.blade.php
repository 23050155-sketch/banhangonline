@extends('layouts.admin')
@section('title','Admin - Users')
@section('page_title','Quản lý Users')

@section('page_actions')
  <a class="btn" href="javascript:void(0)"
     onclick="openModal('{{ route('admin.users.create') }}','Thêm user')">
    <i class="fa-solid fa-plus"></i> Thêm
  </a>
@endsection

@section('content')

<div class="card" style="margin-bottom:12px">
  <div class="card-body" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
    <form method="GET" action="{{ route('admin.users.index') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
      <input class="input" name="q" value="{{ $q ?? '' }}" placeholder="Tìm name/email" style="max-width:320px">
      <button class="btn btn-outline" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Tìm</button>
      @if(!empty($q))
        <a class="btn btn-outline" href="{{ route('admin.users.index') }}">Xóa lọc</a>
      @endif
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <b>Danh sách Users</b>
  </div>

  <div class="card-body table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
          <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->role }}</td>
            <td>{{ $u->status ? 'Active' : 'Blocked' }}</td>
            <td style="display:flex;gap:8px;flex-wrap:wrap">
              <a class="btn btn-outline" href="javascript:void(0)"
                 onclick="openModal('{{ route('admin.users.edit', $u->id) }}','Sửa user')">
                Sửa
              </a>

              <form action="{{ route('admin.users.toggleStatus', $u->id) }}" method="POST"
                    onsubmit="return confirm('Đổi trạng thái user?')">
                @csrf
                @method('PATCH')
                <button class="btn btn-danger" type="submit">
                  {{ $u->status ? 'Khóa' : 'Mở' }}
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" style="color:var(--muted)">Chưa có user nào.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="card-body" style="border-top:1px solid var(--line)">
    {{ $users->links() }}
  </div>
</div>

{{-- Modal dùng chung --}}
<div class="modal" id="productModal">
  <div class="modal-backdrop"></div>
  <div class="modal-box">
    <div class="modal-header">
      <h3 id="modalTitle">---</h3>
      <button class="icon-btn" type="button" onclick="closeModal()">✖</button>
    </div>
    <div class="modal-body" id="modalContent">Loading...</div>
  </div>
</div>

@endsection
