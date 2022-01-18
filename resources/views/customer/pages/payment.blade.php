@extends('customer.layouts.master')
@section('title', __('content.Payment'))
@section('head')
    <style>
        /* CSS for Credit Card Payment form */
        .credit-card-box .panel-title {
            display: inline;
            font-weight: bold;
        }

        .credit-card-box .form-control.error {
            border-color: red;
            outline: 0;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);
        }

        .credit-card-box label.error {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }

        .credit-card-box .payment-errors {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }

        .credit-card-box label {
            display: block;
        }

        /* The old "center div vertically" hack */
        .credit-card-box .display-table {
            display: table;
        }

        .credit-card-box .display-tr {
            display: table-row;
        }

        .credit-card-box .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
        }

        /* Just looks nicer */
        .credit-card-box .panel-heading img {
            min-width: 180px;
        }
    </style>
@endsection
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('homepage') }}">@lang('content.Home')</a></li>
                <li class="active">@lang('content.Payment')</li>
            </ul>
        </div>
    </div>
    <!-- /BREADCRUMB -->
    <div class="section">
        <div class="container">
            <div class="row">
                <form action="{{ route('pay') }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <div class="billing-details">
                            <div class="section-title">
                                <h3 class="title">@lang('content.Billing Details')</h3>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="first_name" placeholder="@lang('content.First Name')"
                                       value="{{ old('first_name', auth()->user()->first_name) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="last_name" placeholder="@lang('content.Last Name')" value="{{ old('last_name', auth()->user()->last_name) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="email" name="email" placeholder="@lang('content.Email')" value="{{ old('email', auth()->user()->email) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="address" placeholder="@lang('content.Address')" value="{{ old('address', $user_detail->address) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="city" placeholder="@lang('content.City')" value="{{ old('city', $user_detail->city) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="country" placeholder="@lang('content.Country')" value="{{ old('country', $user_detail->country) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="zip_code" placeholder="@lang('content.ZIP Code')" value="{{ old('zip_code', $user_detail->zip_code) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="tel" name="phone" placeholder="@lang('content.Phone')" value="{{ old('phone', $user_detail->phone) }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="tel" name="mobile" placeholder="@lang('content.Mobile')" value="{{ old('mobile', auth()->user()->mobile) }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="shiping-methods">
                            <div class="section-title">
                                <h4 class="title">@lang('content.Shipping Methods')</h4>
                            </div>
                            <div class="input-checkbox">
                                <input type="radio" name="shipping" id="shipping-1" checked>
                                <label for="shipping-1">@lang('content.Free Shipping') - 0.00 ‎₼</label>
                                <div class="caption">
                                    <p>@lang('content.Free Shipping Description')<p>
                                </div>
                            </div>
                            <div class="input-checkbox">
                                <input type="radio" name="shipping" id="shipping-2">
                                <label for="shipping-2">Standard - $4.00</label>
                                <div class="caption">
                                    <p>@lang('content.Standard Description')<p>
                                </div>
                            </div>
                        </div>

                        <div class="payments-methods">
                            <div class="section-title">
                                <h4 class="title">@lang('content.Payments Methods')</h4>
                            </div>
                            <div class="input-checkbox">
                                <input type="radio" name="payments" id="payments-1" checked>
                                <label for="payments-1">@lang('content.Direct Bank Transfer')</label>
                                <div class="caption">
                                    <!-- CREDIT CARD FORM STARTS HERE -->
                                    <div class="panel panel-default credit-card-box">
                                        <div class="panel-heading block">
                                            <div class="row display-tr">
                                                <h3 class="panel-title display-td">@lang('content.Payment Details')</h3>
                                                <div class="display-td">
                                                    <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="form-group">
                                                        <label for="cardNumber">CARD NUMBER</label>
                                                        <div class="input-group">
                                                            <input
                                                                    type="tel"
                                                                    class="form-control"
                                                                    name="cardNumber"
                                                                    placeholder="Valid Card Number"
                                                                    autocomplete="cc-number"
                                                                    required autofocus
                                                            />
                                                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-7 col-md-7">
                                                    <div class="form-group">
                                                        <label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span
                                                                    class="visible-xs-inline">EXP</span> DATE</label>
                                                        <input
                                                                type="tel"
                                                                class="form-control"
                                                                name="cardExpiry"
                                                                placeholder="MM / YY"
                                                                autocomplete="cc-exp"
                                                                required
                                                        />
                                                    </div>
                                                </div>
                                                <div class="col-xs-5 col-md-5 pull-right">
                                                    <div class="form-group">
                                                        <label for="cardCVC">CV CODE</label>
                                                        <input
                                                                type="tel"
                                                                class="form-control"
                                                                name="cardCVC"
                                                                placeholder="CVC"
                                                                autocomplete="cc-csc"
                                                                required
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="form-group">
                                                        <label for="couponCode">COUPON CODE</label>
                                                        <input type="text" class="form-control" name="couponCode"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="display:none;">
                                                <div class="col-xs-12">
                                                    <p class="payment-errors"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- CREDIT CARD FORM ENDS HERE -->
                                </div>
                            </div>
                            <div class="input-checkbox">
                                <input type="radio" name="payments" id="payments-3">
                                <label for="payments-3">@lang('content.Paypal System')</label>
                                <div class="caption">
                                    <p>@lang('content.Paypal System Description')
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button type="submit" value="1" class="primary-btn">@lang('content.Pay')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        var $form = $('#payment-form');
        $form.find('.subscribe').on('click', payWithStripe);

        /* If you're using Stripe for payments */
        function payWithStripe(e) {
            e.preventDefault();

            /* Abort if invalid form data */
            if (!validator.form()) {
                return;
            }

            /* Visual feedback */
            $form.find('.subscribe').html('Validating <i class="fa fa-spinner fa-pulse"></i>').prop('disabled', true);

            var PublishableKey = 'pk_test_6pRNASCoBOKtIshFeQd4XMUh'; // Replace with your API publishable key
            Stripe.setPublishableKey(PublishableKey);

            /* Create token */
            var expiry = $form.find('[name=cardExpiry]').payment('cardExpiryVal');
            var ccData = {
                number: $form.find('[name=cardNumber]').val().replace(/\s/g, ''),
                cvc: $form.find('[name=cardCVC]').val(),
                exp_month: expiry.month,
                exp_year: expiry.year
            };

            Stripe.card.createToken(ccData, function stripeResponseHandler(status, response) {
                if (response.error) {
                    /* Visual feedback */
                    $form.find('.subscribe').html('Try again').prop('disabled', false);
                    /* Show Stripe errors on the form */
                    $form.find('.payment-errors').text(response.error.message);
                    $form.find('.payment-errors').closest('.row').show();
                } else {
                    /* Visual feedback */
                    $form.find('.subscribe').html('Processing <i class="fa fa-spinner fa-pulse"></i>');
                    /* Hide Stripe errors on the form */
                    $form.find('.payment-errors').closest('.row').hide();
                    $form.find('.payment-errors').text("");
                    // response contains id and card, which contains additional card details
                    console.log(response.id);
                    console.log(response.card);
                    var token = response.id;
                    // AJAX - you would send 'token' to your server here.
                    $.post('/account/stripe_card_token', {
                        token: token
                    })
                    // Assign handlers immediately after making the request,
                        .done(function (data, textStatus, jqXHR) {
                            $form.find('.subscribe').html('Payment successful <i class="fa fa-check"></i>');
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            $form.find('.subscribe').html('There was a problem').removeClass('success').addClass('error');
                            /* Show Stripe errors on the form */
                            $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                            $form.find('.payment-errors').closest('.row').show();
                        });
                }
            });
        }

        /* Fancy restrictive input formatting via jQuery.payment library*/
        $('input[name=cardNumber]').payment('formatCardNumber');
        $('input[name=cardCVC]').payment('formatCardCVC');
        $('input[name=cardExpiry').payment('formatCardExpiry');

        /* Form validation using Stripe client-side validation helpers */
        jQuery.validator.addMethod("cardNumber", function (value, element) {
            return this.optional(element) || Stripe.card.validateCardNumber(value);
        }, "Please specify a valid credit card number.");

        jQuery.validator.addMethod("cardExpiry", function (value, element) {
            /* Parsing month/year uses jQuery.payment library */
            value = $.payment.cardExpiryVal(value);
            return this.optional(element) || Stripe.card.validateExpiry(value.month, value.year);
        }, "Invalid expiration date.");

        jQuery.validator.addMethod("cardCVC", function (value, element) {
            return this.optional(element) || Stripe.card.validateCVC(value);
        }, "Invalid CVC.");

        validator = $form.validate({
            rules: {
                cardNumber: {
                    required: true,
                    cardNumber: true
                },
                cardExpiry: {
                    required: true,
                    cardExpiry: true
                },
                cardCVC: {
                    required: true,
                    cardCVC: true
                }
            },
            highlight: function (element) {
                $(element).closest('.form-control').removeClass('success').addClass('error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-control').removeClass('error').addClass('success');
            },
            errorPlacement: function (error, element) {
                $(element).closest('.form-group').append(error);
            }
        });

        paymentFormReady = function () {
            if ($form.find('[name=cardNumber]').hasClass("success") &&
                $form.find('[name=cardExpiry]').hasClass("success") &&
                $form.find('[name=cardCVC]').val().length > 1) {
                return true;
            } else {
                return false;
            }
        }

        $form.find('.subscribe').prop('disabled', true);
        var readyInterval = setInterval(function () {
            if (paymentFormReady()) {
                $form.find('.subscribe').prop('disabled', false);
                clearInterval(readyInterval);
            }
        }, 250);
    </script>
@endsection