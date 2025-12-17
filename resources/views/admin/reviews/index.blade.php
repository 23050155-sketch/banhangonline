<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Reviews</title>
  <style>
    body{font-family:system-ui,Segoe UI,Arial;margin:0;background:#f6f7fb}
    .wrap{max-width:1100px;margin:24px auto;padding:0 16px}
    .card{background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px}
    table{width:100%;border-collapse:collapse}
    th,td{border-bottom:1px solid #eee;padding:10px;vertical-align:top}
    th{text-align:left;background:#fafafa}
    .badge{padding:4px 8px;border-radius:999px;font-size:12px;display:inline-block}
    .ok{background:#dcfce7}
    .bad{background:#fee2e2}
    .actions form{display:inline}
    .btn{padding:6px 10px;border:1px solid #ddd;border-radius:8px;background:#fff;cursor:pointer}
    .btn-danger{border-color:#fca5a5;color:#b91c1c}
    .top{display:flex;justify-content:space-between;align-items:center;gap:12px}
    .filter{display:flex;gap:10px;flex-wrap:wrap;margin:12px 0}
    input,select{padding:8px;border:1px solid #ddd;border-radius:8px}
    a{color:#2563eb;text-decoration:none}
  </style>
</head>
<body>
<div class="wrap">
  <div class="card">
    <div class="top">
      <h2 style="margin:0">Quản lý đánh giá</h2>
      <a href="/">Về trang chủ</a>
    </div>

    @if(session('success'))
      <div style="margin:12px 0;padding:10px;background:#dcfce7;border-radius:10px;">
        {{ session('success') }}
      </div>
    @endif

    <form method="GET" class="filter">
      <input type="number" name="product_id" placeholder="Lọc product_id" value="{{ request('product_id') }}">
      <select name="status">
        <option value="">-- Trạng thái --</option>
        <option value="1" @selected(request('status')==='1')>Hiển thị</option>
        <option value="0" @selected(request('status')==='0')>Ẩn</option>
      </select>
      <button class="btn" type="submit">Lọc</button>
      <a class="btn" href="{{ route('admin.reviews.index') }}">Reset</a>
    </form>

    <table>
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
            <div style="font-size:12px;opacity:.7">product_id: {{ $r->product_id }}</div>
          </td>
          <td>
            {{ $r->user?->name ?? ('#'.$r->user_id) }}
            <div style="font-size:12px;opacity:.7">user_id: {{ $r->user_id }}</div>
          </td>
          <td>⭐ {{ $r->rating }}/5</td>
          <td style="max-width:360px;white-space:pre-wrap;">{{ $r->comment }}</td>
          <td>
            @if($r->status)
              <span class="badge ok">Hiển thị</span>
            @else
              <span class="badge bad">Ẩn</span>
            @endif
          </td>
          <td style="font-size:13px;">{{ $r->created_at }}</td>
          <td class="actions" style="white-space:nowrap;">
            <form action="{{ route('admin.reviews.toggle', $r->id) }}" method="POST">
              @csrf
              @method('PATCH')
              <button class="btn" type="submit">{{ $r->status ? 'Ẩn' : 'Duyệt' }}</button>
            </form>

            <form action="{{ route('admin.reviews.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Xóa review này nha?');">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger" type="submit">Xóa</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="8">Chưa có đánh giá nào.</td></tr>
      @endforelse
      </tbody>
    </table>

    <div style="margin-top:12px;">
      {{ $reviews->links() }}
    </div>
  </div>
</div>
</body>
</html>
