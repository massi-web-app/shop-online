@if(\Illuminate\Support\Facades\Session::has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{\Illuminate\Support\Facades\Session::get('message')}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
