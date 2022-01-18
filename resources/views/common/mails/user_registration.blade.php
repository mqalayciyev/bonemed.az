<h1>{{ config('app.name') }}</h1>
<p>@lang('content.Welcome') {{ $user->name }}, @lang('content.your registration has been successfully completed')</p>
<p>@lang('content.Please click below Activate link and activate your registration')</p>
<p><strong><a href="{{ config('app.url') }}/user/activate/{{ $user->activation_key }}">@lang('content.Activate')</a></strong></p>