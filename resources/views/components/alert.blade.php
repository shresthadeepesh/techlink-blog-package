@if(Session::has(config('blog.flash_variable')))
    <div class="alert alert-success">
        {{ config('blog.flash_variable') }}
    </div>
@endif