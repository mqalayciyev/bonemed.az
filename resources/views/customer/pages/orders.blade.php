@extends('customer.pages.user.account')
@section('title', __('content.Orders'))
@section('content.account')
    <div class="section accountContent">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="Order-list">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4>@lang('content.User Order List')</h4>
                            </div>
                            <div class="panel-body">
                                @if(count($orders)>0)
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('content.Amount')</th>
                                                <th>Status</th>
                                                <th>@lang('content.Date')</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $no=1 @endphp
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        <label class="label label-danger">{{ $order->order_amount }} ‎₼</label>
                                                    </td>
                                                    <td>
                                                        @if ($order->status == 'Payment is expected')
                                                            <label class="badge badge-warning">@lang('content.Payment is expected')</label>
                                                        @elseif($order->status=='Your order has been received')
                                                            <label class="badge badge-info">@lang('admin.Pending')</label>
                                                        @elseif($order->status=='Payment approved')
                                                            <label class="badge badge-info">@lang('content.Payment approved')</label>
                                                        @elseif($order->status=='Cargoed')
                                                            <label class="badge badge-info">@lang('content.Cargoed')</label>
                                                        @elseif($order->status=='Order completed')
                                                            <label class="badge badge-success">@lang('content.Order completed')</label>
                                                        @elseif($order->status=='Your order is canceled')
                                                            <label class="badge badge-danger">@lang('content.Your order is canceled')</label>
                                                        @else
                                                            <label class="badge badge-secondary">{{ $order->status }}</label>
                                                        @endif
                                                    </td>
                                                    <td>{{ $order->created_at }}</td>
                                                    <td>
                                                        <a href="{{ route('order', $order->id) }}" class="btn btn-xs btn-warning">@lang('content.View')</a>
                                                        {!! $order->order_status == "PENDING" ? "<a href='" . route('complete', $order->id) . "' class='btn btn-xs btn-success'>Ödənişi tamamla</a>" : ""  !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <h4 class="text-center">@lang('content.There is no any orders')</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- ORDER LIST END-->
                </div>
            </div>
        </div>
    </div>
@endsection