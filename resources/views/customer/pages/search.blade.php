@extends('customer.layouts.master')
@section('title', __('content.Search result'))
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
    </style>
@endsection
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('homepage') }}">@lang('content.Home')</a></li>
                <li class="active">@lang('content.Search result') ({{ count($products) }})</li>
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

                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">@lang('content.Search result') ({{ count($products) }})</h2>
                        <div class="pull-right">
                            <div class="product-slick-dots-2 custom-dots">
                            </div>
                        </div>
                    </div>
                </div>

                @if(count($products)>0)
                    @foreach($products as $array => $product)
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="product product-single">
                                <div class="product-thumb">
                                    <div class="product-label">
                                        <span>@lang('content.New')</span>
                                        @if($product->discount>0)
                                            <span class="sale">{{- $product->discount }}%</span>
                                        @endif
                                    </div>
                                    <button class="main-btn quick-view" data-toggle="modal"
                                            data-target="#quick_view{{ $array }}">
                                        <i class="fa fa-search-plus"></i> @lang('content.Quick view')
                                    </button>
                                    <img src="{{ $product->image->image_name ? asset('img/products/'. $product->image->image_name) : 'http://via.placeholder.com/1200x1200?text=ProductPhoto' }}"
                                         alt="">
                                </div>
                                <div class="product-body">
                                    <h3 class="product-price">{{ $product->sale_price }} ‎₼</h3>
                                    <div class="product-rating">
                                        @for($x=$product->detail->rating; $x>0; $x--)
                                            <i class="fa fa-star"></i>
                                        @endfor
                                        @for($x=$product->detail->rating; $x<5; $x++)
                                            <i class="fa fa-star-o empty"></i>
                                        @endfor
                                    </div>
                                    <h2 class="product-name">
                                        <a href="{{ route('product', $product->slug) }}">{{ $product->product_name }}</a>
                                    </h2>
                                    <div class="product-btns">
                                        <button type="button" class="main-btn icon-btn add-wish-list" id="{{ $product->id }}"
                                                data-id="{{ $product->wish_list }}"><i
                                                    class="fa fa-heart"></i></button>
                                        <button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <button type="submit" class="primary-btn add-to-cart" id="{{ $product->id }}">
                                            <i class="fa fa-shopping-cart"></i> @lang('content.Add to Cart')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade product_view" id="quick_view{{ $array }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <a href="#" data-dismiss="modal" class="class pull-right">
                                            <span class="fa fa-remove"></span>
                                        </a>
                                        <h3 class="modal-title product-name">{{ $product->product_name }}</h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <!--  Product Details -->
                                            <div class="product product-details clearfix">
                                                <div class="col-md-6" style="display: none">
                                                    <div id="product-main-view">
                                                        <div class="product-view">
                                                            <img src="" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="product-main-view">
                                                        <div class="product-view">
                                                            <img src="{{ $product->image->main_name ? asset('img/products/'. $product->image->main_name) : 'http://via.placeholder.com/1200x1200?text=ProductPhoto' }}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="product-body">
                                                        <div class="product-label">
                                                            <span>@lang('content.New')</span>
                                                            @if($product->discount>0)
                                                                <span class="sale">-{{ $product->discount }}%</span>
                                                            @endif
                                                        </div>
                                                        <br>
                                                        <h3 class="product-price">{{ $product->sale_price }}‎₼
                                                            @if($product->discount>0)
                                                                <del class="product-old-price">{{ $product->retail_price }}
                                                                    ‎₼
                                                                </del>
                                                            @endif
                                                        </h3>
                                                        <p>
                                                            <strong>@lang('content.Availability'):</strong>
                                                            {{ $product->stok_piece>0 ? __('content.In Stock') : __('content.Out Stock') }}
                                                        </p>
                                                        <p>
                                                            <strong>@lang('content.Brand'):</strong>
                                                            @foreach($product->brands as $brand)
                                                                {{ $brand->name }}
                                                            @endforeach
                                                        </p>
                                                        <p>{{ $product->description }}</p>
                                                        <div class="product-btns">
                                                            {{--<div class="qty-input">
                                                                <span class="text-uppercase">@lang('content.QTY'): </span>
                                                                <input class="input" type="number" name="qty" value="{{ old('qty', '1') }}">
                                                            </div>--}}
                                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                                            <button type="submit" class="primary-btn add-to-cart" id="{{ $product->id }}">
                                                                <i class="fa fa-shopping-cart"></i> @lang('content.Add to Cart')
                                                            </button>
                                                            <div class="pull-right">
                                                                <button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
                                                                <button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Product Details -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h3 class="alert alert-warning text-center">@lang('content.No Result')</h3>
                @endif
            </div>
            {{ $products->appends(['wanted'=>old('wanted')])->links() }}
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(function () {
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
        });
    </script>
@endsection