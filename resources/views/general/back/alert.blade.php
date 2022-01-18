@if(session()->has('message'))
    <div class="alert alert-{{ session('message_type') }} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fa fa-{{ session('message_icon') }}"></i> {{ session('message') }}
    </div>
@endif
