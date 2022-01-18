<style>

    .contact-info span {
        font-size: 14px;
        padding: 0px 50px 0px 50px;
    }

    .contact-info hr {
        margin-top: 0px;
        margin-bottom: 0px;
    }

    .client-info {
        font-size: 15px;
    }

    .ttl-amts {
        text-align: right;
        padding-right: 50px;
    }

</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <div class="container">

        <div class="row pad-top-botm " style="display: flex; padding-bottom: 40px;
        padding-top: 60px; flex-wrap: wrap;">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <img src="{{ asset('img/logo-1615450298.png') }}" style="padding-bottom:20px;">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">

                <strong style="text-transform: uppercase;">Bonemed Ortopediya</strong>
                <br>
                <i>Ünvan : </i>{{ old('address', $website_info->address) }}

            </div>
        </div>
        <div class="row text-center contact-info">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <hr>
                <span>
                    <strong>Email : </strong> {{ old('email', $website_info->email) }}
                </span>
                <span>
                    <strong>Tel : </strong> {{ old('mobile', $website_info->mobile) }}
                </span>
                <hr>
            </div>
        </div>
        <div class="row pad-top-botm client-info">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h4><strong  style="text-transform: uppercase;">Müsteri  Melumatlari</strong></h4>
                <br>
                <b>Ad:</b>{{ (isset($client_firstname)) ? $client_firstname : '' }}
                <br>
                <b>Soyad:</b>{{ (isset($client_lastname)) ? $client_lastname : '' }}
                <br>
                <b>Ünvan:</b>{{ (isset($client_address)) ? $client_address : '' }}
                <br>
                <b>Tel :</b>{{ (isset($client_tel)) ? $client_tel : '' }}
                <br>
                <b>E-mail:</b>{{ (isset($client_email)) ? $client_email : '' }}
            </div>
            <br>
            <div class="col-lg-6 col-md-6 col-sm-6">

                <h4><strong  style="text-transform: uppercase;">Ödenis Melumatlari </strong></h4>
                <b>Ödenis meblegi : {{ (isset($total_amount)) ? $total_amount : '' }} </b>
                <br>
                <b>Ödenis statusu : {{ (isset($payment_status)) ? $payment_status : '' }} </b>
                <br>
                Sifaris tarixi : {{ (isset($order_date)) ? $order_date : '' }}
                <br>
                Ödenis tarixi : {{ (isset($payment_date)) ? $payment_date : '' }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Mehsul adi</th>
                                <th>Miqdari</th>
                                <th>Vahid qiymet</th>
                                <th>Cemi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($order_items))
                                @foreach ($order_items as $item)
                                    <tr >
                                        <td style="text-transform: lowercase">{{ $item->product->product_name }}</td>
                                        <td>{{ $item->piece }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->amount * $item->piece }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="ttl-amts">
                    <h5>Endirim : {{ (isset($discount)) ? $discount : '' }}</h5>
                </div>
                <hr>
                <div class="ttl-amts">
                    <h4 style="text-transform: uppercase"><strong>Ümumi Mebleg : {{ (isset($total_amount)) ? $total_amount : '' }}</strong></h4>
                </div>
                
            </div>
        </div>
    </div>
