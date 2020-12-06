@extends('blog::layouts.master')

@section('title', 'Posts Index')

@section('content')
    <div class="container">
        <div class="shadow-lg hover:shadow-xl duration-500 transition-shadow">
            <div class="p-5">
                <div class="">
                    <h4 class="">Posts Index</h4>
                    <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusamus alias culpa cum eaque id itaque laboriosam omnis soluta voluptatum.</p>
                </div>

                <div class="">
                    <table class="table-fixed border border-collapse text-center">
                        <thead>
                        <tr>
                            <th class="w-auto border">#</th>
                            <th class="w-2/4 border">Title</th>
                            <th class="w-1/4 border">Image</th>
                            <th class="w-1/4 border">User</th>
                            <th class="w-1/4 border">Created</th>
                            <th class="w-1/4 border">Edit</th>
                            <th class="w-1/4 border">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td class="border">{{ $loop->iteration }}</td>
                                <td class="border">{{ $post->title }}</td>
                                <td class="border"><img src="{{ asset($post->images->url ?? null) }}" alt="" style="height: 75px;" /></td>
                                <td class="border">{{ $post->users->name}}</td>
                                <td class="border">{{ $post->created_at->diffForHumans() }}</td>
                                <td class="border"><a href="{{ route('blog::posts.auth.edit', $post->id) }}" class="btn btn-primary">Edit</a></td>
                                <td class="border">
                                    <form action="{{ route('blog::posts.auth.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <input type="submit" value="Delete" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                        @empty
                           <tr>
                               <td colspan="100%" class="text-center">No post found!</td>
                           </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $posts->links() }}

            </div>
        </div>
    </div>
@endsection