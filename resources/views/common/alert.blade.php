@if(session()->has('message'))
    <div class="alert alert-{{ session('message_type') }} callout callout-{{ session('message_type') }} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>{{ session('message') }}</h4>
    </div>
@endif