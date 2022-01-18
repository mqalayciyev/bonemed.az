@extends('customer.layouts.master')
@section('title', "Şifrəni dəyiş")
@section('content')
    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">Şifrəni dəyiş</h2>
                        <div class="pull-right">
                            <div class="product-slick-dots-2 custom-dots">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @include('common.errors.validate')
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <form action="{{ route('user.change_password') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <label for="password">Yeni Şifrə</label>
                                <input class="input" type="password" required name="password" 
                                       placeholder="Yeni şifrəni daxil edin">
                            </div>
                            <div class="form-group">
                                <label for="passsword_confirmation">Yeni Şifrə Təkrar</label>
                                <input class="input" type="password" required name="password_confirmation" 
                                       placeholder="Şifrəni təsdiqləyin">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="primary-btn">Şifrəni dəyiş</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection

