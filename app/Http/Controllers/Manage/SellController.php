<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;

class SellController extends Controller
{
    public function index()
    {
        request()->session()->forget('total_price');
        request()->session()->forget('stok_piece');

        $product_customers = [];
        $customers = Customer::orderBy('name', 'asc')->get();

        return view('manage.pages.sell.index', compact( 'product_customers', 'customers'));
    }

    public function products()
    {
        $products = Product::where('point_of_sale', 1)->orderBy('updated_at', 'desc')->take(16)->get();
        foreach ($products as $product) {
            $output = '<div class="col-md-3">
                                <div class="box box-primary text-center product" id="' . $product->id . '">
                                    <div class="box-body">
                                    <img class="text-center" src="';
            $output .= $product->image->image_name != null ? asset("img/products/" . $product->image->thumb_name) : "http://via.placeholder.com/50x50?text=ProductPhoto";
            $output .= '" class="img-responsive" style="width: 50px; height:50px;">';
            $output .= '</div>';
            $output .= '<div class="box-footer text-sm">' . str_limit($product->product_name, 10) . '</div>';
            $output .= '</div>
                            </div>';
            echo $output;
        }
    }

    public function search()
    {
        $val = request()->get('val');
        $products = Product::where('point_of_sale', 1)
            ->where('product_name', 'LIKE', "%$val%")
            ->orderBy('updated_at', 'desc')
            ->get();
        foreach ($products as $product) {
            $output = '<div class="col-md-3">
                                <div class="box box-primary text-center product" id="' . $product->id . '">
                                    <div class="box-body">
                                    <img class="text-center" src="';
            $output .= $product->image->image_name != null ? asset("img/products/" . $product->image->thumb_name) : "http://via.placeholder.com/50x50?text=ProductPhoto";
            $output .= '" class="img-responsive" style="width: 50px; height:50px;">';
            $output .= '</div>';
            $output .= '<div class="box-footer text-sm">' . str_limit($product->product_name, 10) . '</div>';
            $output .= '</div>
                            </div>';
            echo $output;
        }
    }

    public function sale_list()
    {
        $id = request()->get('id');
        $product = Product::where('point_of_sale', 1)
            ->where('id', 'LIKE', "%$id%")->first();


        is_null(session('stok_piece')) ? session()->put('stok_piece', $product->stok_piece) : session('stok_piece');
        if (session('stok_piece') > 0) {
            session()->put('stok_piece', session('stok_piece') - 1);
            $output = '<li class="list-group-item">' . $product->product_name . '
        <span class="fa fa-pull-right fa-trash manual_cart_remove" id="' . $product->id . '"></span>
        <span class="fa fa-pull-right sale_price">' . $product->sale_price . '</span>
        </li>';
            $sale_price = str_replace(', ', '', $product->sale_price);
            $session_tp = request()->session()->get('total_price');
            if (!$session_tp) {
                request()->session()->put('total_price', $sale_price);
                $total_price = $sale_price;
            } else {
                $total_price = number_format(str_replace(',', '', $session_tp) + str_replace(',', '', $sale_price), 2);
                request()->session()->put('total_price', $total_price);
            }
            $data = array(
                'sale_list' => $output,
                'total_price' => $total_price,
            );
        } else {
            $data['warning_message'] = __('admin.No items in stock');
        }
        echo json_encode($data);

    }

    public function manual_cart_remove()
    {
        $id = request()->get('id');
        $product = Product::where('point_of_sale', 1)
            ->where('id', 'LIKE', "%$id%")->first();
        $sale_price = str_replace(', ', '', $product->sale_price);
        $session_tp = request()->session()->get('total_price');
        if ($session_tp) {
            $total_price = number_format(str_replace(',', '', $session_tp) - str_replace(',', '', $sale_price), 2);
            request()->session()->put('total_price', $total_price);
        }

        $data = array('total_price' => $total_price);

        echo json_encode($data);
    }

    public function trash_cart()
    {
        request()->session()->forget('total_price');
    }

}