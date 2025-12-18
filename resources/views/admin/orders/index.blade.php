@extends('layouts.admin')
@section('title','Admin - Đơn hàng')
@section('page_title','Quản lý đơn hàng')

@section('content')
<div class="card">
  <div class="card-header">
    <b>Danh sách đơn hàng</b>
  </div>

  <div class="card-body table-wrap">
    <div class="card-body" style="display:flex; gap:10px; flex-wrap:wrap; align-items:center">
      <form method="GET" action="{{ route('admin.orders.index') }}"
          style="margin-bottom:16px; display:flex; gap:12px; flex-wrap:wrap; align-items:center">
            <input class="input" type="date" name="from_date"
                  value="{{ request('from_date') }}" style="max-width:200px">

            <input class="input" type="date" name="to_date"
                  value="{{ request('to_date') }}" style="max-width:200px">
            <input class="input" type="number" name="order_id"
                  placeholder="Tìm theo ID (vd: 12)"
                  value="{{ request('order_id') }}" style="max-width:220px">
            <button class="btn" type="submit">
          <i class="fa-solid fa-magnifying-glass"></i> Lọc
      </button>

      <a class="btn btn-outline" href="{{ route('admin.orders.index') }}">Reset</a>
    </form>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Khách hàng</th>
          <th>Điện thoại</th>
          <th>Tổng tiền</th>
          <th>Thanh toán</th>
          <th>Trạng thái</th>
          <th>Ngày tạo</th>
          <th>Hành động</th>
        </tr>
      </thead>

      <tbody>
        @forelse($orders as $o)
          <tr>
            <td>#{{ $o->id }}</td>
            <td>{{ $o->customer_name }}</td>
            <td>{{ $o->customer_phone }}</td>
            <td>{{ number_format($o->total) }} đ</td>
            <td>{{ strtoupper($o->payment_method) }}</td>
            <td>{{ $o->status }}</td>
            <td>{{ $o->created_at?->format('d/m/Y H:i') }}</td>
            <td>
                <a class="btn btn-outline" href="javascript:void(0)"
                    onclick="openModal('{{ route('admin.orders.show', $o->id) }}','Chi tiết đơn #{{ $o->id }}')">
                    Xem
                </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" style="color:var(--muted)">Chưa có đơn hàng nào.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if(method_exists($orders,'links'))
    <div class="card-body" style="border-top:1px solid var(--line)">
      {{ $orders->links() }}
    </div>
  @endif
</div>
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
