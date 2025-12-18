@extends('layouts.admin')
@section('title','Admin - Danh mục')
@section('page_title','Quản lý danh mục')

@section('page_actions')
  <a class="btn" href="javascript:void(0)"
     onclick="openModal('{{ route('admin.categories.create') }}','Thêm danh mục')">
    <i class="fa-solid fa-plus"></i> Thêm
  </a>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <b>Danh sách danh mục</b>
  </div>

  <div class="card-body table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tên</th>
          <th>Slug</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        @forelse($categories as $c)
          <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->name }}</td>
            <td>{{ $c->slug }}</td>
            <td>{{ $c->status ? 'Hiện' : 'Ẩn' }}</td>
            <td style="display:flex;gap:8px;flex-wrap:wrap">
              <a class="btn btn-outline" href="javascript:void(0)"
                 onclick="openModal('{{ route('admin.categories.edit',$c->id) }}','Sửa danh mục')">
                Sửa
              </a>

              <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST"
                    onsubmit="return confirm('Xóa danh mục này nha?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Xóa</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" style="color:var(--muted)">Chưa có danh mục nào.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if(method_exists($categories,'links'))
    <div class="card-body" style="border-top:1px solid var(--line)">
      {{ $categories->links() }}
    </div>
  @endif
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
