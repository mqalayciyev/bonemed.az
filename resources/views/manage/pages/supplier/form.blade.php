@extends('manage.layouts.master')
@section('title', __('admin.Supplier Manager'))
@section('head')

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
    <form action="{{ route('manage.supplier.save', @$entry->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <section class="content-header">
            <h1 class="pull-left">@lang('admin.Supplier')</h1>
            <div class="pull-right">
                @if($entry->id>0)
                    <a href="{{ route('manage.supplier.new') }}"
                       class="btn btn-success"> @lang('admin.Add New Supplier')</a>
                    <button type="submit" {{ $disabled }} class="btn btn-info"><i
                                class="fa fa-refresh"></i> @lang('admin.Update')</button>
                @else
                    <a href="{{ route('manage.supplier') }}"
                       class="btn btn-default"> @lang('admin.Cancel')</a>
                    <button type="submit" {{ $disabled }} class="btn btn-success"><i
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
                                        <h3>@lang('admin.Details')</h3>
                                        <span>@lang('admin.You can also choose to set a default markup, making setting up products easier.')</span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">@lang('admin.Name')</label>
                                                    <input type="text" class="form-control" id="name"
                                                           placeholder="@lang('admin.Name')"
                                                           name="name"
                                                           value="{{ old('name', $entry->name) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="markup">@lang('admin.Markup')</label>
                                                    <input type="text" class="form-control" id="markup"
                                                           placeholder="@lang('admin.Markup')"
                                                           name="markup"
                                                           value="{{ old('markup', $entry->markup) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">@lang('admin.Description')</label>
                                                    <textarea class="form-control" id="description"
                                                              placeholder="@lang('admin.Description')"
                                                              name="description">{{ old('description', $entry->description) }}</textarea>
                                                    <script>
                                                        CKEDITOR.replace('description', {
                                                            fullPage: true,
                                                            allowedContent: true,
                                                            autoGrow_onStartup: true,
                                                            enterMode: CKEDITOR.ENTER_BR
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
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
                                                    <label for="company">@lang('admin.Company')</label>
                                                    <input type="text" class="form-control" id="company"
                                                           placeholder="@lang('admin.Company')"
                                                           name="company"
                                                           value="{{ old('company', $entry->company) }}">
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
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fax">@lang('admin.Fax')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="fax"
                                                               placeholder="@lang('admin.Fax')"
                                                               name="fax"
                                                               value="{{ old('fax', $entry->fax) }}">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-fax"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="website">@lang('admin.Website')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="website"
                                                               placeholder="@lang('admin.Website')"
                                                               name="website"
                                                               value="{{ old('website', $entry->website) }}">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-globe"></i>
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
                                <a href="{{ route('manage.supplier.new') }}"
                                   class="btn btn-success"> @lang('admin.Add New Supplier')</a>
                                <button type="submit" {{ $disabled }} class="btn btn-info"><i
                                            class="fa fa-refresh"></i> @lang('admin.Update')</button>
                            @else
                                <a href="{{ route('manage.supplier') }}"
                                   class="btn btn-default"> @lang('admin.Cancel')</a>
                                <button type="submit" {{ $disabled }} class="btn btn-success"><i
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