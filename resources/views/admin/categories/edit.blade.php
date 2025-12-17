<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Sửa danh mục</title>
</head>
<body>
    <h1>Sửa danh mục</h1>

    @if($errors->any())
        <ul style="color: red">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
        @csrf
        @method('PUT')

        <p>
            <label>Tên danh mục</label><br>
            <input type="text" name="name" value="{{ old('name', $category->name) }}">
        </p>

        <p>
            <label>
                <input type="checkbox" name="status" value="1" {{ $category->status ? 'checked' : '' }}>
                Hiển thị
            </label>
        </p>

        <button type="submit">Cập nhật</button>
        <a href="{{ route('admin.categories.index') }}">Quay lại</a>
    </form>
</body>
</html>
