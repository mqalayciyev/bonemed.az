@extends('manage.layouts.master')
@section('title', __('admin.Admin Manager'))
@section('head')

@endsection
@section('content')
    <form action="{{ route('manage.admin.save', @$entry->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <section class="content-header">
            <h1 class="pull-left">@lang('admin.Admin')</h1>
            <div class="pull-right">
                @if($entry->id>0)
                    <a href="{{ route('manage.admin.new') }}"
                       class="btn btn-success"> @lang('admin.Add New Admin')</a>
                    <button type="submit" class="btn btn-info"><i
                                class="fa fa-refresh"></i> @lang('admin.Update')</button>
                @else
                    <a href="{{ route('manage.admin') }}"
                       class="btn btn-default"> @lang('admin.Cancel')</a>
                    <button type="submit" class="btn btn-success"><i
                                class="fa fa-plus"></i> @lang('admin.Save')</button>
                @endif
            </div>
            <div class="clearfix"></div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-body box-primary">
                        @include('common.errors.validate_admin')
                        @include('common.alert')
                        <div class="container">
                            <div class="jumbotron">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>@lang('admin.Contact Info')</h3>
                                        <span>@lang('admin.The official name and contact details for your supplier.')</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="first_name">@lang('admin.First Name')</label>
                                                    <input type="text" class="form-control" id="first_name"
                                                           placeholder="@lang('admin.First Name')"
                                                           name="first_name"
                                                           value="{{ old('first_name', $entry->first_name) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name">@lang('admin.Last Name')</label>
                                                    <input type="text" class="form-control" id="last_name"
                                                           placeholder="@lang('admin.Last Name')"
                                                           name="last_name"
                                                           value="{{ old('last_name', $entry->last_name) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mobile">@lang('admin.Mobile')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="mobile"
                                                               placeholder="@lang('admin.Mobile')"
                                                               name="mobile"
                                                               value="{{ old('mobile', $entry->mobile) }}">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-mobile"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="email"
                                                               placeholder="Email"
                                                               name="email"
                                                               value="{{ old('email', $entry->email) }}">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-at"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">@lang('admin.Phone')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="phone"
                                                               placeholder="@lang('admin.Phone')"
                                                               name="phone"
                                                               data-inputmask='"mask": "(999) 999-9999"'
                                                               data-mask=""
                                                               value="{{ old('phone', $entry->phone) }}">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>@lang('admin.Security')</h3>
                                        <span>@lang('admin.A strong password helps to: Keep your personal information.')</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">@lang('admin.Password')</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="password"
                                                               placeholder="@lang('admin.Password')" name="password">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-key"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <br>
                                                    <span>Şifrənin dəyişdirilməsini istəmirsinizsə boş buraxın.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <input type="hidden" name="is_active" value="0">
                                                        <input type="checkbox" class="minimal" name="is_active"
                                                               value="1" {{ old('is_active', $entry->is_active) ? 'checked' : null }}> @lang('admin.Is Active')
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    {{-- <select name="is_manage" class="form-control"> --}}
                                                        {{-- <option value="1">Admin</option> --}}
                                                        {{-- @for ($i = 1; $i <= 3; $i++)
                                                            @if($entry->is_manage == $i)
                                                                @php
                                                                    $selected = 'selected'
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $selected = ''
                                                                @endphp
                                                            @endif
                                                            @if ($i == 1)
                                                            <option value="1" {{ $selected }}>Admin</option>
                                                            @elseif($i == 2)
                                                            <option value="2" {{ $selected }}>Demo</option>
                                                            @elseif($i == 3)
                                                            <option value="3" {{ $selected }}>İstifadəçi</option>
                                                            @endif
                                                        @endfor --}}
                                                    {{-- </select> --}}

                                                    
                                                    <label>
                                                        <input type="checkbox" class="flat-red" name="is_manage"
                                                               value="1" {{ old('is_manage', $entry->is_manage) ? 'checked' : null }}> @lang('admin.Is Manage')
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>@lang('admin.Address')</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="address">@lang('admin.Physical Address')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="address"
                                                               placeholder="@lang('admin.Physical Address')"
                                                               name="address"
                                                               value="{{ old('address', $entry->address) }}">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-map-marker"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="country">@lang('admin.Country')</label>
                                                    <input type="text" class="form-control" id="country"
                                                           placeholder="@lang('admin.Country')"
                                                           name="country"
                                                           value="{{ old('country', $entry->country) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="state">@lang('admin.State')</label>
                                                    <input type="text" class="form-control" id="state"
                                                           placeholder="@lang('admin.State')"
                                                           name="state"
                                                           value="{{ old('state', $entry->state) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="city">@lang('admin.City')</label>
                                                    <input type="text" class="form-control" id="city"
                                                           placeholder="@lang('admin.City')"
                                                           name="city"
                                                           value="{{ old('city', $entry->city) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="zip_code">@lang('admin.Zip Code')</label>
                                                    <input type="text" class="form-control" id="zip_code"
                                                           placeholder="@lang('admin.Zip Code')"
                                                           name="zip_code"
                                                           value="{{ old('zip_code', $entry->zip_code) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
                            @if($entry->id>0)
                                <a href="{{ route('manage.admin.new') }}"
                                   class="btn btn-success"> @lang('admin.Add New Admin')</a>
                                <button type="submit" class="btn btn-info"><i
                                            class="fa fa-refresh"></i> @lang('admin.Update')</button>
                            @else
                                <a href="{{ route('manage.admin') }}"
                                   class="btn btn-default"> @lang('admin.Cancel')</a>
                                <button type="submit" class="btn btn-success"><i
                                            class="fa fa-plus"></i> @lang('admin.Save')</button>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/az.js"></script>
    <script>

        $(function () {

            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });

        });

    </script>
@endsection