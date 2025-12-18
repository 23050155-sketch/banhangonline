@extends('layouts.admin')
@section('title','Admin - Sản phẩm')
@section('page_title','Quản lý sản phẩm')

@section('page_actions')
<a class="btn" href="javascript:void(0)"
    onclick="openModal('{{ route('admin.products.create') }}','Thêm sản phẩm')">
    <i class="fa-solid fa-plus"></i> Thêm
</a>
@endsection

@section('content')
<div class="card">
  <div class="card-header" style="gap:12px">
  <b>Danh sách sản phẩm</b>

  <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
    <input class="input" name="q" value="{{ $q }}" placeholder="Tìm theo tên..." style="width:220px">

    <select class="input" name="category_id" style="width:220px">
      <option value="">-- Tất cả danh mục --</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected((string)$categoryId === (string)$c->id)>
          {{ $c->name }}
        </option>
      @endforeach
    </select>

    <button class="btn" type="submit"><i class="fa-solid fa-filter"></i> Lọc</button>
    <a class="btn btn-outline" href="{{ route('admin.products.index') }}">Reset</a>
  </form>
</div>


  <div class="card-body table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th><th>Tên</th><th>Giá</th><th>Tồn</th><th>Nổi bật</th><th>Trạng thái</th><th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $p)
          <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->name }}</td>
            <td>{{ number_format($p->price) }} đ</td>
            <td>{{ $p->stock }}</td>
            <td>{{ $p->is_featured ? '✅' : '—' }}</td>
            <td>{{ $p->status ? 'Hiện' : 'Ẩn' }}</td>
            <td>
            <a class="btn btn-outline" href="javascript:void(0)"
                onclick="openModal('{{ route('admin.products.edit',$p->id) }}','Sửa sản phẩm')">
                Sửa
            </a>

            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal" id="productModal">
  <div class="modal-backdrop"></div>
  <div class="modal-box">
    <div class="modal-header">
      <h3 id="modalTitle">---</h3>
      <button class="icon-btn" onclick="closeModal()">✖</button>
    </div>
    <div class="modal-body" id="modalContent">
      Loading...
    </div>
  </div>
</div>


@endsection


