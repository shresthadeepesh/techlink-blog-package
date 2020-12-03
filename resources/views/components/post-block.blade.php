<div class="col-md-4">
    <div class="p-2">
        <div class="card shadow">
            <div class="card-body">
                <div class="image">
                    <img src="{{ asset($post->images->url ?? null) }}" alt="" class="img-fluid" />
                </div>
                <div class="content">
                    <h3 class="">
                        <a href="{{ $post->path() }}">{{ $post->title ?? 'This is the default post header.' }}</a>
                    </h3>
                    <ul class="list-inline">
                        <li class="list-inline-item">{{ $post->created_at->format('d M, Y') }}</li>
                    </ul>
                    <p class="lead">{{ Str::words($post->description, 25) ?? null }}</p>
                </div>
            </div>
        </div>
    </div>
</div>