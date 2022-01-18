<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    public function index()
    {
        return view('manage.pages.tag.index');
    }

    public function index_data()
    {
        $rows = Tag::leftJoin('tag_product', 'tag.id', '=', 'tag_product.tag_id')
            ->leftJoin('product', 'product.id', '=', 'tag_product.product_id')
            ->select([
                'tag.*',
                DB::raw('count(tag_product.tag_id) as tag_products')
            ])->groupBy('tag_product.tag_id', 'tag.id');
        return DataTables::eloquent($rows)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if(auth('manage')->user()->is_manage == 2){
                    $disabled = 'none';
                }
                else{
                    $disabled = '';
                }
                return '<div>
                <a href="javascript:void(0);" class="btn btn-xs btn-primary edit" id="' . $row->id . '"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                <a href="javascript:void(0);" class="btn btn-xs btn-danger delete" style="display: ' . $disabled .'" id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                </div>';
            })
            ->addColumn('checkbox', '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />')
            ->rawColumns(['checkbox', 'action'])
            ->toJson();
    }

    public function post_data(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:tag,name'
        ]);

        $error_array = array();
        $success_output = '';

        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $messages) {
                $error_array[] = $messages;
            }
        } else {
            if ($request->get('button_action') == "insert") {
                $form = new Tag([
                    'name' => $request->get('name'),
                ]);
                $form->save();
                $success_output = '<div class="alert alert-success">' . __('admin.Data Inserted') . '</div>';
            }

            if ($request->get('button_action') == "update") {
                $rows = Tag::find($request->get('id'));
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
        $rows = Tag::find($id);
        $output = array(
            'name' => $rows->name,
        );
        echo json_encode($output);
    }

    public function delete_data(Request $request)
    {
        $rows = Tag::find($request->input('id'));
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = Tag::whereIn('id', $id_array);
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }
}
