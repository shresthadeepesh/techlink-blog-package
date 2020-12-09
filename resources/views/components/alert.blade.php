@if(Session::has(config('blog.flash_variable')))
    <div class="alert alert-success bg-green-400 text-white hover:opacity-80 transition-opacity duration-500">
        <div class="p-5 my-5">
            <h3 class="text-xl">{{ Session::get(config('blog.flash_variable')) }}</h3>
        </div>
    </div>
@endif