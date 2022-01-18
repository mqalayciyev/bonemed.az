@extends('manage.layouts.master')
@section('title', __('admin.Review'))
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
        <h1 class="pull-left">@lang('admin.Reviews')</h1>
        {{-- <div class="pull-right">
            <a href="{{ route('manage.product.new') }}" class="btn btn-success">@lang('admin.Add New Product')</a>
        </div> --}}
        <div class="clearfix"></div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('common.alert')
                @include('common.errors.validate')
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="index_table" class="table table-bordered table-striped table-hover display"
                               style="width:100%">
                            <thead>
                                <tr>
                                    <th>@lang('admin.Name')</th>
                                    <th>@lang('admin.Email')</th>
                                    <th>Məhsul şəkli</th>
                                    <th>Məhsul adı</th>
                                    <th>Rəy</th>
                                    <th>Rating</th>
                                    <th>@lang('admin.Created at')</th>
                                    <th width="125px">@lang('admin.Action')</th>
                                    <th>
                                        <button type="button" title="@lang('admin.Select and Delete')" name="bulk_delete"
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
        <!-- Modal -->
        <div class="modal fade" id="viewModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Rəylər</h4>
                </div>
                <div class="modal-body">
                <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Bağla</button>
                </div>
            </div>
            
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
            // $.fn.dataTable.ext.errMode = 'throw';
            $('#index_table').DataTable({
                order: [[0, "desc"]],
                processing: true,
                serverSide: true,
                ordering: true,
                paging: true,
                ajax: "{{ route('manage.review.index_data')}}",
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email'},
                    {data: 'product'},
                    {data: 'product_name'},
                    {data: 'review'},
                    {data: 'rating'},
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

            $(document).on('click', '.delete', function () {
                var id = $(this).attr('id');
                if (confirm("{{ __('admin.Are you sure you want to delete this data?') }}")) {
                    $.ajax({
                        url: "{{ route('manage.review.delete_data') }}",
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
                if (confirm("{{ __('admin.Are you sure you want to delete this data?') }}")) {
                    $('.checkbox:checked').each(function () {
                        id.push($(this).val());
                    });
                    if (id.length > 0) {
                        $.ajax({
                            url: "{{ route('manage.review.mass_remove') }}",
                            method: 'GET',
                            data: {id: id},
                            success: function (data) {
                                alert(data);
                                $('#index_table').DataTable().ajax.reload();
                            }
                        });
                    } else {
                        alert("{{ __('admin.Please select at least one checkbox') }}");
                    }
                } else {
                    return false;
                }
            });

            $("input[name=name]").change(function () {
                var val = $(this).val();
                $("input[name=slug]").val(val);
            });

            $(document).on('click', '.view', function(){
                let id = $(this).attr('data-id');
                
                $.ajax({
                    url: "{{ route('manage.review.view') }}",
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", id},
                    success: function(data){
                        $("#viewModal").modal('show');
                        $("#viewModal").find('.modal-body').html('')
                        $("#viewModal").find('.modal-body').append(`<h4>${data.name}</h4>`)
                        $("#viewModal").find('.modal-body').append(`<a href="mailto:${data.email}">${data.email}</a>`)
                        $("#viewModal").find('.modal-body').append(`<p>${data.review}</p>`)
                    }
                })
            })

        });
    </script>
@endsection