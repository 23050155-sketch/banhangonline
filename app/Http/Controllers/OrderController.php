<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function myOrders()
    {
        $user = auth()->user();

        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('orders.my', compact('orders'));
    }
}
