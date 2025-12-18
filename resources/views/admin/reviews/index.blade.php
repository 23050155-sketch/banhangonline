@extends('layouts.admin')
@section('title','Admin - Đánh giá')
@section('page_title','Quản lý đánh giá')

@section('content')

<div class="card" style="margin-bottom:12px">
  <div class="card-body" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
    <form method="GET" action="{{ route('admin.reviews.index') }}"
          style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">

      <input class="input" type="number" name="product_id"
             placeholder="Lọc product_id" value="{{ request('product_id') }}"
             style="max-width:200px">

      <select class="input" name="status" style="max-width:200px">
        <option value="">-- Trạng thái --</option>
        <option value="1" @selected(request('status')==='1')>Hiển thị</option>
        <option value="0" @selected(request('status')==='0')>Ẩn</option>
      </select>

      <button class="btn btn-outline" type="submit">
        <i class="fa-solid fa-filter"></i> Lọc
      </button>

      <a class="btn btn-outline" href="{{ route('admin.reviews.index') }}">
        Reset
      </a>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <b>Danh sách đánh giá</b>
  </div>

  <div class="card-body table-wrap">
    <table class="table" style="min-width:1100px">
      <thead>
        <tr>
          <th>ID</th>
          <th>Sản phẩm</th>
          <th>User</th>
          <th>Rating</th>
          <th>Comment</th>
          <th>Status</th>
          <th>Ngày</th>
          <th>Hành động</th>
        </tr>
      </thead>

      <tbody>
      @forelse($reviews as $r)
        <tr>
          <td>{{ $r->id }}</td>

          <td>
            {{ $r->product?->name ?? ('#'.$r->product_id) }}
            <div style="font-size:12px;color:var(--muted)">product_id: {{ $r->product_id }}</div>
          </td>

          <td>
            {{ $r->user?->name ?? ('#'.$r->user_id) }}
            <div style="font-size:12px;color:var(--muted)">user_id: {{ $r->user_id }}</div>
          </td>

          <td>⭐ {{ $r->rating }}/5</td>

          <td style="max-width:420px;white-space:pre-wrap">{{ $r->comment }}</td>

          <td>
            @if($r->status)
              <span class="btn btn-outline" style="cursor:default">Hiện</span>
            @else
              <span class="btn btn-outline" style="cursor:default;opacity:.7">Ẩn</span>
            @endif
          </td>

          <td style="font-size:13px;color:var(--muted)">{{ $r->created_at }}</td>

          <td style="display:flex;gap:8px;flex-wrap:wrap">
            <form action="{{ route('admin.reviews.toggle', $r->id) }}" method="POST">
              @csrf
              @method('PATCH')
              <button class="btn btn-outline" type="submit">
                {{ $r->status ? 'Ẩn' : 'Duyệt' }}
              </button>
            </form>

            <form action="{{ route('admin.reviews.destroy', $r->id) }}" method="POST"
                  onsubmit="return confirm('Xóa review này nha?');">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger" type="submit">Xóa</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="8" style="color:var(--muted)">Chưa có đánh giá nào.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>

  <div class="card-body" style="border-top:1px solid var(--line)">
    {{ $reviews->links() }}
  </div>
</div>

@endsection
