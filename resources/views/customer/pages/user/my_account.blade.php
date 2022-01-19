@extends('customer.pages.user.account')
@section('content.account')

    <div class="accountContent">
        <span class="accountTitle">
            {{ 'Salam, ' . ucwords(auth()->user()->first_name) }}
        </span>
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
                    <span><strong>Ünvan:</strong> {{ old('address', $website_info->address) }}</span>
                </li>
                <li>
                    <span><strong>Telefon:</strong> <a href="tel:{{ old('mobile', $website_info->mobile) }}">{{ old('mobile', $website_info->mobile) }}</a></span>
                </li>
                <li>
                    <span><strong>E-poçt:</strong> <a href="mailto:{{ old('email', $website_info->email) }}">{{ old('email', $website_info->email) }}</a></span>
                </li>
            </ul>
        </div>
    </div>
@endsection
