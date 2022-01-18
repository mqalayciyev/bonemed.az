@extends('manage.layouts.master')
@section('title', __('admin.Slider Manager'))
@section('head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('manage/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="pull-left">@lang('admin.Sliders')</h1>
        <div class="pull-right">
            <a href="{{ route('manage.slider.new') }}" class="btn btn-success">@lang('admin.Add New Slider')</a>
        </div>
        <div class="clearfix"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form id="form">
                            <table id="index_table" class="table table-bordered table-striped table-hover display">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('admin.Image')</th>
                                    <th>@lang('admin.Slider Name')</th>
                                    <th>@lang('admin.Slider Slug')</th>
                                    <th>@lang('admin.Created at')</th>
                                    <th></th>
                                    <th width="125px">@lang('admin.Action')</th>
                                    <th>
                                        <button type="button" {{ $disabled }} title="@lang('admin.Select and Delete')" name="bulk_delete"
                                                id="bulk_delete"
                                                class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                    </th>
                                </tr>
                                </thead>
                            </table>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="{{ asset('manage/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('manage/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            $.fn.dataTable.ext.errMode = 'throw';
            $('#index_table').DataTable({
                order: [[0, "asc"]],
                processing: true,
                serverSide: true,
                ordering: true,
                paging: true,
                ajax: '{{ route('manage.slider.index_data', isset($brand_id) ? $brand_id : '') }}',
                columns: [
                    {data: 'slider_order', searchable: false},
                    {data: 'slider_image', orderable: false, searchable: false},
                    {data: 'slider_name'},
                    {data: 'slider_slug'},
                    {data: 'created_at'},
                    {data: 'slider_active', orderable: false, searchable: false},
                    {data: 'action', orderable: false, searchable: false},
                    {data: 'checkbox', orderable: false, searchable: false},
                ],
                language: {
                    "sEmptyTable": "{{ __('admin.No data available in table') }}",
                    "sInfo": "{{ __('admin.Showing _START_ to _END_ of _TOTAL_ entries') }}",
                    "sInfoEmpty": "{{ __('admin.Showing 0 to 0 of 0 entries') }}",
                    "sInfoFiltered": "({{ __('admin.filtered from _MAX_ total entries') }})",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLengthMenu": "{{ __('admin.Show _MENU_ entries') }}",
                    "sLoadingRecords": "{{ __('admin.Loading...') }}",
                    "sProcessing": "{{ __('admin.Processing...') }}",
                    "sSearch": "{{ __('admin.Search:') }}",
                    "sZeroRecords": "{{ __('admin.No matching records found') }}",
                    "oPaginate": {
                        "sFirst": "{{ __('admin.First') }}",
                        "sLast": "{{ __('admin.Last') }}",
                        "sNext": "{{ __('admin.Next') }}",
                        "sPrevious": "{{ __('admin.Previous') }}"
                    },
                    "oAria": {
                        "sSortAscending": "{{ __('admin.: activate to sort column ascending') }}",
                        "sSortDescending": "{{ __('admin.: activate to sort column descending') }}"
                    }
                }
            });

            $('tbody').sortable({
                opacity: 0.6,
                cursor: 'move',
                tolerance: 'pointer',
                revert: true,
                placeholder: 'state',
                forcePlaceholderSize: true,
                update: function () {
                    var serialize = $("form#form").serialize();
                    $.ajax({
                        url: "{{ route('manage.slider.reorder') }}",
                        type: "post",
                        data: {serialize: serialize},
                        success: function () {
                            $('#index_table').DataTable().ajax.reload();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $.each(jqXHR, function (key, val) {
                                console.log(key);
                                console.log(val);
                            });
                            console.log(jqXHR + textStatus + errorThrown);
                        }
                    });
                }
            });

            $(document).on('click', '.delete', function () {
                var id = $(this).attr('id');
                if (confirm('{{ __('admin.Are you sure you want to delete this data?') }}')) {
                    $.ajax({
                        url: '{{ route('manage.slider.delete_data') }}',
                        method: 'GET',
                        data: {id: id},
                        success: function (data) {
                            alert(data);
                            $('#index_table').DataTable().ajax.reload();
                        }
                    });
                } else {
                    return false;
                }
            });

            $(document).on('click', '#bulk_delete', function () {
                var id = [];
                if (confirm('{{ __('admin.Are you sure you want to delete this data?') }}')) {
                    $('.checkbox:checked').each(function () {
                        id.push($(this).val());
                    });
                    if (id.length > 0) {
                        $.ajax({
                            url: '{{ route('manage.slider.mass_remove') }}',
                            method: 'GET',
                            data: {id: id},
                            success: function (data) {
                                alert(data);
                                $('#index_table').DataTable().ajax.reload();
                            }
                        });
                    } else {
                        alert('{{ __('admin.Please select at least one checkbox') }}');
                    }
                } else {
                    return false;
                }
            });
        });
    </script>
@endsection
