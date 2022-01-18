<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{
    public function index($brand_name){
        
        $brands = Product::select('*')
            ->leftJoin('brand_product', 'brand_product.product_id', 'product.id')
            ->leftJoin('brand', 'brand.id', 'brand_product.brand_id')
            ->orderBy('brand.name', 'asc')
            ->groupBy('brand.name')
            ->get();
        $brands_count = array();
        for($i=0; $i< count($brands); $i++){
            $count = DB::table('brand_product')->select('*')
                ->leftJoin("product", 'product.id', 'brand_product.product_id')
                ->where('brand_id', $brands[$i]->id)
                ->where('deleted_at', null)->count();;
            $item = ['id' => $brands[$i]->id, 'count' => $count];
            array_push($brands_count, $item);
        }
        return view('customer.pages.brands', compact('brands', 'brand_name', 'brands_count'));
    }
    public function brands(){
        $brand_name = request('brand_name');
        $products = Product::select('product.*')
            ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
            ->leftJoin('brand_product', 'brand_product.product_id', 'product.id')
            ->leftJoin('brand', 'brand.id', 'brand_product.brand_id')
            ->where('brand.name', "LIKE", '%'.$brand_name.'%')
            ->get();
        return view('customer.pages.single_product', compact('products'));
    }
    public function brand_sorting(){
        $brand_name = request('brand_name');
        // $brand = Brand::where('slug', $brand_name)->firstOrFail();
        $products = Product::select('*')
            ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
            ->leftJoin('brand_product', 'brand_product.product_id', 'product.id')
            ->leftJoin('brand', 'brand.id', 'brand_product.brand_id')
            ->where('name', $brand_name)
            ->orderBy(request('sorting_name'), request('order'))
            ->get();
        return view('customer.pages.single_product', compact('products'));
    }
    public function size_filter()
    {
        $size = request('size');
        $brand_name = request('brand_name');
        // $category = Category::where('slug', $slug_category_name)->firstOrFail();
        $products = [];
        
        for($i=0; $i<count($size); $i++){
            $products1 = Product::select('*')
                ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
                ->leftJoin('category_product', 'category_product.product_id', 'product.id')
                ->leftJoin('brand_product', 'brand_product.product_id', 'product.id')
                ->leftJoin('brand', 'brand.id', 'brand_product.brand_id')
                ->where('product_detail.'.$size[$i], 1)
                ->where('name', $brand_name)
                ->orderBy('product.updated_at', 'desc')
                ->get();
            if(!in_array($products1, $products)){
                array_push($products, $products1);
            }
            
        }
        $products = $products[0];
        return view('customer.pages.single_product', compact('products'));
    }
    public function color_filter()
    {
        $color = request('color');
        $brand_name = request('brand_name');
        $products = [];
        $products = Product::select('*')
            ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
            ->leftJoin('category_product', 'category_product.product_id', 'product.id')
            ->leftJoin('brand_product', 'brand_product.product_id', 'product.id')
            ->leftJoin('brand', 'brand.id', 'brand_product.brand_id')
            ->where('product_detail.'.$color, 1)
            ->where('name', $brand_name)
            ->orderBy('product.updated_at', 'desc')
            ->get();
        return view('customer.pages.single_product', compact('products'));
    }
    public function price_filter()
    {
        $minmax_price = request('values');
        $min_price = $minmax_price[0];
        $max_price = $minmax_price[1];
        $brand_name = request('brand_name');
        $products = Product::select('*')
            ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
            ->leftJoin('category_product', 'category_product.product_id', 'product.id')
            ->leftJoin('brand_product', 'brand_product.product_id', 'product.id')
            ->leftJoin('brand', 'brand.id', 'brand_product.brand_id')
            ->where('sale_price', '<', $max_price)
            ->where('sale_price', '>', $min_price)
            ->where('name', $brand_name)
            ->orderBy('product.updated_at', 'desc')
            ->get();
        
        return view('customer.pages.single_product', compact('products'));
    }
}
