@extends('blog::layouts.master')

@section('title', 'Posts Index')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <div class="">
                    <h4 class="">Posts Index</h4>
                    <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusamus alias culpa cum eaque id itaque laboriosam omnis soluta voluptatum.</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>User</th>
                            <th>Created</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->users->name}}</td>
                                <td>{{ $post->created_at->diffForHumans() }}</td>
                                <td><a href="{{ route('blog::posts.auth.edit', $post->id) }}" class="btn btn-success">Edit</a></td>
                                <td>
                                    <form action="{{ route('blog::posts.auth.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <input type="submit" value="Delete" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <h3 class="">No category found!</h3>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $posts->links() }}

            </div>
        </div>
    </div>
@endsection