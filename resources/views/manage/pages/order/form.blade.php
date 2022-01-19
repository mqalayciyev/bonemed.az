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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" placeholder="Email" name="email"
                                        value="{{ old('email', $entry->email) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">Şəhər</label>
                                    <input type="text" class="form-control" id="city" placeholder="Şəhər" name="city"
                                        value="{{ old('city', $entry->city) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="zip_code">Poçt Kodu</label>
                                    <input type="text" class="form-control" id="zip_code" placeholder="Şəhər" name="zip_code"
                                        value="{{ old('zip_code', $entry->zip_code) }}">
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
                            <div class="col-xs-12">
                                <p style="color: red; font-weight: bold;" >
                                    {{ old('status', $entry->status) == 'Payment is expected' ? 'Müştəri sifarişin ödənişini tamamlamayıb. Ödəniş tamamlanana qədər statusu dəyişdirə biməiniz.' : '' }}
                                    </p>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">@lang('admin.Status')</label>
                                    
                                    
                                    <select name="status" id="status" class="form-control" 
                                        {{ old('status', $entry->status) == 'Payment is expected' ? 'disabled' : '' }}>
                                        <option value="Your order has been received"
                                            {{ old('status', $entry->status) == 'Your order has been received' ? 'selected' : '' }}>
                                            @lang('admin.Pending')
                                        </option>
                                        <option value="Payment approved"
                                            {{ old('status', $entry->status) == 'Payment approved' ? 'selected' : '' }}>
                                            @lang('admin.Payment approved')
                                        </option>
                                        <option value="Cargoed"
                                            {{ old('status', $entry->status) == 'Cargoed' ? 'selected' : '' }}>
                                            @lang('admin.Cargoed')
                                        </option>
                                        <option value="Order completed"
                                            {{ old('status', $entry->status) == 'Order completed' ? 'selected' : '' }}>
                                            @lang('admin.Order completed')
                                        </option>
                                        <option value="Your order is canceled"
                                            {{ old('status', $entry->status) == 'Your order is canceled' ? 'selected' : '' }}>
                                            @lang('admin.Your order is canceled')
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <p style="color: red;">*Sifariş statusu "Ləğv edildi" olaraq seçildiyi halda məhsullarının sayı stokdakı məhsul sayına geri əlavə edilir</p>
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
                            <th colspan="2">Məhsul</th>
                                <th>Qiyməti</th>
                                <th>Miqdar</th>
                                <th>Ümumi qiymət</th>
                                <th>Status</th>
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
                                <td>
                                    @if ($entry->status == 'Payment is expected')
                                        @lang('content.Payment is expected')
                                    @elseif($entry->status=='Your order has been received')
                                        @lang('admin.Pending')
                                    @elseif($entry->status=='Payment approved')
                                        @lang('content.Payment approved')
                                    @elseif($entry->status=='Cargoed')
                                        @lang('content.Cargoed')
                                    @elseif($entry->status=='Order completed')
                                        @lang('content.Order completed')
                                    @elseif($entry->status=='Your order is canceled')
                                        @lang('content.Your order is canceled')
                                    @else
                                        {{ $entry->status }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="4" class="text-right">Çatdırılma</th>
                            <td colspan="2">
                                {{ $entry->shipping }} ₼
                            </td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-right">Toplam Tutar</th>
                            <td colspan="2">{{ $entry->order_amount }} ₺</td>
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
<script>

        $(document).on('click', '.view_invoice', function() {
            let id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('manage.order.invoice_view') }}",
                type: "GET",
                xhrFields: {
                    responseType: 'blob'
                },
                data: {
                    id
                },
                success: function(data) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = 'invoice.pdf';
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);

                }
            })
        })
    </script>
@endsection