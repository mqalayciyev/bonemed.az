<div class="container">
    <table>
        <thead>
            <tr>
                <th>{{ config('app.name') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ünvan</td>
                <td>{{ old('address', $website_info->address) }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ old('email', $website_info->email) }}</td>
            </tr>
            <tr>
                <td>Tel</td>
                <td>{{ old('mobile', $website_info->mobile) }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th>Müsteri Melumatlari</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ad</td>
                <td>{{ $data['client_firstname'] }}</td>
            </tr>
            <tr>
                <td>Soyad</td>
                <td>{{ $data['client_lastname'] }}</td>
            </tr>
            <tr>
                <td>Ünvan</td>
                <td>{{ $data['client_address'] }}</td>
            </tr>
            <tr>
                <td>Tel </td>
                <td>{{ $data['client_tel'] }}</td>
            </tr>
            <tr>
                <td>E-mail</td>
                <td>{{ $data['client_email'] }}</td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th>Ödenis Melumatlari</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ödenis növü </td>
                <td>{{ $data['payment_type'] }} </td>
            </tr>
            <tr>
                <td>Ödenis statusu </td>
                <td> {{ $data['order_status'] }} </td>
            </tr>
            <tr>
                <td>Card </td>
                <td> {{ $data['card_number'] }} </td>
            </tr>
            <tr>
                <td>Brand </td>
                <td>{{ $data['brand'] }} </td>
            </tr>
            <tr>
                <td>Sifaris tarixi </td>
                <td> {{ $data['order_date'] }}</td>
            </tr>
            <tr>
                <td>Ödenis tarixi </td>
                <td> {{ $data['payment_date'] }}</td>
            </tr>
        </tbody>
    </table>
    {{-- <table class="table table-striped table-bordered table-hover"> --}}
    <table>
        <thead>
            <tr>
                <th>Mehsul adi</th>
                <th>Miqdari</th>
                <th>Vahid qiymet</th>
                <th>Cemi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['cart_products'] as $item)
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->piece }}</td>
                    <td>{{ $item->amount }} AZN</td>
                    <td>{{ $item->amount * $item->piece }} AZN</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="text-transform: uppercase"> Yekun məbləğ: {{ $data['order_amount'] }} AZN </h3>

    <h4>Qeyd</h4>
    <p>Alınan məhsullar alış qəbzi əsasında satışa yararlı şəkildə 14 gün ərzində geri qaytarıla və ya dəyişdirilə
        bilər.</p>
</div>
