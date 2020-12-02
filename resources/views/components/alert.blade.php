@if(Session::has(config('blog.flash_variable')))
    <div class="alert alert-success">
        {{ Session::get(config('blog.flash_variable')) }}
    </div>
@endif