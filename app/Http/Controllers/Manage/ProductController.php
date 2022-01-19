<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\SizeProduct;
use App\Models\Color;
use App\Models\ColorProduct;
use App\Models\Supplier;
use App\Models\Tag;
use Illuminate\Http\Request;
use Image;
use Yajra\DataTables\Facades\DataTables;


class ProductController extends Controller
{
    public function index()
    {
        return view('manage.pages.product.index');
    }

    public function index_data()
    {
        //leftJoin('product_image', 'product_image.product_id', '=', 'product.id')-> SILINDI.
        $rows = Product::leftJoin('brand_product', 'product.id', '=', 'brand_product.product_id')
            ->leftJoin('brand', 'brand.id', '=', 'brand_product.brand_id')
            ->select([
                'product.*',
                'brand.name',
            ]);
        return DataTables::eloquent($rows)
            ->editColumn('image_name', function ($row) {
                $image = '<img src="';
                $image .= $row->image->image_name != null ? asset("img/products/" . $row->image->image_name) : "http://via.placeholder.com/50x50?text=ProductPhoto";
                $image .= '" class="img-responsive" style="width: 50px; height:50px;">';
                return $image;
            })
            ->addColumn('action', function ($row) {

                return '<div>
                <a href="' . route('manage.product.edit', $row->id) . '" class="btn btn-sm btn-primary edit"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                <a href="javascript:void(0);" class="btn btn-sm btn-danger delete" id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                </div>';
            })
            ->addColumn('checkbox', '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />')
            ->rawColumns(['checkbox', 'image_name', 'action'])
            ->toJson();
    }

    public function filter($id)
    {
        return view('manage.pages.product.filter', compact('id'));
    }

    public function filter_data($id)
    {
        $rows = Product::leftJoin('product_image', 'product_image.product_id', '=', 'product.id')
            ->leftJoin('brand_product', 'product.id', '=', 'brand_product.product_id')
            ->leftJoin('brand', 'brand.id', '=', 'brand_product.brand_id')
            ->select([
                'product.*',
                'brand.name',
            ]);
        $rows->where('brand_product.brand_id', $id);

        return DataTables::eloquent($rows)
            ->editColumn('image_name', function ($row) {
                $image = '<img src="';
                $image .= $row->image->image_name != null ? asset("img/products/" . $row->image->image_name) : "http://via.placeholder.com/50x50?text=ProductPhoto";
                $image .= '" class="img-responsive" style="width: 50px; height:50px;">';
                return $image;
            })
            ->addColumn('action', function ($row) {
                return '<div>
                <a href="' . route('manage.product.edit', $row->id) . '" class="btn btn-sm btn-primary edit"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                <a href="javascript:void(0);" class="btn btn-sm btn-danger delete" id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                </div>';
            })
            ->addColumn('checkbox', '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />')
            ->rawColumns(['checkbox', 'image_name', 'action'])
            ->toJson();
    }

    public function form($id = 0)
    {
        $entry = new Product;
        $product_categories = [];
        $product_brands = [];
        $product_colors = [];
        $product_sizes = [];
        if ($id > 0) {
            $entry = Product::find($id);
            $product_categories = $entry->categories()->pluck('category_id')->all();
            $product_brands = $entry->brands()->pluck('brand_id')->all();
            $product_colors = $entry->colors()->pluck('color_id')->all();
            $product_sizes = $entry->sizes()->pluck('size_id')->all();
        }

        $entry_category = new Category();

        $categories = Category::all();
        $brands = Brand::orderBy('name', 'asc')->get();
        // $tags = Tag::orderBy('name', 'asc')->get();
        $sizes = Size::all();
        $colors = Color::all();
        $images = ProductImage::all();

        return view('manage.pages.product.form', compact('entry', 'product_colors', 'product_sizes', 'categories', 'product_categories', 'images', 'brands', 'colors', 'sizes', 'entry_category', 'product_brands'));
    }
    public function categories(){
        $categories = Category::all();
        $output = '';
        foreach($categories as $category){
            
            if($category->top_id==null){
                $output .= '<option style="color:#000;" value="' . $category->id .'">' . $category->category_name . '</option>';
                foreach($categories as $alt_category){
                    if($alt_category->top_id==$category->id){
                        $output .= '<option value="' . $alt_category->id .'"> -- ' . $alt_category->category_name . '</option>';
                        
                    }
                }
            }
            
        }
        echo $output;
    }

    public function save($id = 0)
    {

        $data = request()->only('product_name', 'meta_title', 'meta_discription', 'slug', 'product_description', 'stok_piece', 'supply_price', 'markup', 'retail_price', 'discount', 'sale_price', 'point_of_sale');

        if (!request()->filled('slug')) {
            $data['slug'] = str_slug(request('product_name'));
            request()->merge(['slug' => $data['slug']]);
        }

        $this->validate(request(), [
            'product_name' => 'required',
            'supply_price' => 'required',
            'categories' => 'required',
            'brand' => 'required',
            'stok_piece' => 'required',
            'retail_price' => 'required',
            'sale_price' => 'required',
            'slug' => (request('original_slug') != request('slug') ? 'unique:product,slug' : '')
        ]);

        $data_detail = request()->only('show_new_collection', 'show_hot_deal', 'show_best_seller', 'show_latest_products', 'show_deals_of_the_day', 'show_picked_for_you', 'color_red', 'color_black', 'color_white', 'color_green', 'color_orange', 'color_blue', 'color_pink', 'color_yellow', 'color_cyan', 'color_grey');

        $categories = request('categories');
        $exits_category = Category::where('category_name', $categories)->first();
        if ($exits_category) {
            $categories = array(
                $exits_category->id
            );
        }
        $brands = request('brand');
        $exits_brand = Brand::where('name', $brands)->first();
        if ($exits_brand) {
            $brands = array(
                $exits_brand->id
            );
        }
        // $tags_old = request('tag');
        // if ($tags_old) {
        //     $tags = array();
        //     foreach ($tags_old as $tag) {
        //         $exists_tag = Tag::where('name', $tag)->first();
        //         if ($exists_tag) {
        //             array_push($tags, $exists_tag->id);
        //         } else {
        //             $form = Tag::create([
        //                 'name' => $tag
        //             ]);
        //             $form->save();
        //             $exists_tag = Tag::where('name', $tag)->first();
        //             array_push($tags, $exists_tag->id);
        //         }
        //     }
        // }


        $colors_old = request('color');
        
        if ($colors_old) {
            $colors = array();
            foreach ($colors_old as $color) {
                $exists_color = Color::where('name', $color)->first();
                if ($exists_color) {
                    array_push($colors, $exists_color->id);
                }
            }
        }
        $sizes_old = request('size');
        if ($sizes_old) {
            $sizes = array();
            foreach ($sizes_old as $size) {
                $exists_size = Size::where('name', $size)->first();
                if ($exists_size) {
                    array_push($sizes, $exists_size->id);
                }
            }
        }

        if ($id > 0) {
            $entry = Product::where('id', $id)->firstOrFail();
            $entry->update($data);
            $entry->detail()->update($data_detail);
            $entry->categories()->sync($categories);
            $entry->brands()->sync($brands);
            if ($sizes_old) {
                $entry->sizes()->sync($sizes);
            }
            else{
                SizeProduct::where('product_id', $entry->id)->delete();
            }
            if ($colors_old) {
                $entry->colors()->sync($colors);
            }
            else{
                ColorProduct::where('product_id', $entry->id)->delete();
            }
            // if ($tags_old) {
            //     $entry->tags()->sync($tags);
            // }
        } else {
            $entry = Product::create($data);
            $entry->detail()->create($data_detail);
            $entry->categories()->attach($categories);
            $entry->brands()->attach($brands);$entry->brands()->attach($brands);
            if ($sizes_old) {
                $entry->sizes()->attach($sizes);
            }
            if ($colors_old) {
                $entry->colors()->attach($colors);
            }
            // if ($tags_old) {
            //     $entry->tags()->attach($tags);
            // }
        }

        if (request()->hasFile('product_images')) {
            $images = ProductImage::where('product_id', $id)->first();
            if($images){
                
                $image_path = app_path("img/products/{$images->image_name}");
                $image_path2 = app_path("img/products/{$images->thumb_name}");
                $image_path3 = app_path("img/products/{$images->main_name}");
                if(file_exists($image_path))
                {
                    unlink($image_path);
                }
                if(file_exists($image_path2))
                {
                    unlink($image_path2);
                }
                if(file_exists($image_path3))
                {
                    unlink($image_path3);
                }
            }
            

            $product_images = request()->file('product_images');
            $product_images = request()->product_images;
            // $cover = request()->cover;
            // $count = 0;

            foreach ($product_images as $array => $product_image) {
                $filename = 'product-' . $array . '_' . $entry->id . '_' . time() . '.' . $product_image->extension();
                $filename_main = 'main_product-' . $array . '_' . $entry->id . '_' . time() . '.' . $product_image->extension();
                $filename_thumb = 'thumb_product-' . $array . '_' . $entry->id . '_' . time() . '.' . $product_image->extension();
                if ($product_image->isValid()) {
                    $path = public_path('img/products/' . $filename);
                    $path_main = public_path('img/products/' . $filename_main);
                    $path_thumb = public_path('img/products/' . $filename_thumb);

                    $square = Image::canvas(1000, 1000, array(255, 255, 255));

                    $img = Image::make($product_image->getRealPath())
                        ->resize(700, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    $square->insert($img, 'center');
                    $square->save($path_main);
                    $square->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path_thumb);

                    $rectangle = Image::canvas(270, 360, array(255, 255, 255));
                    $img_rec = Image::make($product_image->getRealPath())
                        ->resize(280, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    $rectangle->insert($img_rec, 'center');
                    $rectangle->save($path);

                    $product_image_model = new ProductImage;
                    $product_image_model->product_id = $entry->id;
                    $product_image_model->image_name = $filename;
                    
                    
                    $product_image_model->main_name = $filename_main;
                    $product_image_model->thumb_name = $filename_thumb;
                    $product_image_model->save();
                    
                }

            }
        }

        return redirect()
            ->route('manage.product.edit', $entry->id)
            ->with('message_type', 'success')
            ->with('message', $id > 0 ? __('admin.Updated') : __('admin.Saved'));
    }

    public function delete_data(Request $request)
    {
        $rows = Product::find($request->input('id'));
        $images = ProductImage::where('product_id', $rows->id);
        $image_path = app_path("img/products/{$images->image_name}");
        $image_path2 = app_path("img/products/{$images->thumb_name}");
        $image_path3 = app_path("img/products/{$images->main_name}");
        if(file_exists($image_path))
        {
            unlink($image_path);
        }
        if(file_exists($image_path2))
        {
            unlink($image_path2);
        }
        if(file_exists($image_path3))
        {
            unlink($image_path3);
        }
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = Product::whereIn('id', $id_array);
        foreach ($rows as $row) {
            $images = ProductImage::where('product_id', $row->id);
            $image_path = app_path("img/products/{$images->image_name}");
            $image_path2 = app_path("img/products/{$images->thumb_name}");
            $image_path3 = app_path("img/products/{$images->main_name}");
            if(file_exists($image_path))
            {
                unlink($image_path);
            }
            if(file_exists($image_path2))
            {
                unlink($image_path2);
            }
            if(file_exists($image_path3))
            {
                unlink($image_path3);
            }
        }
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function load_images(Request $request)
    {
        $id = $request->get('id');
        $images = ProductImage::where('product_id', $id)->get();
        if (count($images) > 0) {
            foreach ($images as $array => $image) {
                $output = '<div class="img_border" style="position: relative; display: inline-block;">
                            <div class="preview_img" style="display: inline-block;">
                                <img src="';
                $output .= $image->image_name != null ? asset("img/products/" . $image->image_name) : "http://via.placeholder.com/50x50?text=ProductPhoto";

                $output .= '" class="thumbnail pull-left img-responsive" style="height:100px; margin-right:20px;">';
                $output .= '</div>
                            <div class="btn_close" id="' . $image->id . '"
                                 style="display: inline-block; position: absolute; left: 5px; z-index: 1;">
                                <i class="fa fa-close"></i>
                            </div>
                        </div>';
                echo $output;
            }

        } else {
            echo __('admin.There is no any photos');
        }
    }

    public function remove_image(Request $request)
    {
        $image_id = $request->get('id');
        $image_rows = ProductImage::find($image_id);
        $image_path = app_path("img/products/{$image_rows->image_name}");
        $image_path2 = app_path("img/products/{$image_rows->thumb_name}");
        $image_path3 = app_path("img/products/{$image_rows->main_name}");
        if(file_exists($image_path))
        {
            unlink($image_path);
        }
        if(file_exists($image_path2))
        {
            unlink($image_path2);
        }
        if(file_exists($image_path3))
        {
            unlink($image_path3);
        }
        $image_rows->delete();
    }

}