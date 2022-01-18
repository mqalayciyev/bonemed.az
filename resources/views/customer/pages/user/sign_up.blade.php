@extends('customer.layouts.master')
@section('title', __('content.Sign up'))
@section('content')
    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">@lang('content.Create An Account')</h2>
                        <div class="pull-right">
                            <div class="product-slick-dots-2 custom-dots">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @include('common.errors.validate')
                    <form action="{{ route('user.sign_up') }}" method="post" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">@lang('content.First Name')</label>
                                <input class="input" type="text" name="first_name" value="{{ old('first_name') }}"
                                       placeholder="@lang('content.Enter your first name')" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">@lang('content.Last Name')</label>
                                <input class="input" type="text" name="last_name" value="{{ old('last_name') }}"
                                       placeholder="@lang('content.Enter your last name')" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="input" type="email" name="email" value="{{ old('email') }}"
                                       placeholder="@lang('content.Enter your email')" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile">@lang('Mobile')</label>
                                <input class="input" type="text" name="mobile" value="{{ old('mobile') }}"
                                       placeholder="@lang('content.Enter your mobile')" required>
                            </div>
                            <div class="form-group">
                                <label for="password">@lang('content.Password')</label>
                                <input class="input" type="password" name="password" placeholder="@lang('content.Enter your password')" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">@lang('content.Confirm Password')</label>
                                <input class="input" type="password" name="password_confirmation"
                                       placeholder="@lang('content.Confirm your password')" required>
                            </div>
                        </div>
                        <div class="pull-right">
                            <div class="col-md-12">
                                <button type="submit" class="primary-btn">@lang('content.Sign up')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
