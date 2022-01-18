<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class EnvelopeController extends Controller
{
    public function index(){
        return view('manage.pages.envelope.index');
    }
    
    public function index_data()
    {
        $rows = Contact::select(['contacts.*']);
        return DataTables::eloquent($rows)
            ->addColumn('action', function ($row) {
                return '<div>
                        <a href="javascript:void(0);" class="btn btn-sm btn-primary view" data-id="' . $row->id .'"> <i class="fa fa-eye"></i> Bax</a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger delete"  id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                        </div>';
                
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />';
                
            })
            ->rawColumns(['checkbox', 'action'])
            ->toJson();
    }
    public function view(){
        $rows = Contact::select(['contacts.*'])
            ->where('contacts.id', request('id'))
            ->first();
        return $rows;
    }
}
