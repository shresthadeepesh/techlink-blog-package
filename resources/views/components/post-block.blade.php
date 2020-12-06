<div class="w-full md:w-1/2 lg:w-1/3">
    <div class="p-2">
        <div class="shadow-lg hover:shadow-xl transition-hover duration-500 rounded-md">
                @if($post->images)
                    <div class="image overflow-hidden rounded-t-md">
                        <img src="{{ asset($post->images->url ?? null) }}" alt="{{ $post->title }}" class="h-80 w-full hover:scale-125 transform duration-500" />
                    </div>
                @endif
                <div class="content lg:p-10 p-8 space-y-3">
                    <h3 class="text-3xl font-display">
                        <a class="text-ascent hover:text-secondary font-bold"
                                href="{{ $post->path() }}">{{ $post->title ?? 'This is the default post header.' }}</a>
                    </h3>
                    <ul class="list-inline text-primary">
                        <li class="list-inline-item">{{ $post->created_at->format('d M, Y') }}</li>
                    </ul>
                    <p class="text-primary font-body">{{ Str::words($post->description, 50) ?? null }}</p>

                    <div class="comma-separated text-center">
                        @foreach($post->categories as $category)
                            <span><a href="{{ $category->path() }}" class="hover:text-secondary text-primary">{{ $category->title }}</a></span>
                        @endforeach
                    </div>

                    <div class="">
                        <a href="{{ $post->path() }}"
                           class="text-center text-lg text-white bg-ascent hover:bg-secondary px-5 py-4">Read More</a>
                    </div>
                </div>
        </div>
    </div>
</div>