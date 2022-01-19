@extends('customer.layouts.master')
@section('title', __('content.Order'))
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('homepage') }}">Ana Səhifə</a></li>
                <li><a href="{{ route('user.my_account') }}">@lang('footer.My Account')</a></li>
                <li><a href="{{ route('orders') }}">@lang('content.Orders')</a></li>
                <li class="active" > SP-{{ $order->id }}</li>
            </ul>
        </div>
    </div>
    <!-- /BREADCRUMB -->
    <div class="section">
        <div class="container">
            <div class="section-title">
                <h3 class="title">@lang('content.Order Review')</h3>
            </div>
            @include('common.alert')
            @if ($order->id > 0)
                <div class="order-summary clearfix">
                    <table class="shopping-cart-table table">
                        <thead>
                            <tr>
                                <th>@lang('content.Product')</th>
                                <th class="text-center">@lang('content.Price')</th>
                                <th class="text-center">@lang('content.Quantity')</th>
                                <th class="text-center">@lang('content.Total')</th>
                                <th class="text-right">@lang('content.Date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->cart->cart_products as $cart_product)
                                <tr>
                                    <td class="thumb">
                                        <img src="{{ $cart_product->product->image->main_name ? asset('img/products/' . $cart_product->product->image->main_name) : 'http://via.placeholder.com/1200x1200?text=ProductPhoto' }}"
                                            alt="">
                                        <a
                                            href="{{ route('product', $cart_product->product->slug) }}">{{ $cart_product->product->product_name }}</a>
                                    </td>
                                    <td class="price text-center">
                                        <strong>{{ number_format($cart_product->amount, 2) }} ₼</strong><br>
                                    </td>
                                    <td class="qty text-center">
                                        {{ $cart_product->piece }}
                                    </td>
                                    <td class="total text-center">
                                        <strong class="primary-color">{{ $cart_product->amount * $cart_product->piece }} ₼</strong>
                                    </td>
                                    <td class="text-right">{{ $order->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="empty" colspan="3"></th>
                                <th>@lang('content.SHIPPING')</th>
                                <td colspan="2">{{ $order->shipping }} AZN</td>
                            </tr>
                            <tr>
                                <th class="empty" colspan="3"></th>
                                <th>@lang('content.TOTAL')</th>
                                <th colspan="2" class="total">
                                    {{ number_format($order->order_amount + ($order->order_amount * config('cart.tax')) / 100, 2) }}
                                    ₼</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="py-3">
                        <a class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-3 px-xl-5"
                            href="{{ route('orders') }}">
                            <i class="fas fa-long-arrow-alt-left"></i> Sifarişlərə qayıt
                        </a>
                    </div>
                </div>
            @else
                <h4>@lang('content.There is no product')</h4>
            @endif
        </div>
    </div>
@endsection
