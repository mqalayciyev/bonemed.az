@extends('manage.layouts.master')
@section('title', __('admin.Order Manager'))
@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('content')
@if (@$manage == 2)
    <!-- Demo Admin -->
        @php
            $disabled = "disabled"
        @endphp
    @else
        @php
            $disabled = ""
        @endphp
    @endif
    <section class="content-header">
        <h1>@lang('admin.Orders')</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('manage.homepage') }}"><i class="fa fa-dashboard"></i> @lang('admin.Home')</a></li>
            <li class="active">@lang('Order Manager ')</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-body box-primary">
                    @include('common.errors.validate')
                    @include('common.alert')
                    <form action="{{ route('manage.order.save', @$entry->id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="pull-right">
                            @if($entry->id>0)
                                <button type="submit" {{ $disabled }} class="btn btn-info"><i
                                            class="fa fa-refresh"></i> @lang('admin.Update')</button>
                            @endif
                        </div>
                        <h4 class="sub-header">{{ $entry->id>0 ? $entry->first_name.' '.$entry->last_name  : '' }}</h4>
                        <hr>
                        <input type="hidden" name="cart_id" value="{{ $entry->cart_id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="first_name">@lang('admin.First Name')</label>
                                    <input type="text" class="form-control" id="first_name" placeholder="@lang('admin.Name')"
                                           name="first_name"
                                           value="{{ old('name', $entry->first_name) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name">@lang('admin.Last Name')</label>
                                    <input type="text" class="form-control" id="last_name" placeholder="@lang('admin.Name')"
                                           name="last_name"
                                           value="{{ old('name', $entry->last_name) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">@lang('admin.Phone')</label>
                                    <input type="text" class="form-control" id="phone" placeholder="@lang('admin.Phone')"
                                           name="phone"
                                           value="{{ old('phone', $entry->phone) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile">@lang('admin.Mobile')</label>
                                    <input type="text" class="form-control" id="mobile" placeholder="@lang('admin.Mobile')"
                                           name="mobile"
                                           value="{{ old('mobile', $entry->mobile) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">@lang('admin.Address')</label>
                                    <input type="text" class="form-control" id="address" placeholder="@lang('admin.Address')"
                                           name="address"
                                           value="{{ old('address', $entry->address) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">@lang('admin.Status')</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Your order has been received" {{ old('status', $entry->status) == 'Your order has been received' ? 'selected' : '' }}>
                                            @lang('admin.Your order has been received')
                                        </option>
                                        <option value="Payment approved" {{ old('status', $entry->status) == 'Payment approved' ? 'selected' : '' }}>
                                            @lang('admin.Payment approved')
                                        </option>
                                        <option value="Cargoed" {{ old('status', $entry->status) == 'Cargoed' ? 'selected' : '' }}>
                                            @lang('admin.Cargoed')
                                        </option>
                                        <option value="Order completed" {{ old('status', $entry->status) == 'Order completed' ? 'selected' : '' }}>
                                            @lang('admin.Order completed')
                                        </option>
                                        <option value="Your order is canceled" {{ old('status', $entry->status) == 'Your order is canceled' ? 'selected' : '' }}>
                                            @lang('admin.Your order is canceled')
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" data-id="{{ $entry->id }}" class="btn btn-default view_invoice"><i class="fa fa-arrow-down"></i> Invoice</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-body box-info">

                    <h3>Sipariş (SP-{{ $entry->id }})</h3>
                    <table class="table table-bordererd table-hover">
                        <tr>
                            <th colspan="2">Ürün</th>
                            <th>Tutar</th>
                            <th>Adet</th>
                            <th>Ara Toplam</th>
                            <th>Durum</th>
                        </tr>
                        @foreach($entry->cart->cart_products as $cart_product)
                        
                            <tr>
                                <td style="widht:120px;">
                                    <a href="{{ route('product', $cart_product->product->slug) }}">
                                        <img src="{{ $cart_product->product->image->image_name!=null ? asset('img/products/'.$cart_product->product->image->image_name) : 'http://via.placeholder.com/120x100?text=ProductPhoto' }}"
                                             class="img-responsive" style="width: 100px;">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('product', $cart_product->product->slug) }}">
                                        {{ $cart_product->product->product_name }}
                                    </a>
                                </td>
                                <td>{{ $cart_product->amount }}</td>
                                <td>{{ $cart_product->piece }}</td>
                                <td>{{ $cart_product->amount * $cart_product->piece }}</td>
                                <td>{{ $cart_product->status }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="4" class="text-right">Toplam Tutar</th>
                            <td colspan="2">{{ $entry->order_amount }} ₺</td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-right">Toplam Tutar (KDV'li)</th>
                            <td colspan="2">{{ $entry->order_amount*((100+config('cart.tax'))/100) }} ₺</td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-right">Sipariş Durumu</th>
                            <td colspan="2">{{ $entry->status }}</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </section>

    

@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" integrity="sha512-ToRWKKOvhBSS8EtqSflysM/S7v9bB9V0X3B1+E7xo7XZBEZCPL3VX5SFIp8zxY19r7Sz0svqQVbAOx+QcLQSAQ==" crossorigin="anonymous"></script>
<script>
        function pdfFromHTML(data) {
            var pdf = new jsPDF('p', 'pt', 'letter');
            pdf.setFont("Times New Roman");
            pdf.setFontType("normal");
            source = data;
            specialElementHandlers = {
                '#bypassme': function (element, renderer) {
                    return true
                }
            };
            margins = {
                top: 40,
                bottom: 40,
                left: 40,
                width: 520
            };
            pdf.fromHTML(
            source,
            margins.left,
            margins.top, {
                'width': margins.width,
                'elementHandlers': specialElementHandlers
            },

            function (dispose) {
                pdf.save('invoice.pdf');
            }, margins);
        }
        $(document).on('click', '.view_invoice', function(){
            let id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('manage.order.invoice_view') }}",
                type: "POST",
                data: {"_token" : "{{ csrf_token() }}", id},
                success:  function(data){
                    console.log(data);
                    pdfFromHTML(data)
                    
                }
            })
        })
    </script>
@endsection