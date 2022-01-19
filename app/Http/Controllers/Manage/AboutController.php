<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(){
        return view('manage.pages.about.index');
    }
    public function save(Request $request)
    {

        $data = $request->except('_token');

        About::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with(['message_icon' => 'check', 'message_type' => 'success', 'message' => 'Məlumat yeniləndi']);
    }
}
