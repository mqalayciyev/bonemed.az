<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceSend;
use App\Models\Order;
use App\User;
use DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;


class PaymentController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('user.sign_in')
                ->with('message_type', 'info')
                ->with('message', __('content.You need to log in or register for a payment.'));
        } else if (count(Cart::content()) == 0) {
            return redirect()->route('homepage')
                ->with('message_type', 'info')
                ->with('message', __('content.You must have a product in your cart for payment.'));
        }

        $user_detail = auth()->user()->detail;

        return view('customer.pages.payment', compact('user_detail'));
    }

    public function pay()
    {
        $order = request()->all();
        $order['cart_id'] = session('active_cart_id');
        $order['bank'] = 'Kapital Bank';
        $order['installment_number'] = 1;
        $order['status'] = 'Your order has been received';
        $order['order_amount'] = Cart::subtotal();
        
        $user_id = DB::table('cart')->where('id', session('active_cart_id'))->first();
        $user_id = $user_id->user_id;
        $user = User::where('id', $user_id)->first();

        Order::create($order);
        Cart::destroy();
        // Mail::to($user->email)->send(new OrderStatus($order));
        $order = Order::with('cart.cart_products.product')->find(request('id'));
        $user = User::where('id', $order->cart->user_id)->first();
        $data =[
            'total_amount' => $order->order_amount,
            'payment_status' => $order->status,
            'order_date' => $order->created_at,
            'payment_date' => '',
            'client_firstname' => $order->first_name,
            'client_lastname' => $order->last_name,
            'client_email' => $user->email,
            'client_tel' => $order->mobile,
            'client_address' => $order->address,
            'discount' => '',
            'order_items' => $order->cart->cart_products,
        ];
        Mail::to($user->email)->send(new InvoiceSend($data));
        session()->forget('active_cart_id');
        return redirect()->route('orders')
            ->with('message_type', 'success')
            ->with('message', __('content.Your payment has been successful.'));
    }
}
