<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Review;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
{
    

    public function index()
    {
        return view('manage.pages.review.index');
    }

    public function index_data()
    {
        $rows = Review::select(['reviews.*']);
        return DataTables::eloquent($rows)
            ->editColumn('product', function ($row) {
                $product = Product::where('id', $row->product_id)->first();
                $image = '<img src="';
                $image .= $product->image->image_name != null ? asset("img/products/" . $product->image->image_name) : "http://via.placeholder.com/50x50?text=ProductPhoto";
                $image .= '" class="img-responsive" style="width: 50px; height:50px;">';
                return $image;
            })
            ->editColumn('product_name', function ($row) {
                $product = Product::where('id', $row->product_id)->first();
                $product_name = '<label>';
                $product_name .= $product->product_name;
                $product_name .= '</label>';
                return $product_name;
            })
            ->addColumn('action', function ($row) {
                return '<div>
                        <a href="javascript:void(0);" class="btn btn-sm btn-primary view" data-id="' . $row->id .'"> <i class="fa fa-eye"></i> Bax</a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger delete"  id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                        </div>';
                
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />';
                
            })
            ->rawColumns(['checkbox', 'product', 'product_name', 'action'])
            ->toJson();
    }
    public function view(){
        $rows = Review::select(['reviews.*'])
            ->leftJoin('product', 'product.id', 'reviews.product_id')
            ->where('reviews.id', request('id'))
            ->first();
        return $rows;
    }
    public function delete_data(Request $request)
    {
        $rows = Review::find($request->input('id'));
        if ($rows->forceDelete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = Review::whereIn('id', $id_array);
        if ($rows->forceDelete()) {
            echo __('admin.Data Deleted');
        }
    }
}
