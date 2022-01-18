@extends('manage.layouts.master')
@section('title', 'Veb sayt məlumatı')
@section('content')
    <section class="content">
        <form action="{{ route('manage.info.save') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="pull-left"><h3>Veb sayt məlumatı</h3></div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i> Yenilə</button>
                </div>
                <div class="clearfix"></div>
            </div>
            @include('general.back.alert')
            @include('general.back.validate')
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-body box-primary">
                        <div class="container-fluid">
                            <div>
                                <div class="form-group">
                                    <label for="logo">Logo:</label>
                                    <input type="file" name="logo" class="form-control" id="logo">
                                    <img src="{{ asset('img/' . $website_info->logo) }}" alt="{{ $website_info->logo }}">
                                </div>
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $website_info->title) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <input type="text" name="description" class="form-control" id="description" value="{{ old('description', $website_info->description) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="keywords">Keywords:</label>
                                    <input type="text" name="keywords" class="form-control" id="keywords" value="{{ old('keywords', $website_info->keywords) }}">
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="phone">Telefon:</label>
                                            <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone', $website_info->phone) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="mobile">Mobil:</label>
                                            <input type="text" name="mobile" class="form-control" id="mobile" value="{{ old('mobile', $website_info->mobile) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="text" name="email" class="form-control" id="email" value="{{ old('email', $website_info->email) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="margin-bottom">
                                <div class="form-group">
                                    <label for="address">Ünvan:</label>
                                    <input type="text" name="address" class="form-control" id="address" value="{{ old('address', $website_info->address) }}">
                                </div>
                            </div>
                            <hr>
                            <h4>Sosial şəbəkələr</h4>
                            <div class="margin-bottom">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                    <input type="text" class="form-control" placeholder="Facebook link" name="facebook" value="{{ old('facebook', $website_info->facebook) }}">
                                </div>
                            </div>
                            <div class="margin-bottom">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                                    <input type="text" class="form-control" placeholder="Instagram link" name="instagram" value="{{ old('instagram', $website_info->instagram) }}">
                                </div>
                            </div>
                            <div class="margin-bottom">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                                    <input type="text" class="form-control" placeholder="Twitter link" name="twitter" value="{{ old('twitter', $website_info->twitter) }}">
                                </div>
                            </div>
                            <div class="margin-bottom">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-youtube"></i></span>
                                    <input type="text" class="form-control" placeholder="Yotube link" name="youtube" value="{{ old('youtube', $website_info->youtube) }}">
                                </div>
                            </div>
                            <div class="margin-bottom">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pinterest"></i></span>
                                    <input type="text" class="form-control" placeholder="Pinterest link" name="pinterest" value="{{ old('pinterest', $website_info->pinterest) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i> Yenilə</button>
                </div>
                <div class="clearfix"></div>
            </div>
        </form>
    </section>
@endsection
