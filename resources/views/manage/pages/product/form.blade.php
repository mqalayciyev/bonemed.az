@extends('manage.layouts.master')
@section('title', __('admin.Product Manager'))
@section('head')
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
            height: 100px;
            width: 100px;
        }
        .images > span{
            font-size: 20px;
            font-weight: bold;
            position: absolute;
            left: -6px;
            top: -13px;
            cursor: pointer;
        }
        .mt-3{
            margin-top: 1rem;
        }
        .images:hover::before{
            content: " ";
            width: 110px;
            height: 110px;
            border-radius: 5px;
            position: absolute;
            top: 0px;
            left: 0px;
            background-color: white;
            opacity: 0.7;
        }
        .cover{
            position: absolute;
            bottom: 0px;
            left: 0px;
            width: 110px;
            height: 25px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            background-color: silver;
            text-align: center;
            padding: 5px;
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

    <div class="modal" id="category_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="category_form">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">@lang('admin.Add New Category')</h4>
                    </div>
                    <div class="modal-body">
                        <span id="form_output"></span>
                        <div class="form-group">
                            <label for="top_id">@lang('admin.Top Category')</label>
                            <select name="top_id" id="top_id" class="form-control">
                                <option value="">@lang('admin.Parent Category')</option>
                                @foreach($categories as $category)
                                    @if($category->top_id==null)
                                        <option style="color:#000;"
                                                value="{{ $category->id }}" {{ $entry_category->top_category->id == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}</option>
                                        @foreach($categories as $alt_category)
                                            @if($alt_category->top_id==$category->id)
                                                <option value="{{ $alt_category->id }}" {{ $entry_category->top_category->id == $alt_category->id ? 'selected' : '' }}>
                                                    -- {{ $alt_category->category_name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_name">@lang('admin.Category Name')</label> <br>
                            <input type="text" name="category_name" class="form-control category_name"
                                   id="category_name" placeholder="@lang('admin.Category Name')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="button_action" id="button_action"
                               value="insert"/>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">@lang('admin.Close')</button>
                        <input type="submit" name="submit"  id="action"
                               class="btn btn-success add_category"
                               value="@lang('admin.Save Category')"/>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="form_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="form" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">@lang('admin.Add New Brand')</h4>
                    </div>
                    <div class="modal-body">
                        <span id="form_output"></span>
                        <div class="form-group">
                            <label for="name">@lang('admin.Brand Name')</label> <br>
                            <input type="text" name="name" class="form-control name"
                                   id="name" placeholder="@lang('admin.Brand Name')"
                                   value="{{ old('name') }}">
                            <input type="hidden" name="slug" value="">
                            <input type="hidden" name="id" value="" id="id">
                        </div>
                        <div class="form-group">
                            <label for="description">@lang('admin.Description')</label>
                            <br>
                            <textarea class="form-control" name="description" rows="5"
                                      id="description"
                                      placeholder="@lang('admin.Description')">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="button_action" id="button_action"
                               value="insert"/>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">@lang('admin.Close')</button>
                        <input type="submit" name="submit"  id="action"
                               class="btn btn-success add_brand"
                               value="@lang('admin.Save Brand')"/>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <form id="product-form" action="{{ route('manage.product.save', @$entry->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <section class="content-header">
            <h1 class="pull-left">@lang('admin.Product')</h1>
            <div class="pull-right">
                @if($entry->id>0)
                    <a href="{{ route('manage.product.new') }}"
                       class="btn btn-success"> @lang('admin.Add New Product')</a>
                    <button type="submit"  class="btn btn-info"><i
                                class="fa fa-refresh"></i> @lang('admin.Update')</button>
                @else
                    <a href="{{ route('manage.product') }}"
                       class="btn btn-default"> @lang('admin.Cancel')</a>
                    <button type="submit"  class="btn btn-success"><i
                                class="fa fa-plus"></i> @lang('admin.Save')</button>
                @endif
            </div>
            <div class="clearfix"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-body box-primary">
                        @include('common.errors.validate_admin')
                        @include('common.alert')
                        <div class="container">
                            <div class="jumbotron">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>@lang('admin.General')</h3>
                                        <span>@lang('admin.Change general information for this product.')</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_name">@lang('admin.Product Name')</label>
                                                    <input type="text" class="form-control" id="product_name"
                                                           placeholder="@lang('admin.Product Name')"
                                                           name="product_name"
                                                           value="{{ old('product_name', $entry->product_name) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="visibility: hidden">
                                                <div class="form-group">
                                                    <label for="slug">@lang('admin.Slug')</label>
                                                    <input type="hidden" name="original_slug"
                                                           value="{{ old('slug', $entry->slug) }}">
                                                    <input type="text" class="form-control" id="slug"
                                                           placeholder="@lang('admin.Slug')"
                                                           name="slug"
                                                           value="{{ old('slug', $entry->slug) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="product_description">@lang('admin.Description')</label>
                                                    <textarea class="form-control" id="product_description"
                                                              placeholder="@lang('admin.Description')"
                                                              name="product_description">{{ old('product_description', $entry->product_description) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="meta-view" class="panel panel-default" style="border-radius: 0px;">
                                            <div class="panel-body">
                                                <p class="title" style="margin: 0; color: blue;"></p>
                                                <p class="url" style="word-wrap: break-word; color: green; font-size: 15px; font-weight: 200; margin: 0;">
                                                    {{ env('APP_URL') . 'product/' . $entry->slug }}
                                                </p>
                                                <small class="discription"></small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="meta-description">Seo description</label>
                                                    <input type="text" id="meta-discription" name="meta_discription" placeholder="Məhsulun təsviri qısa mətn." class="form-control" value="{{ old('meta_title', $entry->meta_discription) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="meta-title">Seo keywords</label>
                                                    <input type="text" id="meta-title" name="meta_title" placeholder="məhsul, məhsul-açıqlama, keywords, product, məhsul adı," class="form-control" value="{{ old('meta_title', $entry->meta_title) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="categories">@lang('admin.Categories')</label>
                                                    <select name="categories" id="categories"
                                                            class="form-control select2"
                                                            data-placeholder="@lang('admin.Select category')"
                                                            style="width: 100%;">
                                                        <option></option>
                                                        @foreach($categories as $category)
                                                            @if($category->top_id==null)
                                                                <option class="text text-primary"
                                                                        value="{{ $category->id }}" {{ collect(old('categories', $product_categories))->contains($category->id) ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                                                @foreach($categories as $alt_category)
                                                                    @if($alt_category->top_id==$category->id)
                                                                        <option class="text text-primary"
                                                                                value="{{ $alt_category->id }}" {{ collect(old('categories', $product_categories))->contains($alt_category->id) ? 'selected' : '' }}>
                                                                            {{ $alt_category->category_name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="brand">@lang('admin.Brand')</label>
                                                    <select class="form-control select2" style="width: 100%;"
                                                            id="brand"
                                                            name="brand"
                                                            data-placeholder="@lang('admin.Choose a brand')">
                                                        <option></option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{ old('brand',$brand->name) }}" {{ collect(old('brand', $product_brands))->contains($brand->id) ? 'selected' : '' }}>{{ old('brand',$brand->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="product_images">@lang('admin.Upload Images')</label><br>
                                                    <small>@lang('admin.Drag to rearrange. Drop an image outside of the upload area to delete.')</small>
                                                    <input type="file" id="product_images" name="product_images[]"
                                                           multiple="true">
                                                    <hr>
                                                    <div id="all_images"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>@lang('admin.Inventory')</h3>
                                        <span>@lang('admin.The type of product we choose determines how we manage inventory and reporting.')</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="supplier">@lang('admin.Supply Price') (AZN)</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-right numeric"
                                                               id="supply_price"
                                                               name="supply_price"
                                                               placeholder="0.00"
                                                               value="{{ old('supply_price', $entry->supply_price) }}">
                                                        <span class="input-group-addon">₼</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="supplier">@lang('admin.Stok')</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control text-right numeric"
                                                               id="stok_piece"
                                                               name="stok_piece"
                                                               value="{{ old('stok_piece', $entry->stok_piece) }}"
                                                               placeholder="@lang('admin.Enter piece')">
                                                        <span class="input-group-addon">@lang('admin.piece')</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>@lang('admin.Price & Loyalty')</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label style="padding-left:0;" for="supply_price"
                                                       class="col-md-6 text-left">@lang('admin.Supply Price')</label>
                                                <span class="col-md-6 control-label text-right">
                                                    <span id="supply_price">0.00</span>₼</span>
                                            </div>
                                            <div class="col-md-6"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding: 7px 0 0 0" for="markup"
                                                           class="col-md-6 text-left">@lang('admin.Markup')</label>
                                                    <div class="input-group col-md-6 text-right">
                                                        <input type="text" class="form-control text-right numeric"
                                                               id="markup"
                                                               name="markup" value="{{ old('markup', $entry->markup) }}"
                                                               placeholder="0.00">
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding: 7px 0 0 0" for="retail_price"
                                                           class="col-md-6 text-left">@lang('admin.Retail Price')</label>
                                                    <div class="input-group col-md-6 text-right">
                                                        <input type="text" class="form-control text-right numeric"
                                                               id="retail_price"
                                                               name="retail_price"
                                                               value="{{ old('retail_price', $entry->retail_price) }}"
                                                               placeholder="0.00">
                                                        <span class="input-group-addon">₼</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding: 7px 0 0 0" for="discount"
                                                           class="col-md-6 text-left">@lang('admin.Discount')</label>
                                                    <div class="input-group col-md-6 text-right">
                                                        <input type="text" class="form-control text-right numeric"
                                                               id="discount"
                                                               name="discount"
                                                               value="{{ old('discount', $entry->discount) }}"
                                                               placeholder="0.00">
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="col-md-6"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding: 7px 0 0 0" for="sale_price"
                                                           class="col-md-6 text-left">@lang('admin.Sale Price')</label>
                                                    <div class="input-group col-md-6 text-right">
                                                        <input type="text" class="form-control text-right numeric"
                                                               id="sale_price"
                                                               name="sale_price"
                                                               value="{{ old('sale_price', $entry->sale_price) }}"
                                                               placeholder="0.00">
                                                        <span class="input-group-addon">₼</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6"></div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="show">@lang('admin.Show')</label>
                                                    <div class="checkbox minimal" id="show">
                                                        <label>
                                                            <input type="hidden" name="show_latest_products" value="0">
                                                            <input type="checkbox" class="minimal"
                                                                   name="show_latest_products"
                                                                   value="1" {{ old('show_latest_products', @$entry->detail->show_latest_products) ? 'checked' : null }}>
                                                            @lang('admin.Show Latest Products')
                                                        </label>
                                                        <label>
                                                            <input type="hidden" name="show_picked_for_you" value="0">
                                                            <input type="checkbox" class="minimal"
                                                                   name="show_picked_for_you"
                                                                   value="1" {{ old('show_picked_for_you', @$entry->detail->show_picked_for_you) ? 'checked' : null }}>
                                                            @lang('admin.Show Picked For You')
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-md-8">
        
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="size">@lang('admin.Size')</label>
                                                            <select class="form-control size" id="size" name="size[]"
                                                                    data-placeholder="Ölçü seçin"
                                                                    multiple="multiple">
                                                                @foreach($sizes as $size)
                                                                    <option value="{{ old('size',$size->name) }}" {{ collect(old('size', $product_sizes))->contains($size->id) ? 'selected' : '' }}>{{ old('size',$size->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="color">Rənglər</label>
                                                            <select class="form-control color" id="color" name="color[]"
                                                                    data-placeholder="Rəng seçin"
                                                                    multiple="multiple">
                                                                @foreach($colors as $color)
                                                                    <option  style="background-color: red" value="{{ old('color',$color->name) }}" {{ collect(old('color', $product_colors))->contains($color->id) ? 'selected' : '' }}>{{ old('color',$color->title) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
                            @if($entry->id>0)
                                <a href="{{ route('manage.product.new') }}"
                                   class="btn btn-success"> @lang('admin.Add New Product')</a>
                                <button type="submit"  class="btn btn-info"><i
                                            class="fa fa-refresh"></i> @lang('admin.Update')</button>
                            @else
                                <a href="{{ route('manage.product') }}"
                                   class="btn btn-default"> @lang('admin.Cancel')</a>
                                <button type="submit"  class="btn btn-success"><i
                                            class="fa fa-plus"></i> @lang('admin.Save')</button>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
@section('footer')
    @include('manage.layouts.partials.ckeditorService',['uploadUrl'=>route('ckeditorProductUpload'),'editor'=>"product_description"])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/az.js"></script>
    <script>

        function categories(){
            $.ajax({
                url: "{{ route('manage.product.categories') }}",
                type: "GET",
                success: function(data){
                    $("#category_modal").find("#top_id").html('');
                    $("#category_modal").find("#top_id").html('<option value="">{{ __('admin.Parent Category') }}</option>');
                    $("#category_modal").find("#top_id").append(data)
                }
            })
        }
        

        $(function () {
            if($("#product_name").val().trim() !== '' || $("#meta-discription").val().trim() !== ''){
                let metaView = $("#meta-view")
                $(metaView).find(".title").html($("#product_name").val().trim())
                $(metaView).find(".discription").html($("#meta-discription").val().trim())
            }

            $("#product_name").on('keyup', function(event){
                let title = $(event.target).val()
                let metaView = $("#meta-view")
                $(metaView).find(".title").html(title)
            })
            $("#meta-discription").on('keyup', function(event){
                let discription = $(event.target).val()
                let metaView = $("#meta-view")
                $(metaView).find(".discription").html(discription)
            })

            load_images();

            function load_images() {
                var id = {{ $entry->id }}
                $.ajax({
                    url: "{{ route('manage.product.load_images') }}",
                    method: "POST",
                    data: {id: id},
                    success: function (data) {
                        $('#all_images').html(data);
                    }
                });
            }
            $(document).on('click', '.btn_close', function () {
                var id = $(this).attr('id');
                if (confirm('{{ __('admin.Are you sure you want to delete this data?') }}')) {
                    $.ajax({
                        url: '{{ route('manage.product.remove_image') }}',
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            load_images();
                            alert('{{ __('admin.Data Deleted') }}');
                        }
                    });

                } else {
                    return false;
                }
            });


            $('.select2').select2();

            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'

            });

            // $("#tag").select2({
            //     tags: true,
            //     tokenSeparators: [',', ' '],
            //     language: 'az'
            // });

            $("#size").select2({
                tags: true,
                tokenSeparators: [',', ' '],
                language: 'az'
            });

            $("#color").select2({
                tags: true,
                tokenSeparators: [',', ' '],
                language: 'az'
            });
            

            $('#brand').select2({
                tags: true,
                escapeMarkup: function (markup) {
                    return markup;
                },
                insertTag: function (data, tag) {
                    $('#form_modal #name').val(tag.text);
                    tag.text = '<div><i class="fa fa-plus"></i> {{ __('admin.Add') }}: ' + tag.text + '</div>';
                    data.push(tag);
                },
                language: 'az'
            }).on('select2:select', function () {
                if ($(this).find("option:selected").data("select2-tag") == true) {
                    $('#form_modal').modal('show');
                    $('#form_output').html('');
                    $('#button_action').val('insert');
                    $('#action').val('{{ __('admin.Save Brand') }}');
                }
            });


            $('form#form').submit(function (event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    url: '{{ route('manage.brand.post_data') }}',
                    data: form_data,
                    dataType: 'json',
                    success: function (data) {
                        if (data.error.length > 0) {
                            var error_html = '';
                            for (var count = 0; count < data.error.length; count++) {
                                error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                            }
                            $('#form_modal #form_output').html(error_html).hide().fadeIn('slow');
                        } else {
                            $('#form_modal #form_output').html(data.success).hide().fadeIn('slow').fadeTo(5000, 0.50);
                            $('#form_modal #form')[0].reset();
                            $('#form_modal #action').val('{{ __('admin.Save Brand') }}');
                            $('#form_modal .modal-title').text('{{ __('admin.Add New Brand') }}');
                            $('#form_modal #button_action').val('insert');
                            setTimeout(() => {
                                $('#form_modal').modal('hide');
                            }, 1000)
                            
                        }
                    }
                });
            });

            $('#categories').select2({
                tags: true,
                escapeMarkup: function (markup) {
                    return markup;
                },
                insertTag: function (data, tag) {
                    $('#category_modal #category_name').val(tag.text);
                    tag.text = '<div><i class="fa fa-plus"></i> {{ __('admin.Add') }}: ' + tag.text + '</div>';
                    data.push(tag);
                },
                language: 'az'
            }).on('select2:select', function () {
                if ($(this).find("option:selected").data("select2-tag") == true) {
                    $('#category_modal').modal('show');
                    categories()
                    $('#category_modal #form_output').html('');
                    $('#category_modal #button_action').val('insert');
                    $('#category_modal #action').val('{{ __('admin.Save Category') }}');
                }
            });

            $('form#category_form').submit(function (event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    url: '{{ route('manage.category.post_data') }}',
                    data: form_data,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        if (data.error.length > 0) {
                            var error_html = '';
                            for (var count = 0; count < data.error.length; count++) {
                                error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                            }
                            $('#category_modal #form_output').html(error_html).hide().fadeIn('slow');
                        } else {
                            $('#category_modal #form_output').html(data.success).hide().fadeIn('slow').fadeTo(5000, 0.50);
                            $('#category_modal form#category_form')[0].reset();
                            $('#category_modal #action').val('{{ __('admin.Save Category') }}');
                            $('#category_modal .modal-title').text('{{ __('admin.Add New Category') }}');
                            $('#category_modal #button_action').val('insert');
                            setTimeout(() => {
                                $('#category_modal').modal('hide');
                            }, 1000)
                        }
                    }
                });
            });




            $('input[name=supply_price]').keyup(function () {
                var supply_price = parseFloat($(this).val());
                var markup = parseFloat($('input[name=markup]').val());
                var retail_price = ((markup * supply_price / 100) + supply_price).toFixed(2);
                retail_price = parseFloat(retail_price);
                $('span#supply_price').text(supply_price);
                if (supply_price) {
                    $('span#supply_price').text(supply_price);
                    $('input[name=retail_price]').val(supply_price);
                    $('input[name=sale_price]').val(supply_price);
                } else {
                    $('span#supply_price').text('0.00');
                    $('input[name=retail_price]').val('');
                    $('input[name=sale_price]').val('');
                    $('input[name=markup]').val('');
                    $('input[name=discount]').val('');
                }
            });

            $('input[name=markup]').keyup(function () {
                var markup = parseFloat($(this).val());
                var supply_price = parseFloat($('input[name=supply_price]').val());
                var retail_price = ((markup * supply_price / 100) + supply_price).toFixed(2);
                retail_price = parseFloat(retail_price);
                $('input[name=retail_price]').val(retail_price);
                if (retail_price) {
                    $('input[name=retail_price]').val(retail_price);
                    $('input[name=sale_price]').val(retail_price);
                } else {

                }
            });

            $('input[name=discount]').keyup(function () {
                var discount = parseFloat($(this).val());
                var retail_price = parseFloat($('input[name=retail_price]').val());
                var sale_price = (retail_price - (discount * retail_price / 100)).toFixed(2);
                sale_price = parseFloat(sale_price);
                $('input[name=sale_price]').val(sale_price);
            });

            $('input[type="file"]').imageuploadify();
            $('.imageuploadify-message').text('{{ __('admin.Drag&Drop Your File(s)Here To Upload') }}');
            $('.btn_file_upload').text('{{ __('admin.or select file to upload') }}');

            $("input.numeric").keydown(function (event) {
                if (event.shiftKey == true) {
                    event.preventDefault();
                }

                if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                    (event.keyCode >= 96 && event.keyCode <= 105) ||
                    event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                    event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

                } else {
                    event.preventDefault();
                }

                if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                    event.preventDefault();
                //if a decimal has been added, disable the "."-button

            });

        });

    </script>
@endsection