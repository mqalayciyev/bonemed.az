@extends('customer.layouts.master')
@section('title', __('content.Home'))
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

        .cart_div .dropdown.default-dropdown > .dropdown-menu {
            transform: translateX(-95%) translateY(-125px);
            top: 75%;
        }

        .color-red {
            color: #6BC637;
        }
        .banners-div{
            padding-top: 10px;
        }
        .banners-div .row{
            column-gap: 10px;
            columns: 2;
        }
        .banners-div .banner-border {
            padding: 0px;
        }
        .banners-div .banner-border a{
            box-sizing: border-box;
            overflow: hidden;
            width: 100%;
            display: block;
        }
        .banners-div .banner-border img{
            position: relative;
        }
        .banners-div .banner-border a:hover img{
            transform: scale(1.03);
            transition: 0.6s all;
        }
        .slick-dots{
            position: relative;
            top: 15px;
        }
        .slick-dots > li{
            
            margin-right: 10px;
            margin-left: 10px;
        }
        .slick-dots > li.slick-active > span{
            background-color: #14487D;
        }
        .slider-dots{
            background-color: #6BC637;
            border-radius: 50%;
            width: 15px;
            height: 15px;
            display: inline-block;
        }
        /* .banners-div .banner-border img:hover::after{
            transition: 0.5s all;
            content: "";
            position: absolute;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.319);
        } */
    </style>
@endsection
@section('content')
    @include('common.alert')
    <!-- HOME -->
    <div id="home">
        <!-- container -->
        <div class="container">
            <!-- home wrap -->
            <div class="home">
                <!-- home slick -->
                <div id="home-slick">
                @foreach($products_slider as $array => $product)
                    <!-- banner -->
                        <div class="banner banner-1">
                            <img src="{{ asset('img/sliders/'.$product->slider_image) }}" alt="{{ $product->slider_image }}">
                            <div class="banner-caption text-center"></div>
                        </div>
                        <!-- /banner -->
                    @endforeach
                </div>
                <!-- /home slick -->
            </div>
            <!-- /home wrap -->
            <div class="banners-div col-md-12" style="">
                <div class="row">
                @foreach($banners as $banner)
                    <div class="col-md-12 banner-border">
                        <a href="{{ $banner->banner_slug }}">
                            <img src="{{ $banner->banner_image ? asset('img/banners/'.$banner->banner_image) : 'http://via.placeholder.com/360x260?text=BannerPhoto(360x260)' }}"
                                    alt="{{ $banner->banner_name }}" class="img-responsive"></a>
                    </div>
                @endforeach
            </div>
            </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /HOME -->
    
    <!-- section -->
    <div class="section bg-light">
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
                    <div class="dropdown-menu">
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
        <div class="container" >
            <div class="row">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">@lang('content.Deals Of The Day')</h2>
                    </div>
                </div>
                <div class="products_dotd col-md-12"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">@lang('content.Latest Products')</h2>
                    </div>
                </div>
                <div class="products_l col-md-12"></div>
                <div class="text-center col-md-12" style="margin-bottom: 20px;">
                    <button type="submit" class="primary-btn more-products" style="width: 17rem;">
                        <i class="fa fa-arrow-down"></i> Daha Çox Göstər
                    </button>
                </div>
            </div>
            <div class="row your_products">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">Sizin baxdığınız</h2>
                    </div>
                </div>
                <div class="products_pfy col-md-12"></div>
            </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->
@endsection
@section('footer')
    <script>
        $(function () {

            products('products_dotd');
            products('products_l');
            products('products_pfy');

            function products(dynamic_product, length) {
                $.ajax({
                    url: '{{ route("homepage.products") }}',
                    method: 'GET',
                    data: {product: dynamic_product, length},
                    success: function (data) {
                        if(data == 'empty'){
                            $(".your_products").css('display', 'none');
                        }
                        $('.' + dynamic_product).html(data);
                    }
                });
            };
            
            $(document).on('click', '.add-wish-list', function(){
                var id = $(this).attr("data-id");
                $.ajax({
                    url: '{{ route("add_wish_list") }}',
                    method: 'GET',
                    data: {id: id},
                    success: function (data) {
                        alert(data);
                    }
                });
            })
            $(document).on('click', '.more-products', function(){
                let old_length = $('.products_l').find('.modal').length
                let new_length = old_length+8;
                products('products_l', new_length);
            })

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

            $(document).on('click', '.add-to-cart', function () {
                var id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('cart.add_to_cart') }}',
                    method: 'GET',
                    data: {id: id},
                    dataType: 'JSON',
                    success: function (data) {
                        $('.mobile-navbar').find('#shopping-cart').html(data.output);
                        $('.mobile-navbar').find('.view_cart').html(data.view_cart);
                        $('.mobile-navbar').find('#show_cartTotalPrice').html(data.cart_total);
                        $('.desktop-navbar').find('#shopping-cart').html(data.output);
                        $('.desktop-navbar').find('.view_cart').html(data.view_cart);
                        $('.show_cartCount').html(data.cart_count);
                        $('.desktop-navbar').find('#show_cartTotalPrice').html(data.cart_total);
                    }
                });
            });

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

        });
    </script>
@endsection