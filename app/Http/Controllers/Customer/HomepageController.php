<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Session;

class HomepageController extends Controller
{
    public function index()
    {
        $products_slider = Slider::orderBy('slider_order', 'asc')->where('slider_active', 1)->take(5)->get();
        $banners = Banner::orderBy('banner_order', 'asc')->where('banner_active', 1)->take(2)->get();
        return view('customer.pages.homepage', compact('products_slider', 'banners'));
    }
    public function about(){
        return view('customer.pages.about');
    }
    public function shipping_return(){
        return view('customer.pages.shipping_return');
    }

    public function products()
    {

        $dynamic_product = request('product');
        if ($dynamic_product == 'products_deal_of_day') {
            $products = Product::select('product.*')
                ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
                ->where('product.discount', '!=', null)
                ->orderBy('updated_at', 'desc')
                ->take(4)
                ->get();

            return view('customer.pages.home_products', compact('products'));
        }
        if ($dynamic_product == 'products_best_selling') {
            if(request('length') == ""){
                $length = 8;
            }
            else{
                $length = request('length');
            }

            $products = Product::select('product.*')
                ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
                ->orderBy('product.best_selling', 'desc')
                ->take($length)
                ->get();
            return view('customer.pages.home_products', compact('products', 'dynamic_product'));
        }
        if ($dynamic_product == 'products_latest') {
            if(request('length') == ""){
                $length = 8;
            }
            else{
                $length = request('length');
            }
            

            $products = Product::select('product.*')
                ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
                ->where('product_detail.show_latest_products', 1)
                ->orderBy('updated_at', 'desc')
                ->take($length)
                ->get();
            return view('customer.pages.home_products', compact('products'));
        }
        if ($dynamic_product == 'products_last_view') {
            $products = [];
            if (session()->has('your_products')) {
                $your_products = explode("-", session('your_products'));

                $products = Product::select('product.*')
                    ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
                    ->whereIn('product.id', $your_products)
                    ->orderBy('updated_at', 'desc')
                    ->take(4)
                    ->get();
            }
            return view('customer.pages.home_products', compact('products', 'dynamic_product'));
        }
        if ($dynamic_product == 'products_pfy') {
            $products = Product::select('product.*')
                ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
                ->where('product_detail.show_picked_for_you', 1)
                ->orderBy('updated_at', 'desc')
                ->take(4)
                ->get();

            return view('customer.pages.home_products', compact('products'));
            
        }
    }

    public function insert_ratings()
    {
        $index = request('index');
        $product_id = request('product_id');
        $insert = Rating::insert([
            'product_id' => $product_id,
            'rating' => $index
        ]);
        if (isset($insert)) {
            echo 'done';
        }
    }
    public function contact(){
        return view('customer.pages.contact');
    }
    public function send(){
        $this->validate(request(), [
            'name' => 'required|min:3',
            'email' => 'required|min:8',
            'message' => 'required|min:3',
        ]);
        request('message');
        
        Contact::create([
            'name' => request('name'),
            'email' => request('email'),
            'message' => request('message'),
        ]);
        return back()->with(['message_type' => 'success', 'message' => 'Cavabınız üçün təşəkkürlər.']);
    }

    public function invoice(){
        return view('common.invoices.default');
    }
}
