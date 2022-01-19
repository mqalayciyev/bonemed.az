<!-- HEADER -->
<header>
    <!-- header -->
    <div id="header">
        <div class="container">
            <div class="mobile-navbar">
                <div style="width: 100%;">
                    
                    <!-- Mobile nav toggle-->
                    
                    <!-- / Mobile nav toggle -->
                    <ul
                     class="header-btns clearfix " style="width: 100%;">
                     <li>
                        <div class="header-logo" style="max-width: 38vw;">
                            <a class="logo" href="/">
                                <img src="{{ asset('img/' . old('logo', $website_info->logo)) }}" alt="">
                            </a>
                        </div>
                     </li>
                     <li style="float: right; margin-left: 15px;">
                        <div class="nav-toggle " style="padding: 0px">
                            <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
                        </div>
                    </li>
                        <li class="header-account dropdown" style="float: right;">
                            <div class="dropdown-toggle" role="button" data-toggle="dropdown">
                                <div class="header-btns-icon">
                                    <i class="fa fa-user-o"></i>
                                </div>
                            </div>
                            <ul class="dropdown-menu" style="margin: 0px;">
                                @auth
                                    <li><a href="{{ route('orders') }}"><i class="fa fa-user-o"></i>
                                            @lang('header.Orders') </a></li>
                                    <li><a href="/my_wish_list"><i class="fa fa-heart-o"></i> My Wishlist</a></li>
                                    <li><a href="/compare"><i class="fa fa-exchange"></i> Compare</a></li>
                                    <li><a href="/cart"><i class="fa fa-check"></i> Checkout</a></li>
                                    <li><a href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout_form').submit();"><i
                                                class="fa fa-sign-out"></i> @lang('header.Sign Out')</a></li>
                                    <form action="{{ route('user.sign_out') }}" method="post" style="display: none;"
                                        id="logout_form">
                                        {{ csrf_field() }}
                                    </form>
                                @endauth
                                @guest
                                    <li><a href="{{ route('user.sign_in') }}"><i class="fa fa-unlock-alt"></i>
                                            @lang('header.Login')</a>
                                    </li>
                                    <li><a href="{{ route('user.sign_up') }}"><i class="fa fa-user-plus"></i>
                                            @lang('header.Create An Account')</a></li>
                                @endguest
                            </ul>
                        </li>
                        <li class="header-cart dropdown" style="float: right;">
                            <div class="dropdown-toggle" role="button" data-toggle="dropdown">
                                <div class="header-btns-icon">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="qty show_cartCount">{{ Cart::count() }}</span>
                                </div>
                            </div>
                            <div class="dropdown-menu">
                                <div id="shopping-cart">
                                    @if (count(Cart::content()) > 0)
                                        <div class="shopping-cart-list">
                                            @foreach (Cart::content() as $productCartItem)
                                                <div class="product product-widget">
                                                    <div class="product-thumb">
                                                        <img src="{{ $productCartItem->options->image ? asset('img/products/' . $productCartItem->options->image) : 'http://via.placeholder.com/1200x1200?text=ProductPhoto' }}"
                                                            alt="">
                                                    </div>
                                                    <div class="product-body">
                                                        <h3 class="product-price">{{ $productCartItem->price }}
                                                            ₼<span class="qty"> x
                                                                {{ $productCartItem->qty }}</span></h3>
                                                        <h2 class="product-name"><a
                                                                href="{{ route('product', $productCartItem->options->slug) }}">{{ $productCartItem->name }}</a>
                                                        </h2>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="shopping-cart-btns">
                                            <a href="{{ route('cart') }}"
                                                class="main-btn btn-block text-center">@lang('header.View Cart')</a>

                                        </div>
                                    @else
                                        @lang('header.Empty, there is no product')
                                    @endif
                                </div>
                            </div>
                        </li>
                        
                    </ul>
                    <div class="header-search" style="width: 100%">
                        <form action="{{ route('search_product') }}" method="post" autocomplete="off">
                            {{ csrf_field() }}
                            <input class="input" type="text" style="padding: 0 40px;" name="wanted"
                                value="{{ old('wanted') }}" placeholder="@lang('header.Enter your keyword')">
                            <button class="search-btn" type="submit" value="1"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="pull-left desktop-navbar" style="width: 60%;">

                <!-- Logo -->
        
                <!-- /Logo -->
                <div class="header-logo" style="width: 150px; margin-right: 0px;">
                    <a class="logo" href="/">
                        <img src="{{ asset('img/' . old('logo', $website_info->logo)) }}" alt="">
                    </a>
                </div>

                <!-- Search -->
                <div class="header-search" style="width: 70%;">
                    <form action="{{ route('search_product') }}" method="post" autocomplete="off">
                        {{ csrf_field() }}
                        <input class="input" type="search" style="padding: 0 40px;" name="wanted"
                            value="{{ old('wanted') }}" placeholder="@lang('header.Enter your keyword')">
                        <button class="search-btn" type="submit" value="1"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <!-- /Search -->
            </div>
            <div class="pull-right desktop-navbar">
                <ul class="header-btns">
                    <!-- Account -->
                    <li class="header-account dropdown default-dropdown">
                        <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
                            <div class="header-btns-icon">
                                <i class="fa fa-user-o"></i>
                            </div>
                            <strong class="text-uppercase">@lang('header.My Account') <i class="fa fa-caret-down"></i>
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</strong>
                        </div>
                        @auth
                            @lang('header.Hello') {{ auth()->user()->first_name }}
                        @endauth
                        @guest
                            <a href="{{ route('user.sign_in') }}" class="text-uppercase">@lang('header.Login')</a> / <a
                                href="{{ route('user.sign_up') }}" class="text-uppercase">@lang('header.Join')</a>
                        @endguest
                        <ul class="custom-menu">
                            @auth
                                <li><a href="{{ route('orders') }}"><i class="fa fa-user-o"></i> @lang('header.Orders')
                                    </a></li>
                                <li><a href="/my_wish_list"><i class="fa fa-heart-o"></i> My Wishlist</a></li>
                                <li><a href="/compare"><i class="fa fa-exchange"></i> Compare</a></li>
                                <li><a href="/cart"><i class="fa fa-check"></i> Checkout</a></li>
                                <li><a href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout_form').submit();"><i
                                            class="fa fa-sign-out"></i> @lang('header.Sign Out')</a></li>
                                <form action="{{ route('user.sign_out') }}" method="post" style="display: none;"
                                    id="logout_form">
                                    {{ csrf_field() }}
                                </form>
                            @endauth
                            @guest
                                <li><a href="{{ route('user.sign_in') }}"><i class="fa fa-unlock-alt"></i>
                                        @lang('header.Login')</a>
                                </li>
                                <li><a href="{{ route('user.sign_up') }}"><i class="fa fa-user-plus"></i>
                                        @lang('header.Create An Account')</a></li>
                            @endguest
                        </ul>
                    </li>
                    <!-- /Account -->

                    <!-- Cart -->
                    <li class="header-cart dropdown default-dropdown">
                        <a href="{{ route('cart') }}" class="dropdown-toggle">
                            <div class="header-btns-icon">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="qty show_cartCount">{{ Cart::count() }}</span>
                            </div>
                            <strong class="text-uppercase">&nbsp; &nbsp;&nbsp; @lang('header.My Cart'):</strong>
                            <br>
                            <span id="show_cartTotalPrice">{{ Cart::subTotal() }} </span>₼
                        </a>
                        <div class="custom-menu">
                            <div id="shopping-cart">
                                @if (count(Cart::content()) > 0)
                                    <div class="shopping-cart-list">
                                        @foreach (Cart::content() as $productCartItem)
                                            <div class="product product-widget">
                                                <div class="product-thumb">
                                                    <img src="{{ $productCartItem->options->image ? asset('img/products/' . $productCartItem->options->image) : 'http://via.placeholder.com/1200x1200?text=ProductPhoto' }}"
                                                        alt="">
                                                </div>
                                                <div class="product-body">
                                                    <h3 class="product-price">{{ $productCartItem->price }} ₼<span
                                                            class="qty"> x {{ $productCartItem->qty }}</span></h3>
                                                    <h2 class="product-name"><a
                                                            href="{{ route('product', $productCartItem->options->slug) }}">{{ $productCartItem->name }}</a>
                                                    </h2>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="shopping-cart-btns">
                                        <a href="{{ route('cart') }}" class="main-btn btn-block text-center">@lang('header.View Cart')</a>
                                        
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
        </div>
        <!-- header -->
    </div>
    <!-- container -->
</header>
<!-- /HEADER -->

<!-- NAVIGATION -->
<div id="navigation">
    <!-- container -->
    <div class="container">
        <div id="responsive-nav">
            <!-- category nav -->
            <div class="category-nav show-on-click">
                <span class="category-header">@lang('header.Categories') <i class="fa fa-list"></i></span>
                <ul class="category-list">
                    @foreach ($global_categories_sidemenu as $category)
                        @if ($category->top_id == null)
                            <li class="dropdown side-dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-angle-right"></i> {{ $category->category_name }}</a>
                                <div class="custom-menu">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-links">
                                                <li>
                                                    <h3 class="list-links-title"><a
                                                            href="{{ route('category', $category->slug) }}">{{ $category->category_name }}</a>
                                                    </h3>
                                                </li>
                                                @foreach ($all_global_categories as $alt_category)
                                                    @if ($alt_category->top_id == $category->id)
                                                        <li>
                                                            <a
                                                                href="{{ route('category', $alt_category->slug) }}">{{ $alt_category->category_name }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <hr class="hidden-md hidden-lg">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <!-- /category nav -->

            <!-- menu nav -->
            <div class="menu-nav">
                <span class="menu-header">Menu <i class="fa fa-bars"></i></span>
                <ul class="menu-list">
                    <li><a href="/">@lang('header.Home')</a></li>
                    {{-- <li><a href="javascript:void(0);">@lang('header.Shop')</a></li> --}}
                    {{-- <li><a href="/newproducts">@lang('header.New Products')</a></li> --}}
                    {{-- <li><a href="/discounted">@lang('header.Discounted Products')</a></li> --}}
                    <li><a href="/compare">@lang('footer.Compare')</a></li>
                    {{-- <li><a href="javascript:void(0);">@lang('header.Sales')</a></li> --}}
                    <li><a href="/contact">@lang('header.Contact')</a></li>

                    @foreach ($global_categories_headermenu as $category)
                        @if ($category->top_id == null)
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    {{ $category->category_name }} <i class="fa fa-caret-down"></i></a>
                                <div class="custom-menu">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-links">
                                                <li>
                                                    <h3 class="list-links-title"><a
                                                            href="{{ route('category', $category->slug) }}">{{ $category->category_name }}</a>
                                                    </h3>
                                                </li>
                                                @foreach ($all_global_categories as $alt_category)
                                                    @if ($alt_category->top_id == $category->id)
                                                        <li>
                                                            <a
                                                                href="{{ route('category', $alt_category->slug) }}">{{ $alt_category->category_name }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <hr class="hidden-md hidden-lg">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <!-- menu nav -->
        </div>
    </div>
    <!-- /container -->
</div>
<!-- /NAVIGATION -->
