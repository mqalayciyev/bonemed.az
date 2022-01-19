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

        ShippingReturn::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with(['message_icon' => 'check', 'message_type' => 'success', 'message' => 'Məlumat yeniləndi']);
    }
}
