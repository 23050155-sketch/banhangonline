<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Danh mục</title>
</head>
<body>
    <h1>Danh sách danh mục</h1>

    <p><a href="{{ route('admin.categories.create') }}">+ Thêm danh mục</a></p>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @if($categories->count() == 0)
        <p>Chưa có danh mục nào.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
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
            @foreach($categories as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->slug }}</td>
                    <td>{{ $c->status ? 'Hiện' : 'Ẩn' }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $c->id) }}">Sửa</a>

                        <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa danh mục này nha?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div style="margin-top: 12px;">
            {{ $categories->links() }}
        </div>
    @endif
</body>
</html>
