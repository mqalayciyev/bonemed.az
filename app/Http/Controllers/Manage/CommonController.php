<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function ckEditorProductUpload()
    {
        try {
            $task = new Product();
            $task->id = 0;
            $task->exists = true;
            $image = $task->addMediaFromRequest('upload')->toMediaCollection('images');

            return response([
                "url" => $image->getUrl('thumb')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function ckEditorSliderUpload()
    {
        try {
            $task = new Slider();
            $task->id = 0;
            $task->exists = true;
            $image = $task->addMediaFromRequest('upload')->toMediaCollection('images');

            return response([
                "url" => $image->getUrl('thumb')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
