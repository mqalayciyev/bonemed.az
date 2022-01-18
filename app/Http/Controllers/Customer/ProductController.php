<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Request;

class ProductController extends Controller
{
    public function index($slug_product_name)
    {
        $product = Product::select('product.*', DB::raw('avg(rating.rating) AS rating_avg'))
            ->leftJoin('rating', 'rating.product_id', 'product.id')
            ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
            ->whereSlug($slug_product_name)
            ->orderBy('updated_at', 'desc')
            ->groupBy('rating.product_id')
            ->firstOrFail();
        $categories = $product->categories()->distinct()->get();
        $images = $product->image()->distinct()->get();

        return view('customer.pages.product', compact('product', 'categories', 'images'));
    }

    public function search()
    {
        $wanted = request()->input('wanted');
        $products = Product::where('product_name', 'like', "%$wanted%")
            ->orWhere('product_description', 'like', "%$wanted%")
            ->paginate(8);
        request()->flash();
        return view('customer.pages.search', compact('products'));
    }
    public function new_products(){
        echo "Yeni mehsullar";
        echo mktime(time(), 'Y:m:d H:m:s');
        // $products = Product::select("product.*")
        //     ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
        //     ->where('product.created_at', '>', "2020-08-16 00:57:18")
        //     ->get();
        
        // echo "<pre>";  
        // print_r($products);  
        // echo "</pre>";  
    }
    public function compare(){
        return view('customer.pages.compare');
    }
    public function add_to_compare (){
        $cookie_name = "compare";
        $message = "";
        if(isset($_COOKIE[$cookie_name])){
            $cookie = explode("-", $_COOKIE[$cookie_name]);
            if(!in_array(request()->get('id'), $cookie)){
                $cookie_value = $_COOKIE[$cookie_name] . '-' . request()->get('id');
            }
            else{
                $message = "Bu məhsul artıq müqayisəyə əlavə edilib.";
                $cookie_value = $_COOKIE[$cookie_name];
            }
        }
        else{
            $cookie_value = request()->get('id');
        }
        setcookie($cookie_name, $cookie_value, time() + (86400*5), "/");
        if($message === ""){
            $message = "Məhsul müqayisəyə əlavə edildi.";
        }
        echo $message;
    }
    public function view_compare (){
        $cookie = $_COOKIE['compare'];
        $compare = explode("-", $cookie);
        $products =[];
        for($i=0; $i<count($compare); $i++){
            $products2 = Product::select("*")
                ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
                ->where('product.id', $compare[$i])
                ->firstOrFail();
            array_push($products, $products2);
        }
        
        
        return view('customer.pages.single_product', compact('products'));
    }
    public function remove_from_compare()
    {
        $id = request()->get('id');
        $cookie_name = "compare";
        $cookie = $_COOKIE[$cookie_name];
        $array = explode("-", $cookie);
        $array = array_merge(array_diff($array, array($id)));
        if(count($array) > 0)
        {
            $cookie_value = "";
            for($i=0; $i<count($array); $i++)
            {
                
                if($i !== count($array)-1)
                {
                    $cookie_value .= $array[$i] .'-';
                }
                else
                {
                    $cookie_value .= $array[$i];
                }
            }
            setcookie($cookie_name, $cookie_value, time() + (86400*5), "/");
        }
        else
        {
            unset($_COOKIE[$cookie_name]);
            setcookie($cookie_name, null, -1, '/');
        }
    }

    public function review ()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'email' => 'required|min:8',
            'review' => 'required|min:3',
            'product_id' => 'required'
        ]);
        
        Review::create([
            'name' => request('name'),
            'email' => request('email'),
            'review' => request('review'),
            'rating' => request('rating'),
            'product_id' => request('product_id')
        ]);
        return back();
    }
    public function reviews(){
        $page = request('page');
        $product_id = request('product_id');
        $page = ($page -1)*3;
        $reviews = Review::where('product_id', $product_id)->orderBy('created_at', 'desc')->offset($page)->limit(3)->get();
        $output = '';
        foreach ($reviews as $review) {
            $ratings = "";
            for ($i=1; $i <=5; $i++) { 
                if($i > $review->rating){
                    $color = '-o empty';
                }
                else{
                    $color = '';
                }
                $ratings .= "<i title=". $i ." class='fa fa-star" . $color . "'></i>";
            }
            $output .= "<div class='single-review'>
            <div class='review-heading'>
                <div><a href='#'><i class='fa fa-user-o'></i> " . $review->name . " </a></div>
                <div><a href='#'><i class='fa fa-clock-o'></i> " . $review->created_at . " </a></div>
                <div class='review-rating pull-right'>
                " . $ratings . "
                </div>
            </div>
            <div class='review-body'>
                <p>" . $review->review . "</p>
            </div>
        </div>";
        }
        $reviews_count = Review::where('product_id', $product_id)->count();
        // echo $output;
        return ['reviews' => $output, 'count' => $reviews_count];
    }

}
