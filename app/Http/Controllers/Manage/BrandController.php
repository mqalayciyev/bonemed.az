<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{

    public function index()
    {
        return view('manage.pages.brand.index');
    }

    public function index_data()
    {
        $brands = Brand::select([
            'brand.*',
            DB::raw('count(brand_product.brand_id) as brand_products')
        ])
            ->leftJoin('brand_product', 'brand.id', '=', 'brand_product.brand_id')
            ->leftJoin('product', 'product.id', '=', 'brand_product.product_id')
            ->groupBy('brand_product.brand_id', 'brand.id');
        return DataTables::eloquent($brands)
            ->addColumn('action', function ($brand) {
                if(auth('manage')->user()->is_manage == 2){
                    $disabled = 'none';
                }
                else{
                    $disabled = '';
                }
                return '<div>
                <a href="' . route('manage.product.filter', $brand->id) . '" class="btn btn-xs btn-success see"> <i class="fa fa-eye"></i> ' . __('admin.See') . '</a>
                <a href="javascript:void(0);" class="btn btn-xs btn-primary edit" id="' . $brand->id . '"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                <a href="javascript:void(0);" class="btn btn-xs btn-danger delete" style="display: ' . $disabled .'" id="' . $brand->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                </div>';
            })
            ->addColumn('checkbox', '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />')
            ->rawColumns(['checkbox', 'action'])
            ->toJson();
    }

    public function post_data(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:brand,name'
        ]);

        $error_array = array();
        $success_output = '';

        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $messages) {
                $error_array[] = $messages;
            }
        } else {
            if ($request->get('button_action') == "insert") {
                $form = new Brand([
                    'name' => $request->get('name'),
                    'description' => $request->get('description'),
                ]);
                $form->save();
                $success_output = '<div class="alert alert-success">' . __('admin.Data Inserted') . '</div>';
            }

            if ($request->get('button_action') == "update") {
                $rows = Brand::find($request->get('id'));
                $rows->name = $request->get('name');
                $rows->description = $request->get('description');
                $rows->save();
                $success_output = '<div class="alert alert-success">' . __('admin.Data Updated') . '</div>';
            }

        }
        $output = array(
            'error' => $error_array,
            'success' => $success_output
        );

        echo json_encode($output);
    }

    public function fetch_data(Request $request)
    {
        $id = $request->input('id');
        $rows = Brand::find($id);
        $output = array(
            'name' => $rows->name,
            'description' => $rows->description
        );
        echo json_encode($output);
    }

    public function delete_data(Request $request)
    {
        $rows = Brand::find($request->input('id'));
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = Brand::whereIn('id', $id_array);
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

}
