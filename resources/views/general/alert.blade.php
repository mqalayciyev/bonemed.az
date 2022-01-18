@if(session()->has('message'))
    <div class="alert alert-{{ session('message_type') }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="icon fa fa-{{ session('message_icon') }}"></i> {{ session('message') }}
    </div>
@endif
