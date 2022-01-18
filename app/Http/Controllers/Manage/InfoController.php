<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Illuminate\Http\Request;
use Image;


class InfoController extends Controller
{
    public function index(){
        return view('manage.pages.info.index');
    }
    public function save(Request $request)
    {
        $data = $request->except('_token', 'logo', 'favicon');

        if (request()->hasFile('logo')) {
            $logo = request()->file('logo');

            $filename = 'logo.' . $logo->extension();

            $destinationPath = 'assets/img/';
            $logo->move($destinationPath, $filename);
            $data['logo'] = $filename;

        }
        if (request()->hasFile('favicon')) {
            $logo = request()->file('favicon');

            $filename = 'favicon.' . $logo->extension();

            $destinationPath = 'assets/img/';
            $logo->move($destinationPath, $filename);
            $data['favicon'] = $filename;
        }

        Info::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with(['message_icon' => 'check', 'message_type' => 'success', 'message' => 'Məlumat yeniləndi']);
    }
}
