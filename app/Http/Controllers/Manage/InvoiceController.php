<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Info;
use App\Models\Cart;
use App\Mail\InvoiceSend;
use App\Mail\OrderStatus;
use Illuminate\Support\Facades\Mail;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function  index(){
        $order = Order::with('cart.cart_products.product')->find(request('id'));
        $user = User::where('id', $order->cart->user_id)->first();
        $info = Info::find(1);
        
        $cart = Cart::where('id', $order->cart_id)->first();
        
        
        
        $client = new Party([
            'name'          => config('app.name'),
            'phone'         => $info->mobile,
            'custom_fields' => [
                'email'        => $info->email,
                'address' => $info->address,
            ],
        ]);

        $customer = new Party([
            'name'          => $order->first_name . ' ' . $order->last_name,
            'address'       => $order->address,
            'custom_fields' => [
                'mobil' => $order->mobile,
                'email' => $order->email,
                'poçt kodu' => $order->zip_code,
                'Şəhər' => $order->city,
                'sifariş nömrəsi' => 'SP-' . request('id'),
                'sifariş tarixi' => $order->created_at,
                'Ödəniş növü' => $order->bank,
                'Ödəniş tarixi' => $order->tran_date_time,
            ],
        ]);
        $items = [];
        foreach ($order->cart->cart_products as $item) {
            $items[] = (new InvoiceItem())->title($item->product->product_name)->pricePerUnit($item->amount)->quantity($item->piece);
        }
        
        
        $notes = [$order->shipping, $order->order_amount];
        
        $invoice = Invoice::make('INVOICE')
            ->series('SP')
            ->sequence(request('id'))
            ->serialNumberFormat('{SERIES}{SEQUENCE}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol('₼')
            ->currencyCode('AZN')
            ->currencyFormat('{VALUE}{SYMBOL}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            ->notes(json_encode($notes))
            ->save('public');



        
        return $invoice->stream();
    }
    
}
