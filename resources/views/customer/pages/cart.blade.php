@extends('customer.layouts.master')
@section('title', __('content.Cart'))
@section('content') <!-- BREADCRUMB -->
<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="/">@lang('content.Home')</a></li>
            <li class="active">@lang('content.My Cart')</li>
        </ul>
    </div>
</div> <!-- /BREADCRUMB -->
<div class="section">
    <div class="container">

        <div class="section-title"><h3 class="title">@lang('content.Order Review')</h3></div>
        @include('common.alert')
        <div class="my_cart"></div>
    </div>
</div>
@endsection
@section('footer')
    <script>
        $(function () {
            my_cart();

            function my_cart() {
                $.ajax({
                    url: '{{ route('cart.my_cart') }}',
                    type: 'GET',
                    success: function (data) {
                        $('.my_cart').html(data);
                    }
                });
            }
            
            $(document).on('click', '.ProductQuantity-Minus',  function(){
                var piece = $('#input').val()
                $('#input').val(--piece);
                var rowID = $("#input").attr('data-id');
                $.ajax({
                    url: '{{ route('cart.update_cart') }}',
                    type: 'GET',
                    data: {rowID: rowID, piece: piece},
                    success: function (data) {
                        my_cart();
                        $('.show_cartCount').html(data);
                    }
                });
            })
            $(document).on('click', '.ProductQuantity-Plus',  function(){
                var piece = $('#input').val()
                $('#input').val(++piece);
                var rowID = $("#input").attr('data-id');
                $.ajax({
                    url: '{{ route('cart.update_cart') }}',
                    type: 'GET',
                    data: {rowID: rowID, piece: piece},
                    success: function (data) {
                        my_cart();
                        $('.show_cartCount').html(data);
                    }
                });
            })

            $(document).on('click', '.delete', function () {
                var rowID = $(this).attr('id');
                $.ajax({
                    url: '{{ route('cart.delete') }}',
                    type: 'GET',
                    data: {rowID: rowID},
                    success: function () {
                        my_cart();
                    }
                })
            });

            $(document).on('click', '.trash_cart', function () {
                $.ajax({
                    url: '{{ route('cart.destroy') }}',
                    success: function () {
                        my_cart();
                    }
                })
            })

        });
    </script>
@endsection