@extends('customer.layouts.master')
@section('title', 'Product - '.$product->product_name)
@section('description', $product->meta_discription)
@section('keywords', $product->meta_title)
@section('content')
@php
    $your_products = session('your_products');
    if($your_products != ""){
        $your_products = $your_products . "-" . $product->id;
    }
    else{
        $your_products = $product->id;
    }
    session(['your_products' => $your_products]);
@endphp
    <!-- BREADCRUMB -->
    {{-- <meta name="Description" content="{{ $product->meta_discription }}">
    <meta name="Title" content="{{ $product->meta_title }}"> --}}
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="/">@lang('content.Home')</a></li>
                @foreach($categories as $category)
                    <li><a href="{{ route('category',$category->slug) }}">{{ $category->category_name }}</a></li>
                @endforeach
                <li class="active">{{ $product->product_name }}</li>
            </ul>
        </div>
    </div>
    <!-- /BREADCRUMB -->
    
    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!--  Reviews Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!--  Product Details -->
                <div class="product product-details clearfix">
                    <div class="col-md-6">
                        <div id="product-main-view">
                            @foreach($images as $image)
                                <div class="product-view">
                                    <img src="{{ asset('img/products/'.$image->main_name) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                        <div id="product-view">
                            @foreach($images as $image)
                                <div class="product-view">
                                    <img src="{{ asset('img/products/'.$image->thumb_name) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product-body">
                            <div class="product-label">
                                <span>@lang('content.New')</span>
                                @if($product->discount>0)
                                    <span class="sale">{{- $product->discount }}%</span>
                                @endif
                            </div>
                            <h2 class="product-name">{{ $product->product_name }}</h2>
                            <h3 class="product-price">{{ $product->sale_price }}₼
                                @if($product->discount>0)
                                    <del class="product-old-price">{{ $product->retail_price }}₼</del>
                                @endif
                            </h3>
                            <div>
                                <div class="product-rating">
                                    @for($count=1; $count<=5; $count++)
                                        @if($count<=$product->rating_avg)
                                            @php $color = '' @endphp
                                        @else
                                            @php $color = '-o empty' @endphp
                                        @endif
                                        <i title="{{ $count }}" id="{{ $product->id.'-'.$count }}" data-index="{{ $count }}" data-product_id="{{ $product->id }}" data-rating="{{ $product->rating_avg }}" class="rating fa fa-star{{ $color }}"></i>
                                    @endfor
                                </div>
                                <a href="#">3 @lang('content.Review(s)') / @lang('content.Add Review')</a>
                            </div>
                            <p>
                                <strong>@lang('content.Availability'):</strong>
                                {{ $product->stok_piece>0 ? __('content.In Stock') : __('content.Out Stock') }}
                            </p>
                            <p>
                                <strong>@lang('content.Brand'):</strong>
                                
                                    @foreach($product->brands as $brand)
                                        <a href="{{ route('brands', $brand->name) }}" style="display: inline;">
                                            {{ $brand->name }}
                                        </a>
                                    @endforeach
                                
                            </p>
                            <div class="Quantity" style="margin-bottom: 10px">
                                <div data-v-49522158="" class="ProductQuantity" >
                                    <button
                                        data-v-49522158=""
                                        type="button"
                                        tabindex="-1"
                                        class="ProductQuantity-Minus"
                                    >
                                        <i
                                            data-v-49522158=""
                                            class="fa fa-minus"
                                        ></i></button
                                    ><input
                                        data-v-49522158=""
                                        id="qty" 
                                        type="number" 
                                        min="1" 
                                        max="{{ $product->stok_piece }}" 
                                        data-stok="{{ $product->stok_piece }}" 
                                        name="piece" 
                                        value="1"
                                        autocomplete="off"
                                        class="ProductQuantity-Input"
                                    /><button
                                        data-v-49522158=""
                                        type="button"
                                        tabindex="-1"
                                        class="ProductQuantity-Plus"
                                    >
                                        <i
                                            data-v-49522158=""
                                            class="fa fa-plus"
                                        ></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-btns">
                                <button type="submit" class="primary-btn add-to-cart" id="{{ $product->id }}">
                                    <i class="fa fa-shopping-cart"></i> @lang('content.Add to Cart')
                                </button>
                                <button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
                                <button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="product-tab">
                            <ul class="tab-nav">
                                <li class="active"><a data-toggle="tab" href="#tab1">@lang('content.Description')</a>
                                </li>
                                {{-- <li><a data-toggle="tab" href="#tab1">@lang('content.Details')</a></li> --}}
                                <li><a data-toggle="tab" id="tab-2" href="#tab2">@lang('content.Reviews') <span></span></a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab1" class="tab-pane fade in active">
                                    {!! $product->product_description !!}
                                </div>
                                <div id="tab2" class="tab-pane fade in">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="product-reviews">
                                                {{-- <div><a href="#"><i class="fa fa-clock-o"></i> 27 DEC 2017 / 8:0PM</a></div> --}}
                                                <div class="reviews-div">
                                                
                                                </div>  
                                                <ul class="reviews-pages"></ul>                                           
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="text-uppercase">ŞƏRHİNİZİ YAZIN</h4>
                                            <p>Elektron poçtunuz dərc olunmayacaq.</p>
                                            
                                            <form action="{{ route('product.review') }}" class="review-form" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    @auth
                                                        <input class="input" name="name" value="{{  auth()->user()->first_name . " " . auth()->user()->last_name }}" type="text" placeholder="Your Name"/>
                                                    @endauth
                                                    @guest
                                                        <input class="input" name="name" type="text" placeholder="Your Name"/>
                                                    @endguest
                                                </div>
                                                <div class="form-group">
                                                    @auth
                                                        <input class="input" name="email" value="{{  auth()->user()->email }}" type="email" placeholder="Email Address"/>
                                                    @endauth
                                                    @guest
                                                        <input class="input" name="email" type="email" placeholder="Email Address"/>
                                                    @endguest
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="input" name="review" placeholder="Your review"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-rating">
                                                        <strong class="text-uppercase">Your Rating: </strong>
                                                        <div class="stars">
                                                            <input type="radio" id="star5" name="rating" value="5"/><label for="star5"></label>
                                                            <input type="radio" id="star4" name="rating" value="4"/><label for="star4"></label>
                                                            <input type="radio" id="star3" name="rating" value="3"/><label for="star3"></label>
                                                            <input type="radio" id="star2" name="rating" value="2"/><label for="star2"></label>
                                                            <input type="radio" id="star1" name="rating" value="1"/><label for="star1"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="primary-btn">Submit</button>
                                            </form>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /Product Details -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">@lang('content.Picked For You')</h2>
                    </div>
                </div>
                <!-- section title -->
                <div class="products_pfy  col-md-12"></div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->
@endsection

@section('footer')
    <script>
        $(function () {
            products('products_pfy');
            
            function products(dynamic_product) {
                $.ajax({
                    url: '{{ route("homepage.products") }}',
                    method: 'GET',
                    data: {product: dynamic_product},
                    success: function (data) {
                        $('.' + dynamic_product).html(data);
                    }
                });
            };
            reviews(1)
            function reviews(page){
                let reviewsPages = $(".reviews-pages")
                $.ajax({
                    url: "{{ route('product.reviews') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {"_token": "{{ csrf_token() }}", page, product_id: "{{ $product->id }}"},
                    success: function(data){
                        $(".reviews-div").html('')
                        $(reviewsPages).html("")
                        $(".reviews-div").append(data.reviews)
                        $("#tab-2").find('span').html(`(${data.count})`)
                        if(data.count > 3){
                            for (let i = 1; i <= Math.ceil(data.count/3); i++) {
                                
                                if(i == page){
                                    $(reviewsPages).append(`<li class="active pages" data-index="${i}">${i}</li>`)
                                }
                                else
                                {
                                    $(reviewsPages).append(`<li class="pages" data-index="${i}">${i}</li>`)
                                }             
                                                        
                            }
                        }
                    }

                })
            }
            $(".reviews-pages").on('click', '.pages', function(){
                let index = $(this).attr('data-index');
                $(".reviews-pages").find(".active").removeClass('active')
                $(this).addClass("active")
                reviews(index)
            })
            var stok_count = 1;
            $(document).on('click', '.add-to-cart', function () {
                var id = $(this).attr('id');
                var piece = $("#qty").val();
                if(piece > 0){
                    $.ajax({
                        url: '{{ route('cart.add_to_cart') }}',
                        method: 'GET',
                        data: {id: id, piece: piece, stok_count: stok_count},
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
                    stok_count++;
                }
                else
                {
                    alert('Məhsul sayı 0 ola bilməz.')
                }
                
            });
            $(document).on('click', '.ProductQuantity-Minus',  function(){
                var piece = $('#qty').val()
                if(piece == 0){
                    return false;
                }
                $('#qty').val(--piece);
            })
            $(document).on('click', '.ProductQuantity-Plus',  function(){
                var piece = $('#qty').val()
                if(piece == "{{ $product->stok_piece }}"){
                    return false;
                }
                $('#qty').val(++piece);
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

        });
    </script>
@endsection