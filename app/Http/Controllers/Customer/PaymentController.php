<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceSend;
use App\Mail\OrderStatus;
use App\Models\Order;
use App\Models\Info;
use App\Models\User;
use DB;
use App\Models\Cart as CartModel;
use App\Models\CartProduct;
use App\Models\PriceList;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;


class PaymentController extends Controller
{
    public function index()
    {
        $info = Info::find(1);
        if (!auth()->check()) {
            return redirect()->route('user.sign_in')->with(['info' => __('content.You need to log in or register for a payment.')]);
        } else if (count(Cart::content()) == 0) {
            return redirect()->route('home')->with(['info' => __('content.You must have a product in your cart for payment.')]);
        }

        $user_detail = auth()->user()->detail;

        return view('customer.pages.payment', compact('user_detail'));
    }
    public function pay()
    {

        $active_cart_id = session('active_cart_id');


        $cartProduct = CartProduct::where('cart_id', $active_cart_id)->get();

        foreach ($cartProduct as $value) {

            $product = Product::where('id', $value->product_id)->first();
            if ($product) {

                if ($product->stok_piece == 0) {
                    return redirect()->route('cart')
                        ->with('message_type', 'warning')
                        ->with('message', $product->product_name . ' anbarda qalmayıb. Zəhmət olmasa məhsulu səbətdən silin');
                } elseif ($product->stok_piece < $value->piece) {
                    return redirect()->route('cart')
                        ->with('message_type', 'warning')
                        ->with('message', $product->product_name . ' maksimum ' . $product->stok_piece . ' ədəd sifariş edə bilərsiniz. Zəhmət olmasa məhsulun səbət sayını azaldın');
                }
            }
        }



        $messages = [
            'first_name.required' => 'Ad qeyd edilməyib.',
            'first_name.min' => 'Ad minimum 3 simvol olmalıdır.',
            'last_name.required' => 'Soyad qeyd edilməyib.',
            'last_name.min' => 'Soyad minimum 3 simvol olmalıdır.',
            'email.required'  => 'Email boş ola bilməz.',
            'mobile.required' => 'Nömrə qeyd edilməyib',
            'address.required'  => 'Ünvan boş ola bilməz.',
            'country.required'  => 'Ölkə boş ola bilməz.',
            'city.required'  => 'Şəhər boş ola bilməz.',
            'payment_method.required'  => 'Ödəniş növü seçilməyib.',
        ];
        $this->validate(request(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'city' => 'required',
            'payment_method' => 'required',
            'delivery_method' => 'required',
        ], $messages);

        $info = Info::find(1);
        

        $amount = Cart::subtotal();

        if (request('delivery_method') == 1) {
            $shipping = $info->standart_delivery_amount;
        } else {
            $shipping = $info->fast_delivery_amount;
        }


        $paymentMethod =  request('payment_method');
        $order = request()->except(['payment_method', '_token']);
        $order['cart_id'] = session('active_cart_id');
        $order['order_amount'] = $amount;
        $order['shipping'] = $shipping;
        $order['status'] = 'Your order has been received';


        $ordercreated = Order::create($order);


        Cart::destroy();
        session()->forget('active_cart_id');


        if ($paymentMethod == 1) {
            Order::where('id', $ordercreated->id)->update([
                'bank' => 'Qapıda Ödəmə',
                'order_status' => 'PAYMENT_DOOR',
            ]);

            $cartProduct = CartProduct::where('cart_id', $active_cart_id)->get();
            foreach ($cartProduct as $value) {
                $product = Product::where('id', $value->product_id)->first();
                if ($product) {
                    $product->update(['stok_piece' => $product->stok_piece - $value->piece]);
                }
            }




            $cart = CartModel::where('id', $active_cart_id)->first();
            $data = [
                'order_amount' => $ordercreated['order_amount'],
                'shipping' => $ordercreated['shipping'],
                'payment_type' => 'Qapıda ödəmə',
                'order_status' => 'Sifariş qəbul edildi',
                'card_number' => '',
                'brand' => '',
                'order_date' => date('Y-m-d H:i:s'),
                'payment_date' => date('Y-m-d H:i:s'),
                'client_firstname' => $order['first_name'],
                'client_lastname' => $order['last_name'],
                'client_email' => $order['email'],
                'client_tel' => $order['mobile'],
                'client_address' => $order['address'],
                'discount' => '',
                'cart_products' => $cart->cart_products,
            ];


            // Mail::to($order['email'])->send(new InvoiceSend($data));

            return redirect()->route('orders')
                ->with('message_type', 'success')
                ->with('message', 'Sizin sifarişiniz qəbul edildi. Əlavə məlumatlar emailinizə göndərildi.');
        } elseif ($paymentMethod == 2) {
            Order::where('id', $ordercreated->id)->update([
                'bank' => 'Bank Kartı',
                'order_status' => 'PENDING',
                'status' => 'Payment is expected',
            ]);

            $taksit = "TAKSİT=0";

            if (request('installment_number') != '0') {
                $taksit = 'TAKSIT=' . request('installment_number');
            }


            $input_xml = '<?xml version="1.0" encoding="UTF-8"?>
                <TKKPG>
                    <Request>
                        <Operation>CreateOrder</Operation>
                        <Language>AZ</Language>
                        <Order>
                            <OrderType>Purchase</OrderType>
                            <Merchant>E1790002</Merchant>
                            <Amount>' . ($ordercreated['order_amount'] * 100) . '</Amount>
                            <Currency>944</Currency>
                            <Description>' . $taksit . '</Description>
                            <ApproveURL>' . route('payment.return', [$ordercreated->id]) . '</ApproveURL>
                            <CancelURL>' . route('payment.return', [$ordercreated->id]) . '</CancelURL>
                            <DeclineURL>' . route('payment.return', [$ordercreated->id]) . '</DeclineURL>
                            </Order>
                </Request>
                </TKKPG>';


            function xmlRequest($request)
            {

                $url = "https://e-commerce.kapitalbank.az:5443/exec";
                $keyFile  = realpath("payment/goycay_avm.key");

                $certFile = realpath("payment/goycay_avm.crt");
                // return $keyFile;
                $ch = curl_init();
                $options = array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
                    CURLOPT_URL => $url,
                    CURLOPT_SSLCERT => $certFile,
                    CURLOPT_SSLKEY => $keyFile,
                    CURLOPT_POSTFIELDS => $request,
                    CURLOPT_POST => true
                );
                curl_setopt_array($ch, $options);
                $output = curl_exec($ch);
                $array_data = json_decode(json_encode(simplexml_load_string($output)), true);

                return $array_data;
            }




            $response = xmlRequest($input_xml);


            $url = $response['Response']['Order']['URL'] . '?ORDERID=' . $response['Response']['Order']['OrderID'] . '&SESSIONID=' . $response['Response']['Order']['SessionID'];

            return redirect()->away($url);
        }
    }


    public function complete($id)
    {
        $order = Order::where('id', $id)->first();


        $taksit = 'TAKSIT=0';
        $input_xml = '<?xml version="1.0" encoding="UTF-8"?>
                <TKKPG>
                    <Request>
                        <Operation>CreateOrder</Operation>
                        <Language>AZ</Language>
                        <Order>
                            <OrderType>Purchase</OrderType>
                            <Merchant>E1790002</Merchant>
                            <Amount>' . ($order['order_amount'] * 100) . '</Amount>
                            <Currency>944</Currency>
                            <Description>' . $taksit . '</Description>
                            <ApproveURL>' . route('payment.return', [$order->id]) . '</ApproveURL>
                            <CancelURL>' . route('payment.return', [$order->id]) . '</CancelURL>
                            <DeclineURL>' . route('payment.return', [$order->id]) . '</DeclineURL>
                            </Order>
                </Request>
                </TKKPG>';


        function xmlRequest($request)
        {

            $url = "https://e-commerce.kapitalbank.az:5443/exec";
            $keyFile  = realpath("payment/goycay_avm.key");

            $certFile = realpath("payment/goycay_avm.crt");
            // return $keyFile;
            $ch = curl_init();
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
                CURLOPT_URL => $url,
                CURLOPT_SSLCERT => $certFile,
                CURLOPT_SSLKEY => $keyFile,
                CURLOPT_POSTFIELDS => $request,
                CURLOPT_POST => true
            );
            curl_setopt_array($ch, $options);
            $output = curl_exec($ch);
            $array_data = json_decode(json_encode(simplexml_load_string($output)), true);

            return $array_data;
        }


        $response = xmlRequest($input_xml);

        // 	return $response;

        $url = $response['Response']['Order']['URL'] . '?ORDERID=' . $response['Response']['Order']['OrderID'] . '&SESSIONID=' . $response['Response']['Order']['SessionID'];

        return redirect()->away($url);
    }

    public function paymentPageReturn($orderid)
    {



        $msg = json_decode(json_encode(simplexml_load_string(request('xmlmsg'))), true);


        $order = Order::where('id', $orderid)->first();
        $cart = CartModel::where('id', $order->cart_id)->first();
        Order::where('id', $orderid)->update([
            'tran_date_time' =>  $msg['TranDateTime'],
        ]);

        if ($msg['OrderStatus'] == 'APPROVED') {



            Order::where('id', $orderid)->update([
                'order_status' => 'APPROVED',
                'status' => 'Your order has been received',
                'brand' => $msg['Brand'],
                'card' => $msg['PAN'],
            ]);



            $data = [
                'order_amount' => $order['order_amount'],
                'bonus_amount' => $order['bonus_amount'],
                'shipping' => $order['shipping'],
                'payment_type' => 'Bank kartı',
                'order_status' => 'ÖDƏNİŞ TAMAMLANIB',
                'card_number' => $msg['PAN'],
                'brand' => $msg['Brand'],
                'status' => 'Your order has been received',
                'order_date' => $msg['TranDateTime'],
                'payment_date' => date('Y-m-d H:i:s'),
                'client_firstname' => $order['first_name'],
                'client_lastname' => $order['last_name'],
                'client_email' => $order['email'],
                'client_tel' => $order['mobile'],
                'client_address' => $order['address'],
                'discount' => '',
                'cart_products' => $cart->cart_products,
            ];



            Mail::to($order['email'])->send(new InvoiceSend($data));
            return redirect()->route('orders')
                ->with('message_type', 'success')
                ->with('message', __('content.Your payment has been successful.') . ' Məlumatlar emailə göndərildi.');
        } else if ($msg['OrderStatus'] === 'CANCELED') {



            $data = [
                'order_amount' => $order['order_amount'],
                'bonus_amount' => $order['bonus_amount'],
                'shipping' => $order['shipping'],
                'payment_type' => 'Bank kartı',
                'order_status' => 'ÖDƏNİŞ GÖZLƏNİLİR',
                'card_number' => '',
                'brand' => '',
                'order_date' => $msg['TranDateTime'],
                'payment_date' => date('Y-m-d H:i:s'),
                'client_firstname' => $order['first_name'],
                'client_lastname' => $order['last_name'],
                'client_email' => $order['email'],
                'client_tel' => $order['mobile'],
                'client_address' => $order['address'],
                'discount' => '',
                'cart_products' => $cart->cart_products,
            ];



            Mail::to($order['email'])->send(new InvoiceSend($data));
            return redirect()->route('orders')
                ->with('message_type', 'danger')
                ->with('message', 'Sifariş imtina edildi.');
        } else if ($msg['OrderStatus'] === 'DECLINED') {


            $data = [
                'order_amount' => $order['order_amount'],
                'bonus_amount' => $order['bonus_amount'],
                'shipping' => $order['shipping'],
                'payment_type' => 'Bank kartı',
                'order_status' => 'ÖDƏNİŞ GÖZLƏNİLİR',
                'card_number' => '',
                'brand' => '',
                'order_date' => $msg['TranDateTime'],
                'payment_date' => date('Y-m-d H:i:s'),
                'client_firstname' => $order['first_name'],
                'client_lastname' => $order['last_name'],
                'client_email' => $order['email'],
                'client_tel' => $order['mobile'],
                'client_address' => $order['address'],
                'discount' => '',
                'cart_products' => $cart->cart_products,
            ];



            Mail::to($order['email'])->send(new InvoiceSend($data));
            return redirect()->route('orders')
                ->with('message_type', 'danger')
                ->with('message', 'Yenidən yoxlayın. Status: ' . __('content.' . $msg['ResponseDescription']));
        } else {

            $data = [
                'order_amount' => $order['order_amount'],
                'bonus_amount' => $order['bonus_amount'],
                'shipping' => $order['shipping'],
                'payment_type' => 'Bank kartı',
                'order_status' => 'ÖDƏNİŞ GÖZLƏNİLİR',
                'card_number' => '',
                'brand' => '',
                'order_date' => $msg['TranDateTime'],
                'payment_date' => date('Y-m-d H:i:s'),
                'client_firstname' => $order['first_name'],
                'client_lastname' => $order['last_name'],
                'client_email' => $order['email'],
                'client_tel' => $order['mobile'],
                'client_address' => $order['address'],
                'discount' => '',
                'cart_products' => $cart->cart_products,
            ];



            Mail::to($order['email'])->send(new InvoiceSend($data));
            return redirect()->route('orders')
                ->with('message_type', 'danger')
                ->with('message', 'Sifariş uğursuz oldu.');
        }
    }
}
