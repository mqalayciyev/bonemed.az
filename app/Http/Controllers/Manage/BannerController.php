<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Image;
use Yajra\DataTables\Facades\DataTables;

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
                $image = '<img src="';
                $image .= $row->banner_image != null ? asset("img/banners/" . $row->banner_image) : "http://via.placeholder.com/69x50?text=BannerPhoto(360x260)";
                $image .= '" class="img-responsive" style="width: 158px; height:50px;">';
                return $image;
            })
            ->addColumn('action', function ($row) {
                if(auth('manage')->user()->is_manage == 2){
                    $disabled = 'none';
                }
                else{
                    $disabled = '';
                }
                return '<div>
                <input type="hidden" name="sort_order" id="sort_order" value="' . $row->id . '"/>
                <a href="' . route('manage.banner.edit', $row->id) . '" class="btn btn-sm btn-primary edit"> <i class="fa fa-edit"></i> ' . __('admin.Edit') . '</a>
                <a href="javascript:void(0);" class="btn btn-sm btn-danger delete" style="display: ' . $disabled .'" id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
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

    public function save($id = null)
    {
        $data = request()->only('banner_name', 'banner_slug', 'banner_active');
        $this->validate(request(), [
            'banner_name' => 'required',
            'banner_slug' => 'required',
        ]);
        if ($id > 0) {
            $this->validate(request(), [
                'banner_name' => 'sometimes|required|unique:banners,banner_name,' . $id
            ]);
        } else {
            $this->validate(request(), [
                'banner_name' => 'required|unique:banners',
            ]);
        }
        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $banner_name = request()->post('banner_name');
            /*if (substr($image, 0, 22) == 'data:image/jpeg;base64') {
                list($type, $image) = explode(';', $image);
                list(, $image) = explode(',', $image);
                $image = base64_decode($image);
            }*/
            $filename = str_slug($banner_name) . ".jpg";
            $path = public_path('img/banners/' . $filename);
            ini_set('memory_limit', '-1');
            $background = Image::canvas(704, 252);
            $background->fill('#fff');
            $img = Image::make($image);
            $background->insert($img, 'center');
            $background->resize(704, null, function ($constraint) {
                $constraint->aspectRatio();
            })->crop(704, 252);
            $background->save($path);
            // $background->save($path, 75);
            $data['banner_image'] = $filename;
        }
        if ($id > 0) {
            $flight = Banner::find($id);
            $flight->update($data);
        } else {
            $data['banner_order'] = Banner::where('deleted_at', null)->count() + 1;
            $flight = Banner::create($data);
        }
        return redirect()
            ->route('manage.banner.edit', $flight->id)
            ->with('message_icon', 'check')
            ->with('message_type', 'success')
            ->with('message', $id ? __('admin.Updated') : __('admin.Saved'));
    }

    public function delete_data(Request $request)
    {
        $rows = Banner::find($request->input('id'));
        if ($rows->forceDelete()) {
            echo __('admin.Data Deleted');
        }
    }

    public function mass_remove(Request $request)
    {
        $id_array = $request->input('id');
        $rows = Banner::whereIn('id', $id_array);
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
