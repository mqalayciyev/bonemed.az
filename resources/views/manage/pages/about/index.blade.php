@extends('manage.layouts.master')
@section('title', 'Haqqımızda')
@section('content')
    <section class="content">
        <form action="{{ route('manage.about.save') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="pull-left"><h3>Haqqımızda</h3></div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i> Yenilə</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel panel-default">
                <textarea id="about" name="about" placeholder="Your text . . .">{{ old('about', $about ? $about->about : null) }}</textarea>
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

@section('footer')
@include('manage.layouts.partials.ckeditorService',['uploadUrl'=>route('ckeditorProductUpload'),'editor'=>"about"])

    
@endsection
