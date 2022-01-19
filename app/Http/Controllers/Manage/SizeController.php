<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SizeController extends Controller
{
    public function index()
    {
        return view('manage.pages.size.index');
    }

    public function index_data()
    {
        $rows = Size::leftJoin('size_product', 'size.id', '=', 'size_product.size_id')
            ->leftJoin('product', 'product.id', '=', 'size_product.product_id')
            ->select([
                'size.*',
                DB::raw('count(size_product.size_id) as size_products')
            ])->groupBy('size_product.size_id', 'size.id');
        return DataTables::eloquent($rows)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                return '<div>
                <a href="javascript:void(0);" class="btn btn-xs btn-primary edit" id="' . $row->id . '"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                <a href="javascript:void(0);" class="btn btn-xs btn-danger delete" id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                </div>';
            })
            ->addColumn('checkbox', '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />')
            ->rawColumns(['checkbox', 'action'])
            ->toJson();
    }

    public function post_data(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'name' => Rule::unique('size')->ignore($request->get('id'))
        ]);

        $error_array = array();
        $success_output = '';

        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $messages) {
                $error_array[] = $messages;
            }
        } else {
            if ($request->get('button_action') == "insert") {
                $form = new Size([
                    'name' => $request->get('name'),
                ]);
                $form->save();
                $success_output = '<div class="alert alert-success">' . __('admin.Data Inserted') . '</div>';
            }

            if ($request->get('button_action') == "update") {
                $rows = Size::find($request->get('id'));
                $rows->name = $request->get('name');
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
        $rows = Size::find($id);
        $output = array(
            'name' => $rows->name,
        );
        echo json_encode($output);
    }

    public function delete_data(Request $request)
    {
        $rows = Size::find($request->input('id'));
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = Size::whereIn('id', $id_array);
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }
}
