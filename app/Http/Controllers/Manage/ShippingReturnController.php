<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\ShippingReturn;
use Illuminate\Http\Request;

class ShippingReturnController extends Controller
{
    public function index(){
        return view('manage.pages.shipping_return.index');
    }
    public function save(Request $request)
    {
        $data = $request->except('_token');
        $update = ShippingReturn::find(1);
        $update->update($data);
        
        if ($update) {
            $request->session()->flash('message_icon', 'check');
            $request->session()->flash('message_type', 'success');
            $request->session()->flash('message', 'Məlumat yeniləndi');
        } else {
            $request->session()->flash('message_icon', 'warning');
            $request->session()->flash('message_type', 'warning');
            $request->session()->flash('message', 'Xəta! Zəhmət olmasa bir daha cəhd edin');
        }
        return back();
    }
}
