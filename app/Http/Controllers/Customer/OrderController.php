<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('cart')->orderByDesc('created_at')->get();
        return view('customer.pages.orders', compact('orders'));
    }

    public function detail($id)
    {
        $order = Order::with('cart.cart_products.product')->where('order.id', $id)->firstOrFail();
        return view('customer.pages.order', compact('order'));
    }
}
