<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // GET /admin/orders
    public function index(Request $request)
{
    $orderId = $request->query('order_id');
    $from = $request->query('from_date');
    $to = $request->query('to_date');

    $query = Order::query()->latest();

    if ($orderId) {
        $query->where('id', (int)$orderId);
    }

    if ($from) {
        $query->whereDate('created_at', '>=', $from);
    }

    if ($to) {
        $query->whereDate('created_at', '<=', $to);
    }

    $orders = $query->paginate(10)->appends($request->query());

    return view('admin.orders.index', compact('orders'));
}

    // GET /admin/orders/{order}
    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    // PATCH /admin/orders/{order}/status
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,done,cancelled',
        ]);

        // ❌ Không cho hủy đơn đã hoàn thành
        if ($order->status === 'done' && $request->status === 'cancelled') {
            return back()->with('error', 'Không thể hủy đơn đã hoàn thành!');
        }

        DB::transaction(function () use ($order, $request) {

            // ✅ Hoàn kho đúng 1 lần khi chuyển sang cancelled
            if ($order->status !== 'cancelled' && $request->status === 'cancelled') {

                $order->load('items.product');

                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            }

            // Cập nhật trạng thái
            $order->update([
                'status' => $request->status,
            ]);
        });

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}
