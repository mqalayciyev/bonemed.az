@extends('manage.layouts.master')
@section('title', __('admin.Banner Manager'))
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
    <script src="https://cdn.ckeditor.com/4.9.1/basic/ckeditor.js"></script>
    <style>
        .panel{
            margin-top: 25px;
        }
        .images{
            margin: 5px;
            width: max-content;
            border: 1px solid silver;
            padding: 5px;
            border-radius: 5px;
            position: relative;
            float: left;
        }
        .images > img{
            height: 50px;
            width: 50px;
        }
        .images > span{
            font-size: 20px;
            font-weight: bold;
            position: absolute;
            left: -6px;
            top: -13px;
            cursor: pointer;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        #change-color .colors{
            border: 2px solid transparent;
            padding: 0px;
            width: 38px;
            height: 38px;
            border-radius: 100%;
            margin: 0px;
            display: flex;
            justify-content: center;
            transition: 0.4s;
        }
        #change-color .colors:hover{
            border: 2px solid #00A2E8!important;
            padding: 0px;
            width: 38px;
            height: 38px;
            border-radius: 100%;
            margin: 0px;
            display: flex;
            justify-content: center;
        }
        #change-color .colors span{
            align-self: center;
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
        }

    </style>
@endsection
@section('content')
    @if (@$manage == 2)
    <!-- Demo Admin -->
        @php
            $disabled = "disabled"
        @endphp
    @else
        @php
            $disabled = ""
        @endphp
    @endif
    <form action="{{ route('manage.banner.save', @$flight->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <section class="content-header">
            <h1 class="pull-left">@lang('admin.Banner')</h1>
            <div class="pull-right">
                @if($flight->id>0)
                    <a href="{{ route('manage.banner.new') }}"
                       class="btn btn-success"> @lang('admin.Add New Banner')</a>
                    <button type="submit" {{ $disabled }} class="btn btn-info"><i
                            class="fa fa-refresh"></i> @lang('admin.Update')</button>
                @else
                    <a href="{{ route('manage.banner') }}"
                       class="btn btn-default"> @lang('admin.Cancel')</a>
                    <button type="submit" {{ $disabled }} class="btn btn-success"><i
                            class="fa fa-plus"></i> @lang('admin.Save')</button>
                @endif
            </div>
            <div class="clearfix"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            @include('general.back.alert')
            @include('general.back.validate')
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-body box-primary">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <div class="form-group">
                                        <label for="banner_name">@lang('admin.Banner Name')</label>
                                        <input type="text" class="form-control" id="banner_name"
                                               placeholder="@lang('admin.Banner Name')"
                                               name="banner_name"
                                               value="{{ old('banner_name', $flight->banner_name) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="banner_slug">@lang('admin.Banner Slug')</label>
                                        <input type="text" class="form-control" id="banner_slug"
                                               placeholder="@lang('admin.Banner Slug')"
                                               name="banner_slug"
                                               value="{{ old('banner_slug', $flight->banner_slug) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="banner_active">@lang('admin.Active')</label>
                                        <select name="banner_active" id="banner_active" class="form-control">
                                            <option value="1" {{ $flight->banner_active ? 'selected' : '' }}>@lang('admin.Active')</option>
                                            <option value="0" {{ !$flight->banner_active ? 'selected' : '' }}>@lang('admin.Passive')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="image">@lang('admin.Upload Image')</label>
                                    <input type="file" name="image" class="btn btn-success">
                                    {{--<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-success">
                                        @lang('admin.Upload New Image')
                                    </button>
                                    <div class="modal fade" id="modal-success">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">@lang('admin.Upload New Image')</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div style="width: 100%">
                                                        <div>
                                                            <label for="product_images">@lang('admin.Upload Image')</label><br>
                                                            <input type="file" id="image" name="has_image">
                                                        </div>
                                                        <div class="text-center">
                                                            <div id="upload-demo"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="upload-image btn btn-success" data-dismiss="modal" type="button"> Şəkili əlavə et</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>--}}
                                    <div class="thumbnail img-rounded" id="cropped_image">
                                        <img src="{{ $flight->banner_image != null ? asset("img/banners/" . $flight->banner_image)
                                         : 'http://via.placeholder.com/360x260?text=BannerPhoto(360x260)' }}" class="img-rounded img-responsive">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
    <script type="text/javascript">
        var resize = $('#upload-demo').croppie({
            enableExif: false,
            enableOrientation: true,
            viewport: {width: 360, height: 260},
            boundary: {width: 568, height: 379}
        });
        $('#image').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                resize.croppie('bind', {
                    url: e.target.result
                });
            };
            reader.readAsDataURL(this.files[0]);
        });

        $('.upload-image').on('click', function (ev) {
            const croppie = resize.croppie('result', {type: 'base64', size: [360, 260], format: 'jpeg', quality: 0.75, circle: false});
            croppie.then(function (img) {
                $("#cropped_image").html(`
                                <img src="` + img + `" class="img-rounded img-responsive">
                            <input type="hidden" name="banner_image" value="` + img + `"> `);
            });
        });
    </script>
@endsection
