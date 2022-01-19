@extends('customer.layouts.master')
@section('title', __('content.Payment'))
@section('head')
    <style>
        /* CSS for Credit Card Payment form */
        .credit-card-box .panel-title {
            display: inline;
            font-weight: bold;
        }

        .credit-card-box .form-control.error {
            border-color: red;
            outline: 0;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);
        }

        .credit-card-box label.error {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }

        .credit-card-box .payment-errors {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }

        .credit-card-box label {
            display: block;
        }

        /* The old "center div vertically" hack */
        .credit-card-box .display-table {
            display: table;
        }

        .credit-card-box .display-tr {
            display: table-row;
        }

        .credit-card-box .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
        }

        /* Just looks nicer */
        .credit-card-box .panel-heading img {
            min-width: 180px;
        }

    </style>
@endsection
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('homepage') }}">@lang('content.Home')</a></li>
                <li class="active">@lang('content.Payment')</li>
            </ul>
        </div>
    </div>
    <!-- /BREADCRUMB -->
    <div class="section">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li><b>{{ $error }}</b></li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <form action="{{ route('pay') }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <div class="billing-details">
                            <div class="section-title">
                                <h3 class="title">@lang('content.Billing Details')</h3>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="first_name"
                                    placeholder="@lang('content.First Name')"
                                    value="{{ old('first_name', auth()->user()->first_name) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="last_name"
                                    placeholder="@lang('content.Last Name')"
                                    value="{{ old('last_name', auth()->user()->last_name) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="email" name="email" placeholder="@lang('content.Email')"
                                    value="{{ old('email', auth()->user()->email) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="address"
                                    placeholder="@lang('content.Address')"
                                    value="{{ old('address', $user_detail->address) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="city" placeholder="@lang('content.City')"
                                    value="{{ old('city', $user_detail->city) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="zip_code"
                                    placeholder="@lang('content.ZIP Code')"
                                    value="{{ old('zip_code', $user_detail->zip_code) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="tel" name="phone" placeholder="@lang('content.Phone')"
                                    value="{{ old('phone', $user_detail->phone) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="tel" name="mobile" placeholder="@lang('content.Mobile')"
                                    value="{{ old('mobile', auth()->user()->mobile) }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="shiping-methods">
                            <div class="section-title">
                                <h4 class="title">@lang('content.Shipping Methods')</h4>
                            </div>
                            <div class="input-checkbox">
                                <input type="radio" name="delivery_method" id="delivery_method-1" checked value="1">
                                <label for="delivery_method-1">Standard {{ $website_info->standart_delivery_amount }}
                                    AZN</label>
                            </div>
                            <div class="input-checkbox">
                                <input type="radio" name="delivery_method" id="delivery_method-2" value="2">
                                <label for="delivery_method-2">Sürətli {{ $website_info->fast_delivery_amount }} AZN</label>
                            </div>
                            <p>{{ $website_info->delivery }}
                            <p>
                        </div>

                        <div class="payments-methods">
                            <div class="section-title">
                                <h4 class="title">@lang('content.Payments Methods')</h4>
                            </div>
                            <div class="input-checkbox">
                                <input type="radio" name="payment_method" id="payment_method-1" value="1" checked>
                                <label for="payment_method-1">Qapıda Ödəmə</label>
                            </div>
                            <div class="input-checkbox">
                                <input type="radio" name="payment_method" id="payment_method-2" value="2">
                                <label for="payment_method-2">Bank Kartı ilə Onlıne ödə</label>
                            </div>
                            <div>
                                {{ $website_info->payment_door }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button type="submit" value="1" class="primary-btn">@lang('content.Pay')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
