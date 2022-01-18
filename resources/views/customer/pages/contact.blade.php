@extends('customer.layouts.master')
@section('title', __('header.Contact'))
@section('head')
@endsection
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="/">@lang('content.Home')</a></li>
                <li class="active">@lang('header.Contact')</li>
            </ul>
        </div>
    </div>
    <!-- /BREADCRUMB -->
    <div class="section">
        <div class="container">
            <div class="col-md-6">
                <div class="row">
                    <p><i class="fa fa-home fa-2x"></i> <a href=""></a>{{ old('address', $website_info->address) }}</p>
                    <p><i class="fa fa-mobile fa-2x"></i> <a href="tel:{{ old('mobile', $website_info->mobile) }}">{{ old('mobile', $website_info->mobile) }}</a></p>
                    <p><i class="fa fa-phone fa-2x"></i> <a href="tel:{{ old('phone', $website_info->phone) }}">{{ old('phone', $website_info->phone) }}</a></p>
                    <p><i class="fa fa-envelope fa-2x"></i> <a href="mailto:{{ old('email', $website_info->email) }}">{{ old('email', $website_info->email) }}</a></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    @include('common.alert')
                    <form action="{{ route('contact.send') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name"><span style="color: red">*</span> Adınız</label>
                            <input type="text" name="name" class="form-control" required id="name">
                        </div>
                        <div class="form-group">
                            <label for="email"><span style="color: red">*</span> Email</label>
                            <input type="email" name="email" class="form-control" required id="email">
                        </div>
                        <div class="form-group">
                            <label for="message"><span style="color: red">*</span> Mesajınız</label>
                            <textarea type="text" name="message" class="form-control" rows="8" required id="message"></textarea>
                        </div>
                        <button type="submit" class="primary-btn">Göndər</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        
    </script>
@endsection