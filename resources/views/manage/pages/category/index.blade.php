@extends('manage.layouts.master')
@section('title', __('admin.Category Manager'))
@section('head')
    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{ asset('manage/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
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
        <h1 class="pull-left">@lang('admin.Categories')</h1>
        <div class="pull-right">
            <button class="btn btn-success" id="add_data">
                <i class="fa fa-plus"></i> @lang('admin.Add New Category')
            </button>
        </div>
        <div class="clearfix"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('common.alert')
                @include('common.errors.validate')
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="modal fade" id="form_modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post" id="form">
                                        {{ csrf_field() }}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">@lang('admin.Add New Category')</h4>
                                        </div>
                                        <div class="modal-body">
                                            <span id="form_output"></span>
                                            <div class="form-group">
                                                <label for="top_id">@lang('admin.Top Category')</label>
                                                <select name="top_id" id="top_id" class="form-control">
                                                    <option value="">@lang('admin.Parent Category')</option>
                                                    @foreach($categories as $category)
                                                        @if($category->top_id==null)
                                                            <option style="color:#000;"
                                                                    value="{{ $category->id }}" {{ $entry->top_category->id == $category->id ? 'selected' : '' }}>
                                                                {{ $category->category_name }}</option>
                                                            @foreach($categories as $alt_category)
                                                                @if($alt_category->top_id==$category->id)
                                                                    <option value="{{ $alt_category->id }}" {{ $entry->top_category->id == $alt_category->id ? 'selected' : '' }}>
                                                                        -- {{ $alt_category->category_name }}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="category_name">@lang('admin.Category Name')</label> <br>
                                                <input type="text" name="category_name" class="form-control"
                                                       id="category_name" placeholder="@lang('admin.Category Name')"
                                                       value="{{ old('category_name') }}">
                                                <input type="hidden" name="id" value="" id="id">
                                            </div>
                                            <div class="form-group">
                                                <label for="slug">@lang('admin.Slug')</label> <br>
                                                <input type="text" name="slug" class="form-control"
                                                       id="slug" placeholder="@lang('admin.Slug')"
                                                       value="{{ old('slug') }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="button_action" id="button_action"
                                                   value="insert"/>
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">@lang('admin.Close')</button>
                                            <input type="submit" {{ $disabled }} name="submit" id="action"
                                                   class="btn btn-success" value="@lang('admin.Save Category')"/>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="index_table" class="table table-bordered table-striped table-hover display"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>@lang('admin.Top Category')</th>
                                <th>@lang('admin.Category Name')</th>
                                <th>@lang('admin.Updated at')</th>
                                <th>@lang('admin.Created at')</th>
                                <th>@lang('admin.Action')</th>
                                <th>
                                    
                                    <button type="button" {{ $disabled }} title="@lang('admin.Select and Delete')" name="bulk_delete"
                                            id="bulk_delete"
                                            class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <!-- DataTables -->
    <script src="{{ asset('manage/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('manage/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {

            $('#index_table').DataTable({
                order: [[2, "desc"]],
                processing: true,
                serverSide: true,
                ajax: '{{ route('manage.category.index_data') }}',
                columns: [
                    {data: 'parent_category'},
                    {data: 'category_name'},
                    {data: 'updated_at'},
                    {data: 'created_at'},
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

            $('#add_data').click(function () {
                $('#form_modal').modal('show');
                $('#form')[0].reset();
                $('#form_output').html('');
                $('#button_action').val('insert');
                $('#action').val('{{ __('admin.Save Category') }}');
            });

            $('#form').on('submit', function (event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    url: '{{ route('manage.category.post_data') }}',
                    data: form_data,
                    dataType: 'json',
                    success: function (data) {
                        if (data.error.length > 0) {
                            var error_html = '';
                            for (var count = 0; count < data.error.length; count++) {
                                error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                            }
                            $('#form_output').html(error_html).hide().fadeIn('slow');
                        } else {
                            $('#form_output').html(data.success).hide().fadeIn('slow').fadeTo(5000, 0.50);
                            $('#form')[0].reset();
                            $('#action').val('{{ __('admin.Save Category') }}');
                            $('.modal-title').text('{{ __('admin.Add New Category') }}');
                            $('#button_action').val('insert');
                            $('#form_modal').modal('hide');
                        }
                    }
                });
                $(document).ajaxStop(function(){
                    window.location.reload();
                });
            });

            $(document).on('click', '.edit', function () {
                var id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('manage.category.fetch_data') }}',
                    method: 'GET',
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        $('#top_id').val(data.top_id);
                        $('#category_name').val(data.category_name);
                        $('#slug').val(data.slug);
                        $('#id').val(id);
                        $('#form_modal').modal('show');
                        $('#action').val('{{ __('admin.Edit') }}');
                        $('.modal-title').text('{{ __('admin.Edit Data') }}');
                        $('#button_action').val('update');
                    }
                });
            });

            $(document).on('click', '.delete', function () {
                var id = $(this).attr('id');
                if (confirm('{{ __('admin.Are you sure you want to delete this data?') }}')) {
                    $.ajax({
                        url: '{{ route('manage.category.delete_data') }}',
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
                            url: '{{ route('manage.category.mass_remove') }}',
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

            $("input[name=name]").change(function () {
                var val = $(this).val();
                $("input[name=slug]").val(val);
            });

        });
    </script>
@endsection