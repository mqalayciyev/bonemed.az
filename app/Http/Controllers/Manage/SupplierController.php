<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        return view('manage.pages.supplier.index');
    }

    public function index_data()
    {
        $rows = Supplier::leftJoin('supplier_product', 'supplier.id', '=', 'supplier_product.supplier_id')
            ->leftJoin('product', 'product.id', '=', 'supplier_product.product_id')
            ->select([
                'supplier.*',
                DB::raw('count(supplier_product.supplier_id) as supplier_products')
            ]);
        $rows->groupBy('supplier_product.supplier_id', 'supplier.id');
        return DataTables::eloquent($rows)
            ->addColumn('action', function ($row) {
                if(auth('manage')->user()->is_manage == 2){
                    $disabled = 'none';
                }
                else{
                    $disabled = '';
                }
                return '<div>
                <a href="' . route('manage.supplier.edit', $row->id) . '" class="btn btn-xs btn-primary edit"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
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
            'name' => 'required|unique:supplier,name'
        ]);

        $error_array = array();
        $success_output = '';

        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $messages) {
                $error_array[] = $messages;
            }
        } else {
            $form = new Supplier([
                'name' => $request->get('name'),
            ]);
            $form->save();
            $success_output = '<div class="alert alert-success">' . __('admin.Data Inserted') . '</div>';
        }
        $output = array(
            'error' => $error_array,
            'success' => $success_output
        );

        echo json_encode($output);
    }

    public function form($id = 0)
    {
        $entry = new Supplier;
        if ($id > 0) {
            $entry = Supplier::find($id);
        }

        return view('manage.pages.supplier.form', compact('entry'));
    }

    public function save($id = 0)
    {

        $data = request()->only('name', 'description', 'first_name', 'last_name', 'markup', 'company', 'email', 'phone', 'mobile', 'fax', 'website', 'street', 'postcode', 'state', 'country');

        $this->validate(request(), [
            'name' => 'required'
        ]);

        if ($id > 0) {
            $entry = Supplier::where('id', $id)->firstOrFail();
            $entry->update($data);
        } else {
            $entry = Supplier::create($data);
        }

        return redirect()
            ->route('manage.supplier.edit', $entry->id)
            ->with('message_type', 'success')
            ->with('message', $id > 0 ? __('admin.Updated') : __('admin.Saved'));
    }

    public function delete_data(Request $request)
    {
        $rows = Supplier::find($request->input('id'));
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = Supplier::whereIn('id', $id_array);
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

}
