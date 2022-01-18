@extends('customer.layouts.master')
@section('title', __('footer.My Wishlist'))
@section('head')
@endsection
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="/">@lang('content.Home')</a></li>
                <li class="active">@lang('footer.My Wishlist')</li>
            </ul>
        </div>
    </div>
    <!-- /BREADCRUMB -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="main">
                    <div id="store">
                        <!-- row -->
                        <div class="row products"></div>
                        <!-- /row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        products();

        function products() {
            $.ajax({
                url: '{{ route("view_my_wish_list") }}',
                method: 'GET',
                success: function (data) {
                    $('.products').html(data);
                }
            });
        };
        $(document).on('click', '.add-wish-list', function(){
            var id = $(this).attr("data-id");
            $.ajax({
                url: '{{ route("remove_wish_list") }}',
                    method: 'GET',
                    data: {id: id},
                    success: function (data) {
                        console.log(data);
                        products();
                }
            });
        })
    </script>
@endsection