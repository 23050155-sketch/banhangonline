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
  <div class="card-header">
    <b>Danh sách sản phẩm</b>
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


