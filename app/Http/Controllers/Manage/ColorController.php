<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ColorController extends Controller
{
    public function index()
    {
        return view('manage.pages.color.index');
    }

    public function index_data()
    {
        $rows = Color::leftJoin('color_product', 'color.id', '=', 'color_product.color_id')
            ->leftJoin('product', 'product.id', '=', 'color_product.product_id')
            ->select([
                'color.*',
                DB::raw('count(color_product.color_id) as color_products')
            ])->groupBy('color_product.color_id', 'color.id');
        return DataTables::eloquent($rows)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if($row->id != 1){
                    return '<div>
                    <a href="javascript:void(0);" class="btn btn-xs btn-primary edit" id="' . $row->id . '"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                    <a href="javascript:void(0);" class="btn btn-xs btn-danger delete" id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                    </div>';
                }
                else{
                    return '<div>
                    <a href="javascript:void(0);" class="btn btn-xs btn-primary edit" id="' . $row->id . '"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                    </div>';
                }

            })
            ->editColumn('name', function ($row) {

                return '<span style="background-color: '.$row->name.'">'.$row->name.'</span>';

            })
            ->addColumn('checkbox', function($row){
                if($row->id != 1){
                    return '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />';
                }
                else{
                    return '';
                }
            })
            ->rawColumns(['checkbox', 'name', 'action'])
            ->toJson();
    }

    public function post_data(Request $request)
    {
        $data = request()->only('title', 'name');

        if (request()->filled('name')) {
            $data['name'] = request('name');
            request()->merge(['name' => $data['name']]);
        }
        else{
            $data['name'] = request('name_code');
            request()->merge(['name' => $data['name']]);
        }
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'name' => 'required',
            'name' => Rule::unique('color')->ignore($request->get('id'))
        ]);

        $error_array = array();
        $success_output = '';

        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $messages) {
                $error_array[] = $messages;
            }
        } else {
            if ($request->get('button_action') == "insert") {
                $form = new color($data);
                $form->save();
                $success_output = '<div class="alert alert-success">' . __('admin.Data Inserted') . '</div>';
            }

            if ($request->get('button_action') == "update") {
                $rows = Color::find($request->get('id'))->update($data);
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
        $rows = Color::find($id);
        $output = array(
            'name' => $rows->name,
            'title' => $rows->title,
        );
        echo json_encode($output);
    }

    public function delete_data(Request $request)
    {
        $rows = Color::find($request->input('id'));
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = Color::whereIn('id', $id_array);
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }
}
