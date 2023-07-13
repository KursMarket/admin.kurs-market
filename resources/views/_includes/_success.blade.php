@if(session('message'))
    <div class="alert alert-primary" role="alert">{!! session('message') !!}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger" role="alert">{!! session('error') !!}</div>
@endif
