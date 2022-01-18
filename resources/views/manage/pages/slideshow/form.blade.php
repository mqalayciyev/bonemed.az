@extends('manage.layouts.master')
@section('title',__('admin.Slider Manager'))
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
    <form id="slider-form" add-edit="{{ @$flight->id }}">
        @csrf
        <section class="content-header">
            <h1 class="pull-left">@lang('admin.Slider')</h1>
            <div class="pull-right">
                @if($flight->id>0)
                    <a href="{{ route('manage.slider.new') }}"
                       class="btn btn-success"> @lang('admin.Add New Slider')</a>
                    <button type="submit" {{ $disabled }} class="btn btn-info"><i
                            class="fa fa-refresh"></i> @lang('admin.Update')</button>
                @else
                    <a href="{{ route('manage.slider') }}"
                       class="btn btn-default"> @lang('admin.Cancel')</a>
                    <button type="submit" {{ $disabled }} class="btn btn-success"><i
                            class="fa fa-plus"></i> @lang('admin.Save')</button>
                @endif
            </div>
            <div class="clearfix"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            {{-- @include('general.back.alert')
            @include('general.back.validate') --}}
            <div class="w-100 response"></div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-body box-primary">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="uploadimageModal" class="col-12 p-0" role="dialog">
                                        <div class="modal-content border-0">
                                            <div class="modal-body ">
                                                <div class="col-12 p-0">
                                                    <div class=" text-center">
                                                        <div id="image_demo" class="w-100" style=" margin-top:30px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">@lang('admin.Upload Image')</label>
                                        <input type="file" name="image" id="upload_image">
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="slider_name">@lang('admin.Slider Name')</label>
                                        <input type="text" class="form-control" id="slider_name"
                                               placeholder="@lang('admin.Slider Name')"
                                               name="slider_name"
                                               value="{{ old('slider_name', $flight->slider_name) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="slider_slug">@lang('admin.Slider Slug')</label>
                                        <input type="text" class="form-control" id="slider_slug"
                                               placeholder="@lang('admin.Slider Slug')"
                                               name="slider_slug"
                                               value="{{ old('slider_slug', $flight->slider_slug) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="slider_active">@lang('admin.Active')</label>
                                        <select name="slider_active" id="slider_active" class="form-control">
                                            <option value="1" {{ $flight->slider_active ? 'selected' : '' }}>@lang('admin.Active')</option>
                                            <option value="0" {{ !$flight->slider_active ? 'selected' : '' }}>@lang('admin.Passive')</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 form-group">
                                    <label for="image">@lang('admin.Upload Image')</label>
                                    <input type="file" name="image" class="btn btn-success"> --}}
                                    {{-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-success">
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
                                    </div> --}}
                                    {{-- <div class="thumbnail img-rounded" id="cropped_image">
                                        <img src="{{ $flight->slider_image != null ? asset("img/sliders/" . $flight->slider_image)
                                         : 'http://via.placeholder.com/1140x360?text=SliderPhoto(1140x360)' }}" class="img-rounded img-responsive">
                                    </div>
                                </div> --}}
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
       $(document).ready(() => {
        var resize = $("#slider-form #image_demo").croppie({
            viewport: { width: 780, height: 300, type: "" },
            boundary: { width: 790, height: 310 },
            showZoomer: true,
            enableResize: false,
            enableOrientation: true,
            mouseWheelZoom: "ctrl",
        });
        var url = "";
        $("#slider-form #upload_image").on("change", function () {
            var reader = new FileReader();

            reader.onload = function (event) {
                url = event.target.result;
                resize.croppie("bind", {
                        url: event.target.result,
                    }).then(function () {
                        console.log("jQuery bind complete");
                    });
            };
            reader.readAsDataURL(this.files[0]);
        });


        $("#slider-form").submit(function (event) {
            event.preventDefault();
            resize.croppie("result", {
                    type: "canvas",
                    size: {width: 1560, height: 550},
                    format: 'jpg',
                    quality: 1,
                }).then(function (image) {
                    let id = $("#slider-form").attr('add-edit')
                    let slider_active = $("#slider_active").val()
                    let slider_name = $("#slider_name").val()
                    let slider_slug = $("#slider_slug").val()
                    $.ajax({
                            url: "{{ route('manage.slider.save') }}",
                            type: "POST",
                            data: {"_token": "{{ csrf_token() }}", image, url, id, slider_active, slider_slug, slider_name},
                            success: function(data) {
                                console.log(data);
                                if(data.status == 'success'){
                                    $("#slider-form .response").html(`
                                    <div class="alert alert-success">${data.message}</div>
                                    `)
                                }
                            },
                            error: function(data) {
                                console.log(data);
                                if(data.responseJSON.status == 'error'){
                                    $("#slider-form .response").html(`
                                    <div class="alert alert-danger">Məlumat əlavə edilmədi. Ətraflı (Console Log - F12)</div>
                                    `)
                                }
                                console.log(data.responseJSON.message);

                            }
                        });
                });
        });
    });
    </script>
@endsection
