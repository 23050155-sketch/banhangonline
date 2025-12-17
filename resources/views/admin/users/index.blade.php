<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Users</title></head>
<body>
<h1>Danh sách Users</h1>

@if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif
@if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

<p><a href="{{ route('admin.users.create') }}">+ Thêm user</a></p>

<form method="GET" action="{{ route('admin.users.index') }}">
  <input name="q" value="{{ $q }}" placeholder="Tìm name/email">
  <button type="submit">Tìm</button>
</form>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Hành động</th>
  </tr>
  @foreach($users as $u)
    <tr>
      <td>{{ $u->id }}</td>
      <td>{{ $u->name }}</td>
      <td>{{ $u->email }}</td>
      <td>{{ $u->role }}</td>
      <td>{{ $u->status ? 'Active' : 'Blocked' }}</td>
      <td>
        <a href="{{ route('admin.users.edit', $u->id) }}">Sửa</a>

        <form action="{{ route('admin.users.toggleStatus', $u->id) }}" method="POST" style="display:inline">
          @csrf
          @method('PATCH')
          <button type="submit" onclick="return confirm('Đổi trạng thái user?')">
            {{ $u->status ? 'Khóa' : 'Mở' }}
          </button>
        </form>
      </td>
    </tr>
  @endforeach
</table>

<div style="margin-top:10px">
  {{ $users->links() }}
</div>
</body>
</html>
