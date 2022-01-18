@extends('customer.pages.user.account')
@section('content.account')

    <div class="accountContent">
        <span class="accountTitle">
            @if (auth()->check())
                {{ 'Sayın, ' . ucwords(auth()->user()->first_name) }}
            @else
                @lang('content.Account.Home.Greetings', ['fullName' => "Guest" ])
            @endif
        </span>
        <p>{{ config('app.name')}}’dan verdiğiniz siparişleri, tedarik ve kargo durumlarını, kazandığınız puanları, üyelik
            bilgilerinizi, buradan görüntüleyebilir ve güncelleyebilirsiniz.</p>
        <div class="clearfix">
            <a href="{{ route('orders') }}" class="buttonAccount">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                Sifariş Takibi
            </a>
            <a href="mailto:{{ old('email', $website_info->email) }}" class="buttonAccount">
                <i class="fa fa-comment" aria-hidden="true"></i>
                Mesaj Göndər
            </a>
        </div>
        <div class="company-information">
            <span class="accountTitle">
                Şirkət Məlumatları
            </span>
            <p></p>
            <ul>
                <li>
                    <span><strong>Ünvanı:</strong> {{ old('address', $website_info->address) }}</span>
                </li>
                <li>
                    <span><strong>Telefon:</strong> <a href="{{ old('mobile', $website_info->mobile) }}">{{ old('mobile', $website_info->mobile) }}</a> (Çağrı Mərkəzi)</span>
                </li>
                <li>
                    <span><strong>E-posta:</strong> <a href="mailto:{{ old('email', $website_info->email) }}">{{ old('email', $website_info->email) }}</a></span>
                </li>
            </ul>
        </div>
    </div>
@endsection
