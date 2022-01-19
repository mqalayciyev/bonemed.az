@extends('customer.layouts.master')
@section('title', $brand_name)
@section('head')
    <style>
        form.inline_block {
            display: inline-block;
        }

        div.section {
            position: relative;
        }

        .cart_div {
            position: fixed;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .cart_div .dropdown.default-dropdown > .custom-menu {
            transform: translateX(-95%) translateY(-125px);
            top: 75%;
        }

        .color-red {
            color: #6BC637;
        }
        .filter_size label:hover{
            cursor: pointer;
        }
        .filter_size input[type='checkbox']:hover{
            cursor: pointer;
        }
        #filter-by-color .colors{
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
        #filter-by-color .colors:hover{
            border: 2px solid #6BC637!important;
            padding: 0px;
            width: 38px;
            height: 38px;
            border-radius: 100%;
            margin: 0px;
            display: flex;
            justify-content: center;
        }
        #filter-by-color .colors span{
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
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="/">@lang('content.Home')</a></li>
                <li class="active">{{ $brand_name }}</li>
            </ul>
        </div>
    </div>
    <!-- /BREADCRUMB -->

    <!-- section -->
    <div class="section">
        <div class="cart_div">
            <ul class="header-btns">
                <!-- Cart -->
                <li class="header-cart dropdown default-dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <div class="header-btns-icon">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="qty show_cartCount">{{ Cart::count() }}</span>
                        </div>
                    </a>
                    <div class="custom-menu">
                        <div id="shopping-cart" class="view_cart">
                            @if(count(Cart::content())>0)
                                <div class="shopping-cart-btns">
                                    <a href="{{ route('cart') }}" class="main-btn">@lang('header.View Cart')</a>
                                    <a href="{{ route('payment') }}" class="primary-btn">Checkout <i
                                                class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            @else
                                @lang('header.Empty, there is no product')
                            @endif
                        </div>
                    </div>
                </li>
                <!-- /Cart -->
            </ul>
        </div>
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- ASIDE -->
                <div id="aside" class="col-md-3">
                    <!-- aside widget -->
                    <!-- aside widget -->
                    <div class="aside">
                        <h3 class="aside-title">@lang('content.Filter by Price'):</h3>
                        <div id="price-slider"></div>
                    </div>
                    <!-- aside widget -->

                    <!-- aside widget -->
                    <div class="aside">
                        <h3 class="aside-title">@lang('content.Filter by Brand'):</h3>
                        <ul class="list-links" id="filter-brand">
                            @foreach($brands as $brand)
                                @for($i=0; $i< count($brands_count); $i++)
                                    @if($brand->id === $brands_count[$i]['id'])
                                        <li><a class="filter_brand" href="/brands/{{ $brand->name }}" id="{{ $brand->id }}" data-name="{{ $brand->name }}">{{ $brand->name }} ( {{ $brands_count[$i]['count'] }} )</a></li>
                                    @endif
                                @endfor
                                
                            @endforeach
                        </ul>
                    </div>
                    <a href="{{ route('brands', $brand_name) }}" class="primary-btn">@lang('content.Clear All')</a>
                </div>
                <div id="main" class="col-md-9">
                    <div class="store-filter clearfix">
                        <div class="pull-left">
                            <div class="sort-filter">
                                <span class="text-uppercase">@lang('content.Sort By'):</span>
                                <select class="input select">
                                    <option value="created_at">@lang('content.New')</option>
                                    <option value="sale_price">@lang('content.Price')</option>
                                </select>
                                <a href="javascript:void(0);" class="main-btn icon-btn sort_btn" id="desc">
                                    <i class="fa fa-arrow-down"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="store">
                        <!-- row -->
                        <div class="row products"></div>
                        <!-- /row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(function () {

            $(document).on('click', '.sort_btn', function () {
                var brand_name = '{{ $brand_name }}';
                var sorting_name = $('.select').val();
                var order = $(this).attr('id');
                var arrow = '';
                if (order == 'desc') {
                    arrow = '<i class="fa fa-arrow-up"></i>';
                    $('.sort_btn').attr('id', 'asc');
                    order = $(this).attr('id');
                } else {
                    arrow = '<i class="fa fa-arrow-down"></i>';
                    $('.sort_btn').attr('id', 'desc');
                    order = $(this).attr('id');
                }
                $.ajax({
                    url: '{{ route('brands.brand_sorting') }}',
                    method: 'GET',
                    data: {sorting_name: sorting_name, order: order, brand_name: brand_name},
                    success: function (data) {
                        $('.products').hide().html(data).fadeIn('slow');
                        $('.sort_btn').html(arrow);
                    }
                })
            });

            $(document).on('change', '.select', function () {
                var brand_name = '{{ $brand_name }}';
                var sorting_name = $(this).val();
                var order = $('.sort_btn').attr('id');
                var arrow = '';
                if (order == 'desc') {
                    arrow = '<i class="fa fa-arrow-up"></i>';
                    $('.sort_btn').attr('id', 'asc');
                    order = $('.sort_btn').attr('id');
                } else {
                    arrow = '<i class="fa fa-arrow-down"></i>';
                    $('.sort_btn').attr('id', 'desc');
                    order = $('.sort_btn').attr('id');
                }
                $.ajax({
                    url: '{{ route('brands.brand_sorting') }}',
                    method: 'GET',
                    data: {sorting_name: sorting_name, order: order, brand_name: brand_name},
                    success: function (data) {
                        $('.products').hide().html(data).fadeIn('slow');
                        $('.sort_btn').html(arrow);
                    }
                })
            });

            $(document).on('click', '.add-to-cart', function () {
                var id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('cart.add_to_cart') }}',
                    method: 'GET',
                    data: {id: id},
                    dataType: 'JSON',
                    success: function (data) {
                        $('#shopping-cart').html(data.output);
                        $('.view_cart').html(data.view_cart);
                        $('.show_cartCount').html(data.cart_count);
                        $('#show_cartTotalPrice').html(data.cart_total);
                    }
                });
            });

            products();

            function products() {
                var brand_name = '{{ $brand_name }}';
                $.ajax({
                    url: '{{ route("brands.brands_roducts") }}',
                    method: 'GET',
                    data: {brand_name},
                    success: function (data) {
                        // console.log(data);
                        $('.products').html(data);
                    }
                });
            };

            $(document).on('click', '.add-to-compare', function(){
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('compare.add_to_compare') }}",
                    type: "GET",
                    data: {id: id},
                    success: function(data){
                        alert(data);
                    }
                })
            })

            $(document).on('mouseenter', '.rating', function () {
                var index = $(this).data('index');
                var product_id = $(this).data('product_id');
                remove_star(product_id);
                for (var count = 1; count <= index; count++) {
                    $('#' + product_id + '-' + count).attr('class', 'rating fa fa-star');
                }
            })

            function remove_star(product_id) {
                for (var count = 1; count <= 5; count++) {
                    $('#' + product_id + '-' + count).attr('class', 'rating fa fa-star-o empty');
                }
            }


            $(document).on('click', '.rating', function () {
                var index = $(this).data('index');
                var product_id = $(this).data('product_id');
                $.ajax({
                    url: '{{ route('homepage.insert_ratings') }}',
                    method: 'GET',
                    data: {index: index, product_id: product_id},
                    success: function (data) {
                        if (data == 'done') {
                            products('products_dotd');
                            products('products_l');
                            products('products_pfy');
                            alert('{{ __('content.Your rate: ') }}' + index);
                        } else {
                            alert('{{ __('content.There is some problem in System') }}');
                        }
                    }
                })
            })

            $(document).on('mouseleave', '.rating', function () {
                var index = $(this).data('index');
                var product_id = $(this).data('product_id');
                var rating = $(this).data('rating');
                remove_star(product_id);
                for (var count = 1; count <= rating; count++) {
                    $('#' + product_id + '-' + count).attr('class', 'rating fa fa-star');
                }
            })

            $(document).on('click', '.filter_brand', function () {
                var brand_name = $(this).attr('data-name')
                $.ajax({
                    url: '{{ route('brands.brands_roducts') }}',
                    method: 'GET',
                    data: {brand_name: brand_name},
                    success: function (data) {
                        console.log(data);
                        $('.products').hide().html(data).fadeIn('slow');
                    }
                });
            });
            $(document).on('click', '.filter_size', function () {
                var name = $("#filter-size").find('input:checked');
                console.log(name.length);
                let size = [];
                if(name.length > 0){
                    
                    for(let i=0; i<name.length; i++){
                        let id = name[i].id
                        if(size.indexOf(id) === -1){
                            size.push(id);
                        }
                    }
                    var brand_name = '{{ $brand_name }}';
                    $.ajax({
                        url: '{{ route('brands.size_filter') }}',
                        method: 'GET',
                        data: {size: size, brand_name: brand_name},
                        success: function (data) {
                            console.log(data);
                            $('.products').hide().html(data).fadeIn('slow');
                        }
                    });
                }
                else{
                    products();
                }
                
                
            });
            $(document).on('click', '.filter_color', function () {
                var color = $(this).find('span').attr('data-color');
                var brand_name = '{{ $brand_name }}';
                $.ajax({
                    url: '{{ route('brands.color_filter') }}',
                    method: 'GET',
                    data: {color: color, brand_name: brand_name},
                    success: function (data) {
                        console.log(data);
                        $('.products').hide().html(data).fadeIn('slow');
                    }
                });
            });

            // PRICE SLIDER
            var slider = document.getElementById('price-slider');
            if (slider) {
                noUiSlider.create(slider, {
                    start: [0, 1000],
                    connect: true,
                    tooltips: [true, true],
                    format: {
                        to: function (value) {
                            return value.toFixed(2);
                        },
                        from: function (value) {
                            return value
                        },
                    },
                    range: {
                        'min': 0,
                        'max': 3000
                    }
                });


                document.getElementById('price-slider').addEventListener('click', function () {
                    var values = slider.noUiSlider.get();
                    var brand_name = '{{ $brand_name }}';
                    $.ajax({
                        url: "{{ route('brands.price_filter') }}",
                        type: "GET",
                        data: {values: values, brand_name: brand_name},
                        success: function (data) {
                            $('.products').hide().html(data).fadeIn('slow');
                        }
                    });
                });

            }
        });
    </script>
@endsection