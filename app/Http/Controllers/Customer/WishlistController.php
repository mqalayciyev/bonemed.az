<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WishList;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(){
        return view('customer.pages.wishlist');
    }
    public function add_wish_list(){
        $product_id = request()->get('id');
        $user_id = auth()->id();
        $add = new WishList();
        $count = WishList::where('product_id', $product_id)->where('user_id', $user_id)->count();
        if($count > 0){
            echo "Bu məhsul artıq istəklərim siyahısına əlavə edilib.";
        }
        else
        {
            $add->user_id = $user_id;
            $add->product_id = $product_id;
            $add->save();
            echo "Məhsul istəklərim siyahısına əlavə edildi.";
        }
        
    }
    public function view_my_wish_list(){
        $user_id = auth()->id();
        $wish_lists = WishList::select('product_id')->where('user_id', $user_id)->where('deleted_at', null)->get();
        $products = [];
        for($i=0; $i<count($wish_lists); $i++){
            $products2 = Product::select('product.*')
                ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
                ->where('product.id', $wish_lists[$i]->product_id)
                ->firstOrFail();
            array_push($products, $products2);
        }
        
        return view('customer.pages.single_product', compact('products'));
    }
    public function remove_wish_list(){
        $user_id = auth()->id();
        $product_id = request()->get('id');
        WishList::where('user_id', $user_id)->where('product_id', $product_id)->delete();
        echo "success";
    }
}
