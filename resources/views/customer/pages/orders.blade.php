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
                                                        @if($order->status=='Pending')
                                                            <label class="label label-danger">{{ $order->status }}</label>
                                                        @elseif($order->status=='Your order has been received')
                                                            <label class="label label-success">@lang('content.Your order has been received')</label>
                                                        @elseif($order->status=='Your order has been received')
                                                            <label class="label label-success">@lang('content.Your order has been received')</label>
                                                        @endif
                                                    </td>
                                                    <td>{{ $order->created_at }}</td>
                                                    <td><a href="{{ route('order', $order->id) }}"
                                                           class="btn btn-xs btn-warning">@lang('content.View')</a>
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