<h1>Coupons</h1>
<a href="{{ route('admin.coupons.create') }}">+ Thêm</a>

<table border="1">
<tr>
<th>Code</th><th>Giảm</th><th>Trạng thái</th><th>Hành động</th>
</tr>
@foreach($coupons as $c)
<tr>
<td>{{ $c->code }}</td>
<td>{{ $c->type == 'percent' ? $c->value.'%' : number_format($c->value).'đ' }}</td>
<td>{{ $c->status ? 'Bật' : 'Tắt' }}</td>
<td>
<a href="{{ route('admin.coupons.edit',$c) }}">Sửa</a>
<form method="POST" action="{{ route('admin.coupons.toggle',$c) }}">
@csrf @method('PATCH')
<button>Bật/Tắt</button>
</form>
<form method="POST" action="{{ route('admin.coupons.destroy',$c) }}">
@csrf @method('DELETE')
<button>Xóa</button>
</form>
</td>
</tr>
@endforeach
</table>
