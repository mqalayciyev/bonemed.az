@extends('manage.layouts.master')
@section('title', __('admin.Sell Manager'))
@section('head')
    <style>

        #searched .box {
            opacity: 0.8;
        }

        #searched .box:hover {
            cursor: pointer;
            opacity: 1;
            box-shadow: 0px 0px 2px #000;
        }

        .sale_body {
            overflow: auto;
            height: 175px;
        }

        .manual_cart_remove, .sale_price {
            padding: 5px;
            cursor: pointer;
        }

        .manual_cart_remove:hover {
            background: #f00;
            color: #fff;
            border-radius: 3px;
        }

        ul.bill_detail {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        ul.bill_detail li {
            padding: 5px;
        }

        ul.bill_detail li:nth-child(2) {
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
            padding-bottom: 10px;
            color: #0b93d5;
        }

        ul.bill_detail li .discount {
            position: relative;
        }

        ul.bill_detail li .discount:hover {
            text-decoration: underline;
            cursor: pointer;
        }

        ul.bill_detail li .arrow_left {
            display: inline-block;
            position: absolute;
            right: -6px;
            top: 50%;
            width: 10px;
            height: 10px;
            border-top: 1px solid #999;
            border-right: 1px solid #999;
            background: #fff;
            transform: rotate(45deg);
        }

        ul.bill_detail li .discount_modal {
            display: none;
            position: absolute;
            left: -240px;
            top: 18%;
            box-shadow: -1px 3px 10px #555;
            background: #fff;
            z-index: 1;
            padding: 20px;
            color: #333;
            width: 250px;
        }

        ul.bill_detail li .discount_modal .per_man {
            display: flex;
        }

        .percent, .manat {
            flex: 1;
            font-size: 20px;
            border: 1px solid #999;
            display: inline-block;
            text-align: center;
            padding: 10px;
        }

        .discount_border {
            border: 2px solid #0b93d5;
        }

    </style>
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
    <div class="modal fade" id="customer_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="customer_form" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">@lang('admin.Add New Customer')</h4>
                    </div>
                    <div class="modal-body">
                        <span id="form_output"></span>
                        <div class="form-group">
                            <label for="name">@lang('admin.Customer Name')</label> <br>
                            <input type="text" name="name" class="form-control name"
                                   id="name" placeholder="@lang('admin.Customer Name')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">@lang('admin.Close')</button>
                        <input type="submit" name="submit" id="action"
                               class="btn btn-success add_customer"
                               value="@lang('admin.Save Customer')"/>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <br>
                    <br>
                    <label for="">@lang('admin.Search for products')</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <input type="text" class="form-control input-lg sfp" id="sfp" name="sfp"
                               placeholder="@lang('admin.Start typing or scanning')" value="{{ old('sfp') }}">
                    </div>
                    <br>
                    <div id="searched" class="searched">
                        <div class="row"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default btn_trash"><i class="fa fa-trash"></i> @lang('admin.Discard Sale')</button>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <div class="box box-solid">
                        <form action="" class="sale" onsubmit="return false">
                            <div class="box-header with-border sale_header">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <select class="form-control select2" style="width: 100%;"
                                            id="customer"
                                            name="customer"
                                            data-placeholder="@lang('admin.Add a customer')">
                                        <option></option>
                                        @foreach($customers as $customer)
                                            <option value="{{ old('customer',$customer->id) }}" {{ collect(old('customer', $product_customers))->contains($customer->id) ? 'selected' : '' }}>{{ old('customer',$customer->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="sale_body">
                                    <ul class="list-group sale_list"></ul>
                                </div>
                                <div class="sale_content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea name="sale_note" class="form-control"></textarea>
                                            <hr>
                                            <ul class="bill_detail">
                                                <li>
                                                    <div class="pull-left">@lang('admin.Sub-total')</div>
                                                    <div class="pull-right"><span class="sub_total_price">0.00</span> ‎₼
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </li>
                                                <li>
                                                    <div class="pull-left">
                                                        <span class="discount" id="discount">@lang('admin.Discount')</span>
                                                        <div class="discount_modal" id="discount_modal">
                                                            <h4 class="text-center" id="dis_h4">@lang('admin.Apply discount to sale')</h4>
                                                            <hr style="border-top:1px solid #555" id="hr">
                                                            <div class="per_man" id="per_man">
                                                                <span class="percent" id="percent">%</span>
                                                                <span class="manat" id="manat">‎₼</span>
                                                            </div>
                                                            <br>
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="addon_trash"><span
                                                                            class="fa fa-trash discount_trash"></span></span>
                                                                <input type="text"
                                                                       class="form-control input-lg discount_p text-right"
                                                                       id="discount_p" name="discount_p" value="0">
                                                                <span class="input-group-addon discount_val"
                                                                      id="addon_val">%</span>
                                                            </div>
                                                            <span class="arrow_left"></span>
                                                        </div>
                                                    </div>
                                                    <div class="pull-right"><span class="discount_price">0.00</span> ‎₼
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </li>
                                                <li>
                                                    <div class="pull-left">@lang('admin.Total')</div>
                                                    <div class="pull-right"><span class="total_price">0.00</span> ‎₼
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer sale_footer">
                                <button class="btn-block btn btn-success btn-lg text-bold btn_pay">
                                    <div class="pull-left">@lang('admin.Pay')</div>
                                    <div class="pull-right"><span class="total_price">0.00</span> ‎₼</div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
        $(function () {

            $('#customer').select2({
                tags: true,
                escapeMarkup: function (markup) {
                    return markup;
                },
                insertTag: function (data, tag) {
                    $('#customer_modal #name').val(tag.text);
                    tag.text = '<div><i class="fa fa-plus"></i> {{ __('admin.Add') }}: ' + tag.text + '</div>';
                    data.push(tag);
                },
                language: 'az'
            }).on('select2:select', function () {
                if ($(this).find("option:selected").data("select2-tag") == true) {
                    $('#customer_modal').modal('show');
                    $('#customer_modal #form_output').html('');
                    $('#customer_modal #action').val('{{ __('admin.Save Customer') }}');
                }
            });
            $('form#customer_form').submit(function (event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    url: '{{ route('manage.customer.post_data') }}',
                    data: form_data,
                    dataType: 'json',
                    success: function (data) {
                        if (data.error.length > 0) {
                            var error_html = '';
                            for (var count = 0; count < data.error.length; count++) {
                                error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                            }
                            $('#customer_modal #form_output').html(error_html).hide().fadeIn('slow');
                        } else {
                            $('#customer_modal #form_output').html(data.success).hide().fadeIn('slow').fadeTo(5000, 0.50);
                            $('#customer_modal form#customer_form')[0].reset();
                            $('#customer_modal #action').val('{{ __('admin.Save Customer') }}');
                            $('#customer_modal .modal-title').text('{{ __('admin.Add New Customer') }}');
                        }
                    }
                });
            });

            $(document).mouseup(function (e) {
                var container = $(".discount_modal");
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.hide();
                }
            });

            $('.discount').click(function () {
                $('.discount_modal').toggle().attr('data-id', 'on');
                $('.percent').addClass('discount_border');
                $('.discount_p').attr('id', 'per').val('0').select();
            });

            $(document).on('click', '.discount_trash', function () {
                $('.discount_p').val('‎0.00').select();
                $('.discount_price').text('0');
            });

            $(document).on('click', '.manat', function () {
                $('.percent').removeClass('discount_border');
                $('.discount_val').text('‎₼');
                $('.discount_p').attr('id', 'man').val('0.00').select();
                $(this).addClass('discount_border');
            });
            $(document).on('click', '.percent', function () {
                $('.manat').removeClass('discount_border');
                $('.discount_val').text('‎%');
                $('.discount_p').attr('id', 'per').val('0').select();
                $(this).addClass('discount_border');
            });

            if ($('.total_price').html() == 0.00) {
                $('.btn_trash, .btn_pay').attr('disabled', true);
            }


            $('.discount_p').keyup(function () {
                var val = $(this).val();
                $('.discount_price').text(val);
                if ($(this).attr('id') == 'man') {
                    var total = $('.sub_total_price').text() - $(this).val();
                    $('.total_price').text(total.toFixed(2));
                } else if ($(this).attr('id') == 'per') {

                    var total = $('.sub_total_price').text() - (($('.sub_total_price').text() * $(this).val()) / 100).toFixed(2);
                    $('.total_price').text(total.toFixed(2));
                }
            });

            products();

            function products() {
                $.ajax({
                    url: "{{ route('manage.sell.products') }}",
                    method: 'POST',
                    success: function (data) {
                        $('#searched .row').html(data);
                    }
                });
            }

            $('input[name=sfp]').keyup(function () {
                var val = $(this).val();
                $.ajax({
                    url: '{{ route('manage.sell.search') }}',
                    method: 'POST',
                    data: {val: val},
                    success: function (data) {
                        $('#searched .row').html(data);
                    }
                });
            });

            $(document).on('click', '.product', function () {
                var id = $(this).attr('id');
                $('.btn_trash, .btn_pay').attr('disabled', false);
                $.ajax({
                    url: '{{ route('manage.sell.sale_list') }}',
                    method: 'POST',
                    data: {id: id},
                    dataType: 'JSON',
                    success: function (data) {
                        $('.sale_list').prepend(data.sale_list);
                        $('.total_price').html(data.total_price);
                        $('.sub_total_price').html(data.total_price);
                        if (data.warning_message) {
                            alert(data.warning_message);
                        }
                    }
                })
            });

            $(document).on('click', '.manual_cart_remove', function () {
                var id = $(this).attr('id');
                $(this).parent().hide();
                $.ajax({
                    url: '{{ route('manage.sell.manual_cart_remove') }}',
                    method: 'POST',
                    data: {id: id},
                    dataType: 'JSON',
                    success: function (data) {
                        $('.total_price').html(data.total_price);
                        $('.sub_total_price').html(data.total_price);
                        if ($('.total_price').html() == 0.00) {
                            $('.btn_trash, .btn_pay').attr('disabled', true);
                        }
                    }
                })
            });

            $(document).on('click', '.btn_trash', function () {
                $('.btn_trash, .btn_pay').attr('disabled', true);
                $('ul.sale_list li').hide();
                $('.total_price').html('0.00');
                $('.discount_price').html('0.00');
                $('.sub_total_price').html('0.00');
                $.ajax({
                    url: '{{ route('manage.sell.trash_cart') }}',
                    method: 'POST'
                })
            });

        })
        ;
    </script>
@endsection