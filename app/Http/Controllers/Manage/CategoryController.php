<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        $entry = new Category;
        $categories = Category::all();
        return view('manage.pages.category.index', compact('categories', 'entry'));
    }

    public function index_data()
    {
        $rows = Category::select(['id', 'top_id', 'category_name', 'slug', 'created_at', 'updated_at']);
        return DataTables::eloquent($rows)
            ->addColumn('parent_category', function ($row) {
                return $row->top_category->category_name;
            })
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
            ->orderColumn('parent_category', '-top_id $1')
            ->rawColumns(['checkbox', 'action'])
            ->toJson();
    }

    public function post_data(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);

        $error_array = array();
        $success_output = '';

        $data = request()->only('category_name', 'slug', 'top_id');
        if (!request()->filled('slug')) {
            $data['slug'] = str_slug(request('category_name'));
            request()->merge(['slug' => $data['slug']]);
        }

        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $messages) {
                $error_array[] = $messages;
            }
        } else {
            if ($request->get('button_action') == "insert") {
                Category::create($data);
                $success_output = '<div class="alert alert-success">' . __('admin.Data Inserted') . '</div>';
            }

            if ($request->get('button_action') == "update") {

                $entry = Category::where('id', $request->get('id'))->firstOrFail();
                $entry->update($data);
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
        $rows = Category::find($id);
        $output = array(
            'category_name' => $rows->category_name,
            'slug' => $rows->slug,
            'top_id' => $rows->top_id,
        );
        echo json_encode($output);
    }

    public function delete_data(Request $request)
    {
        $rows = Category::find($request->input('id'));
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = Category::whereIn('id', $id_array);
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }
}
