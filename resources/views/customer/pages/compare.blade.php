@extends('customer.layouts.master')
@section('title', __('footer.Compare'))
@section('head')
@endsection
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="/">@lang('content.Home')</a></li>
                <li class="active">@lang('footer.Compare')</li>
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
            $('.products').html("<h3 class='text-center'>@lang('content.There is no any product')</h3>");
            $.ajax({
                url: '{{ route("compare.view_compare") }}',
                method: 'GET',
                success: function (data) {
                    $('.products').html(data);
                }
            });
        };

        $(document).on('click', '.add-to-compare', function(){
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('compare.remove_from_compare') }}",
                type: "GET",
                data: {id: id},
                success: function(data){
                    console.log(data);
                    products();
                    $(".modal").hide();
                }
            })
        })
        $(document).on('click', '.add-to-cart', function () {
                var id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('cart.add_to_cart') }}',
                    method: 'GET',
                    data: {id: id},
                    dataType: 'JSON',
                    success: function (data) {
                        $('.mobile-navbar').find('#shopping-cart').html(data.output);
                            $('.mobile-navbar').find('.view_cart').html(data.view_cart);
                            $('.mobile-navbar').find('#show_cartTotalPrice').html(data.cart_total);
                            $('.desktop-navbar').find('#shopping-cart').html(data.output);
                            $('.desktop-navbar').find('.view_cart').html(data.view_cart);
                            $('.show_cartCount').html(data.cart_count);
                            $('.desktop-navbar').find('#show_cartTotalPrice').html(data.cart_total);
                    }
                });
            });
            $(document).on('click', '.add-wish-list', function(){
                var id = $(this).attr("data-id");
                $.ajax({
                    url: '{{ route("add_wish_list") }}',
                    method: 'GET',
                    data: {id: id},
                    success: function (data) {
                        alert(data);
                    }
                });
            })
    </script>
@endsection