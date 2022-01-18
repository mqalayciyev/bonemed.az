@extends('manage.layouts.master')
@section('title', 'Haqqımızda')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
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
                <textarea id="about" name="about" placeholder="Your text . . .">{{ old('about', $about->about) }}</textarea>
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
<script>
    CKEDITOR.replace('about', {
        fullPage: true,
        allowedContent: true,
        autoGrow_onStartup: true,
        enterMode: CKEDITOR.ENTER_BR
    });
  </script>
    
@endsection
