@extends('layouts.admin')

@section('title','Admin - Dashboard')
@section('page_title','Dashboard')

@section('content')
<div class="grid-2" style="grid-template-columns:repeat(5, minmax(0,1fr));gap:12px">
  <div class="card"><div class="card-body">
    <div style="color:var(--muted)">Tổng danh mục</div>
    <div style="font-size:26px;font-weight:800">{{ $totalCategories }}</div>
  </div></div>

  <div class="card"><div class="card-body">
    <div style="color:var(--muted)">Tổng sản phẩm</div>
    <div style="font-size:26px;font-weight:800">{{ $totalProducts }}</div>
  </div></div>

  <div class="card"><div class="card-body">
    <div style="color:var(--muted)">Tổng user</div>
    <div style="font-size:26px;font-weight:800">{{ $totalUsers }}</div>
  </div></div>

  <div class="card"><div class="card-body">
    <div style="color:var(--muted)">Đơn hôm nay</div>
    <div style="font-size:26px;font-weight:800">{{ $ordersToday }}</div>
  </div></div>

  <div class="card"><div class="card-body">
    <div style="color:var(--muted)">Doanh thu tháng</div>
    <div style="font-size:26px;font-weight:800">{{ number_format($incomeMonth) }} đ</div>
  </div></div>
</div>
@endsection
