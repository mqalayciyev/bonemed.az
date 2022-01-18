<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\UserDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index()
    {
        return view('manage.pages.user.index');
    }

    public function index_data()
    {
        $rows = User::select(['user.*', DB::raw("CONCAT(user.first_name,' ',user.last_name) as name")]);
        return DataTables::eloquent($rows)
            ->filterColumn('name', function ($query, $keyword) {
                $sql = "CONCAT(user.first_name,' ',user.last_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            
            ->editColumn('is_active', function ($row) {
                $output = '<span class="label label-' . (($row->is_active == 1) ? 'success' : 'warning') . '">';
                $output .= ($row->is_active == 1) ? __('admin.Active') : __('admin.Passive');
                $output .= '</span>';
                return $output;
            })
            ->editColumn('is_manage', function ($row) {
                $output = '<span class="label label-' . (($row->is_manage == 1) ? 'success' : 'warning') . '">';
                $output .= ($row->is_manage == 1) ? __('admin.Active') : __('admin.Passive');
                $output .= '</span>';
                return $output;
            })
            ->addColumn('manage', function ($row) {
                $id = $row->manage;
                $manage = Admin::find($id);
                $output = '<span>';
                $output .= $manage->first_name . ' ' . $manage->last_name;
                $output .= '</span>';
                return $output;
            })
            ->addColumn('action', function ($row) {
                if(auth('manage')->user()->is_manage == 2){
                    $disabled = 'none';
                }
                else{
                    $disabled = '';
                }
                return '<div>
                <a href="' . route('manage.user.edit', $row->id) . '" class="btn btn-sm btn-primary edit"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                <a href="javascript:void(0);" class="btn btn-sm btn-danger delete" style="display: ' . $disabled .'" id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                </div>';
            })
            ->addColumn('checkbox', '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />')
            ->rawColumns(['checkbox', 'is_active', 'is_manage', 'action', 'manage'])
            ->toJson();
    }

    public function form($id = 0)
    {
        $entry = new User;
        if ($id > 0) {
            $entry = User::find($id);
        }
        return view('manage.pages.user.form', compact('entry'));
    }

    public function save($id = 0)
    {
        if ($id > 0) {
            $this->validate(request(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email'
            ]);
        } 
        else {
            $this->validate(request(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:user,email'
            ]);
        }
        

        $data = request()->only('first_name', 'last_name', 'email', 'mobile');

        if (request()->filled('password')) {
            $data['password'] = Hash::make(request('password'));
        }
        $data['is_active'] = request()->has('is_active') && request('is_active') == 1 ? 1 : 0;
        // $data['is_manage'] = request()->has('is_manage') && request('is_manage') == 1 ? 1 : 0;

        if ($id > 0) {
            $entry = User::where('id', $id)->firstOrFail(); 
            $entry->update($data);
            $entry->save();
        } 
        else {
            $entry = User::create($data);
            $entry->save();
        }

        UserDetail::updateOrCreate(
            ['user_id' => $entry->id],
            [
                'address' => request('address'),
                'country' => request('country'),
                'state' => request('state'),
                'city' => request('city'),
                'zip_code' => request('zip_code'),
                'phone' => request('phone')
            ]
        );

        return redirect()
            ->route('manage.user.edit', $entry->id)
            ->with('message_type', 'success')
            ->with('message', $id > 0 ? __('admin.Updated') : __('admin.Saved'));
    }

    public function delete_data(Request $request)
    {
        $rows = User::find($request->input('id'));
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = User::whereIn('id', $id_array);
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

}
