<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File; 

class BannerController extends Controller
{
    public function index()
    {
        return view('manage.pages.banner.index');
    }

    public function index_data()
    {
        $rows = Banner::select(['banners.*']);

        return DataTables::eloquent($rows)
            ->editColumn('banner_image', function ($row) {
                $logo = '50x50';
                if($row->type == 1){
                    $logo = '310x188';
                }
                elseif($row->type == 2){
                    $logo = '1200x350';
                }
                elseif($row->type == 3){
                    $logo = '380x250';
                }
                $image = '<img src="';
                $image .= $row->banner_image != null ? asset("img/banners/" . $row->banner_image) : "http://via.placeholder.com/" . $logo;
                $image .= '" class="img-responsive" style="width: 130px; min-width: 100%; height: auto;">';
                return $image;
            })
            ->addColumn('action', function ($row) {

                return '<div>
                <input type="hidden" name="sort_order" id="sort_order" value="' . $row->id . '"/>
                <a href="' . route('manage.banner.edit', [$row->id]) . '" class="btn btn-sm btn-primary edit"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                <a href="javascript:void(0);" class="btn btn-sm btn-danger delete"  id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                </div>';
            })
            ->addColumn('checkbox', '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />')
            ->rawColumns(['checkbox', 'banner_image', 'action'])
            ->toJson();
    }

    public function form($id = null)
    {

        $flight = new Banner;
        if ($id > 0) {
            $flight = Banner::find($id);
        }
        return view('manage.pages.banner.form', compact('flight'));
    }

    public function save()
    {

        $id = request('id');

        if($id == 0){
            $validator = Validator::make(request()->all(), [
                'image' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Şəkil boş ola bilməz']);
            }
        }

        $data = request()->only('banner_slug', 'banner_active');



        if (request()->hasFile('image')) {

            $rows = Banner::find($id);
            if($rows){
                $image_path = app_path("img/banners/{$rows->banner_image}");
            if (File::exists($image_path)) {
                unlink($image_path);
            }
            }
            

            $image = request()->file('image');
            $image = request()->image;

            $filename = 'banner_' . time().'.webp';

            $path = public_path('img/banners/' . $filename);
            $square = Image::canvas(704, 252, array(255, 255, 255));

            $img = Image::make($image->getRealPath())
                        ->resize(704, null, function ($constraint) {
                        $constraint->aspectRatio();
            });
            $square->insert($img, 'center');
            $square->save($path);

            $data['banner_image'] = $filename;
        }
        if ($id > 0) {
            $flight = Banner::find($id);
            $flight->update($data);
            $message = 'Məlumat yeniləndi';
        } else {
            $validator = Validator::make(request()->all(), [
                'image' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Link boş ola bilməz']);
            }

            $data['banner_order'] = Banner::where('deleted_at', null)->count() + 1;
            $flight = Banner::create($data);
            $message = 'Məlumat əlavə edildi';
        }
        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function delete_data(Request $request)
    {
        $rows = Banner::find($request->input('id'));

        $image_path = app_path("img/banners/{$rows->banner_image}");
        if (File::exists($image_path)) {
            unlink($image_path);
        }       
        
        if ($rows->forceDelete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = Banner::whereIn('id', $id_array);
        foreach ($rows as $row) {
            $image_path = app_path("img/banners/{$row->banner_image}");
            if (File::exists($image_path)) {
                unlink($image_path);
            }
        }
        if ($rows->forceDelete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function reorder()
    {
        $serialize = request('serialize');
        $ids = explode("&sort_order=", $serialize);
        foreach ($ids as $index => $id) {
            if ($index == 0) {
                continue;
            }
            $id = (int)$id;
            $flight = Banner::find($id);
            $flight->banner_order = $index;
            $flight->save();
        }
    }
}
