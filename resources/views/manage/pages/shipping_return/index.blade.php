@extends('manage.layouts.master')
@section('title', 'Göndərmə və Qaytarma')
@section('content')
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <section class="content">
        <form action="{{ route('manage.shipping_return.save') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="pull-left"><h3>Göndərmə və Qaytarma</h3></div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i> Yenilə</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel panel-default" >
                <textarea id="shipping_return" name="shipping_return" placeholder="Your text . . .">{{ old('shippingreturn', $shippingreturn->shipping_return) }}</textarea>
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
    CKEDITOR.replace('shipping_return', {
        fullPage: true,
        allowedContent: true,
        autoGrow_onStartup: true,
        enterMode: CKEDITOR.ENTER_BR
    });
  </script>
    
@endsection
