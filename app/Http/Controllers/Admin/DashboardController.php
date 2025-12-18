<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalProducts   = Product::count();
        $totalUsers      = User::count();

        // đơn hàng trong ngày (theo created_at)
        $ordersToday = Order::whereDate('created_at', Carbon::today())->count();

        // doanh thu tháng này (chỉ tính done để chuẩn)
        $incomeMonth = Order::whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->where('status', 'done')
            ->sum('total');

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalUsers',
            'ordersToday',
            'incomeMonth'
        ));
    }
}
