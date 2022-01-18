<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class CategoryController extends Controller
{
    public function index($slug_category_name)
    {
        $category = Category::where('slug', $slug_category_name)->firstOrFail();
        $sub_categories = Category::where('top_id', $category->id)->get();
        
        $sub_categories_count = array();
        for($i=0; $i< count($sub_categories); $i++){
            
            $count = DB::table('category_product')->select('*')
                ->leftJoin("product", 'product.id', 'product_id')
                ->where('category_id', $sub_categories[$i]->id)
                ->where('deleted_at', null)->count();
            $item = ['id' => $sub_categories[$i]->id, 'count' => $count];
            array_push($sub_categories_count, $item);
        }

        $brands = Brand::select('brand.*')
            ->leftJoin('brand_product', 'brand_product.brand_id', 'brand.id')
            ->leftJoin('product', 'product.id', 'brand_product.product_id')
            ->leftJoin('category_product', 'category_product.product_id', 'product.id')
            ->leftJoin('category', 'category.id', 'category_product.category_id')
            ->where('category_product.category_id', $category->id)
            ->orderBy('brand.name', 'asc')
            ->groupBy('brand.name')
            ->get();
        
        $brands_count = array();
        for($i=0; $i< count($brands); $i++){
            
            $count = DB::table('brand_product')->select('*')
                ->leftJoin("product", 'product.id', 'brand_product.product_id')
                ->where('brand_id', $brands[$i]->id)
                ->where('deleted_at', null)->count();
            $item = ['id' => $brands[$i]->id, 'count' => $count];
            array_push($brands_count, $item);
        }

        return view('customer.pages.category', compact('category', 'sub_categories', 'brands', 'slug_category_name', 'brands_count', 'sub_categories_count'));
    }

    public function products()
    {
        $slug_category_name = request('category_name');
        $category = Category::where('slug', $slug_category_name)->firstOrFail();
        $category_sub = Category::where('top_id', $category->id)->get();
        $category_product = DB::table('category_product')->where('category_id', $category->id)->get();
        
        $products1 = Product::select('product.*')
            ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
            ->leftJoin('category_product', 'category_product.product_id', 'product.id')
            ->where('category_product.category_id', $category->id)
            ->get();
        
        $products = [];
        for($i = 0; $i<count($category_sub); $i++){
            $products2 = Product::select('product.*')
            ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
            ->leftJoin('category_product', 'category_product.product_id', 'product.id')
            ->where('category_product.category_id', $category_sub[$i]->id)
            ->orderBy('product.updated_at', 'desc')
            ->get();
            for($i=0; $i<count($products2); $i++){
                array_push($products, $products2[$i]);
            }
        }
        for($i=0; $i<count($products1); $i++){
            array_push($products, $products1[$i]);
        }
        
        return view('customer.pages.single_product', compact('products'));
    }

    public function price_filter()
    {
        $minmax_price = request('values');
        $min_price = $minmax_price[0];
        $max_price = $minmax_price[1];
        $slug_category_name = request('category_name');
        $category = Category::where('slug', $slug_category_name)->firstOrFail();
        $category_sub = Category::where('top_id', $category->id)->get();
        $products1 = Product::select('product.*')
            ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
            ->leftJoin('category_product', 'category_product.product_id', 'product.id')
            ->where('category_product.category_id', $category->id)
            ->where('sale_price', '<', $max_price)
            ->where('sale_price', '>', $min_price)
            ->orderBy('product.updated_at', 'desc')
            ->get();
        
        $products = [];
        for($i = 0; $i<count($category_sub); $i++){
            $products2 = Product::select('product.*')
            ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
            ->leftJoin('category_product', 'category_product.product_id', 'product.id')
            ->where('category_product.category_id', $category_sub[$i]->id)
            ->where('sale_price', '<', $max_price)
            ->where('sale_price', '>', $min_price)
            ->orderBy('product.updated_at', 'desc')
            ->get();
            for($i=0; $i<count($products2); $i++){
                array_push($products, $products2[$i]);
            }
        }
        for($i=0; $i<count($products1); $i++){
            array_push($products, $products1[$i]);
        }
        return view('customer.pages.single_product', compact('products'));
    }

    public function brand_filter()
    {
        $id = request('id');
        $slug_category_name = request('category_name');
        $category = Category::where('slug', $slug_category_name)->firstOrFail();
        $products = Product::select('product.*')
            ->leftJoin('brand_product', 'brand_product.product_id', 'product.id')
            ->leftJoin('brand', 'brand.id', 'brand_product.brand_id')
            ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
            ->leftJoin('category_product', 'category_product.product_id', 'product.id')
            ->where('category_product.category_id', $category->id)
            ->where('brand_product.brand_id', $id)
            ->orderBy('product.updated_at', 'desc')
            ->get();
        return view('customer.pages.single_product', compact('products'));
    }
    public function size_filter()
    {
        $size = request('size');
        $slug_category_name = request('category_name');
        $category = Category::where('slug', $slug_category_name)->firstOrFail();
        $products = [];
        
        for($i=0; $i<count($size); $i++){
            $products1 = Product::select('*')
                ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
                ->leftJoin('category_product', 'category_product.product_id', 'product.id')
                ->where('category_product.category_id', $category->id)
                ->where('product_detail.'.$size[$i], 1)
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
        $slug_category_name = request('category_name');
        $category = Category::where('slug', $slug_category_name)->firstOrFail();
        $products = [];
        $products = Product::select('*')
                ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
                ->leftJoin('category_product', 'category_product.product_id', 'product.id')
                ->where('category_product.category_id', $category->id)
                ->where('product_detail.'.$color, 1)
                ->orderBy('product.updated_at', 'desc')
                ->get();
        return view('customer.pages.single_product', compact('products'));
    }

    public function category_sorting()
    {
        $slug_category_name = request('category_name');
        $category = Category::where('slug', $slug_category_name)->firstOrFail();
        $products = Product::select('product.*', DB::raw('avg(rating.rating) AS rating_avg'))
            ->leftJoin('rating', 'rating.product_id', 'product.id')
            ->leftJoin('product_detail', 'product_detail.product_id', 'product.id')
            ->leftJoin('category_product', 'category_product.product_id', 'product.id')
            ->where('category_product.category_id', $category->id)
            ->orderBy(request('sorting_name'), request('order'))
            ->groupBy('rating.product_id')
            ->get();
        return view('customer.pages.single_product', compact('products'));
    }

}