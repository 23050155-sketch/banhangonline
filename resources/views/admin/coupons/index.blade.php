@extends('layouts.admin')
@section('title','Admin - Coupon')
@section('page_title','Quản lý Coupon')

@section('page_actions')
  <a class="btn" href="javascript:void(0)"
     onclick="openModal('{{ route('admin.coupons.create') }}','Thêm coupon')">
    <i class="fa-solid fa-plus"></i> Thêm
  </a>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <b>Danh sách coupon</b>
  </div>

  <div class="card-body table-wrap">
    <table class="table" style="min-width:900px">
      <thead>
        <tr>
          <th>Code</th>
          <th>Giảm</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>

      <tbody>
        @forelse($coupons as $c)
          <tr>
            <td style="font-weight:700">{{ $c->code }}</td>

            <td>
              {{ $c->type == 'percent' ? $c->value.'%' : number_format($c->value).'đ' }}
            </td>

            <td>
              @if($c->status)
                <span class="btn btn-outline" style="cursor:default">Bật</span>
              @else
                <span class="btn btn-outline" style="cursor:default;opacity:.7">Tắt</span>
              @endif
            </td>

            <td style="display:flex;gap:8px;flex-wrap:wrap">

              <form method="POST" action="{{ route('admin.coupons.toggle',$c) }}">
                @csrf
                @method('PATCH')
                <button class="btn btn-outline" type="submit">
                  {{ $c->status ? 'Tắt' : 'Bật' }}
                </button>
              </form>

              <form method="POST" action="{{ route('admin.coupons.destroy',$c) }}"
                    onsubmit="return confirm('Xóa coupon này nha?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Xóa</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" style="color:var(--muted)">Chưa có coupon nào.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if(method_exists($coupons,'links'))
    <div class="card-body" style="border-top:1px solid var(--line)">
      {{ $coupons->links() }}
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
