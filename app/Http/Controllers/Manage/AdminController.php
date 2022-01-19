<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PasswordReset;
use App\Mail\ResetPasswordAdmin;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function login()
    {
        if (request()->isMethod('POST')) {
            // Auth::guard('customer')->logout();
            // request()->session()->flush();
            // request()->session()->regenerate();
            $this->validate(request(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            
            $admin = Admin::where('email', request('email'))->first();
            $admin_count = Admin::where('email', request('email'))->count();
            if($admin_count === 0){
                return back()->withInput()->withErrors(['email' => __('admin.Incorrect entry')]);
            }
            $credentials = [
                'email' => request()->get('email'),
                'password' => request()->get('password'),
                'is_active' => 1,
                'is_manage' => $admin->is_manage
            ];

            if (Auth::guard('manage')->attempt($credentials, request()->has('rememberme'))) {
                return redirect()->route('manage.homepage');
            } else {
                return back()->withInput()->withErrors(['email' => __('admin.Incorrect entry')]);
            }
            
        }
        return view('manage.pages.login');
    }

    public function logout()
    {
        Auth::guard('manage')->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('manage.login');
    }

    public function index()
    {
        return view('manage.pages.admin.index');
    }

    public function index_data()
    {
        $rows = Admin::select(['admin.*', DB::raw("CONCAT(admin.first_name,' ',admin.last_name) as name")]);
        return DataTables::eloquent($rows)
            ->filterColumn('name', function ($query, $keyword) {
                $sql = "CONCAT(admin.first_name,' ',admin.last_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->editColumn('is_active', function ($row) {
                $output = '<span class="label label-' . (($row->is_active == 1) ? 'success' : 'warning') . '">';
                $output .= ($row->is_active == 1) ? __('admin.Active') : __('admin.Passive');
                $output .= '</span>';
                return $output;
            })
            ->editColumn('is_manage', function ($row) {
                if($row->is_manage == 1){
                    $bg = "success";
                }
                elseif($row->is_manage == 2){
                    $bg = "info";
                }
                elseif($row->is_manage == 3){
                    $bg = "primary";
                }
                
                $output = '<span class="label label-' . $bg . '">';
                
                if($row->is_manage == 1){
                    $output .= "Admin";
                }
                elseif($row->is_manage == 2){
                    $output .= "Demo";
                }
                elseif($row->is_manage == 3){
                    $output .= "Istifadəçi";
                }
                $output .= '</span>';
                return $output;
            })
            ->addColumn('action', function ($row) {
                if(auth('manage')->id() !== $row->id)
                {
                    return '<div>
                        <a href="' . route('manage.admin.edit', $row->id) . '" class="btn btn-sm btn-primary edit"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger delete"  id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                        </div>';
                }
                else
                {
                    return '<div>
                        <a href="' . route('manage.admin.edit', $row->id) . '" class="btn btn-sm btn-primary edit"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                        </div>';
                }
                
            })
            ->addColumn('checkbox', function($row){
                if(auth('manage')->id() !== $row->id)
                {
                    return '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />';
                }
                else
                {
                    return null;
                }
            })
            ->rawColumns(['checkbox', 'is_active', 'is_manage', 'action'])
            ->toJson();
    }

    public function form($id = 0)
    {
        $entry = new Admin;
        if ($id > 0) {
            $entry = Admin::find($id);
        }
        return view('manage.pages.admin.form', compact('entry'));
    }

    public function save($id = 0)
    {
        if($id > 0){
            $entry = Admin::where('email', request('email'))->firstOrFail();
            if($entry->id == $id){
                $this->validate(request(), [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'mobile' => 'required',
                    'email' => 'required|email'
                ]);
            }
            else{
                $this->validate(request(), [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'mobile' => 'required',
                    'email' => 'required|email|unique:admin,email'
                ]); 
            }
            
        }
        else{
            $this->validate(request(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'mobile' => 'required',
                'email' => 'required|email|unique:admin,email'
            ]);
        }
        

        $data = request()->only('first_name', 'last_name', 'email', 'mobile', 'address', 'city', 'state', 'country', 'zip_code', 'phone');

        if (request()->filled('password')) {
            $data['password'] = Hash::make(request('password'));
        }
        $data['is_active'] = request()->has('is_active') && request('is_active') == 1 ? 1 : 0;
        // $data['is_manage'] = request()->has('is_manage') && request('is_manage') == 1 ? 1 : 0;


        // 1 Admin qeydiyyati guard('manage'), 2 Istifadeci qeydiyyati(Musteri) - guard('customer')
        $data['is_manage'] = request('is_manage');
        
        if ($id > 0) {
            $entry = Admin::where('id', $id)->firstOrFail();
            $entry->update($data);
        } else {
            $entry = Admin::create($data);
        }

        return redirect()
            ->route('manage.admin.edit', $entry->id)
            ->with('message_type', 'success')
            ->with('message', $id > 0 ? __('admin.Updated') : __('admin.Saved'));
    }

    public function delete_data(Request $request)
    {
        $rows = Admin::find($request->input('id'));
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = Admin::whereIn('id', $id_array);
        if ($rows->delete()) {
            echo __('admin.Data Deleted');
        }
    }
    public function forgot(){
        if (request()->isMethod('POST')) {
            // $admin = Admin::where('email', '=', request('email'))->first();
            $count =Admin::where('email', '=', request('email'))->count();

            if ($count == 0) {
                return redirect()->back()->withErrors(['email' => trans('İstifadəçi mövcud deyil')]);
            }

            $token = Str::random(60);
            PasswordReset::insert([
                'email' =>request('email'),
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            $reset = ['link' => route('manage.recovery.password', [$token, request('email')])];
            Mail::to(request('email'))->send(new ResetPasswordAdmin($reset));
            return redirect()
                ->route('manage.login')
                ->with('message_type', 'success')
                ->with('message', 'Məlumat emailinizə göndərildi.');
        }
        else{
            return view('manage.pages.forgot_password');
        }

    }
    public function recovery($token, $email){
        $count = PasswordReset::where('email', $email)
            ->where('token', $token)
            ->where('deleted_at', NULL)
            ->count();
        if($count > 0){
            return view('manage.pages.recovery_password', [
                'email' => $email,
                'token' => $token
            ]);
        }
        else{
            return redirect()
                ->route('manage.login')
                ->withErrors(['Bu link artıq mövcud deyil.']);
        }

    }
    public function change(){

        $this->validate(request(), [
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        Admin::where('email', request('email'))->update([
            'password' => Hash::make(request('password')),
        ]);

        PasswordReset::where('email', request('email'))
            ->where('token', request('token'))
            ->delete();

        return redirect()
                ->route('manage.login')
                ->with('message_type', 'success')
                ->with('message', 'Şifrəniz uğurla dəyişdirildi.');
    }

}
