@extends('blog::layouts.master')

@section('title', 'Categories Index')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <div class="">
                    <h4 class="">Categories Index</h4>
                    <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusamus alias culpa cum eaque id itaque laboriosam omnis soluta voluptatum.</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Posts</th>
                                <th>User</th>
                                <th>Created</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->title }}</td>
                                <td>{{ $category->posts_count }}</td>
                                <td>{{ $category->users->name}}</td>
                                <td>{{ $category->created_at->diffForHumans() }}</td>
                                <td><a href="{{ route('blog::categories.auth.edit', $category->id) }}" class="btn btn-success">Edit</a></td>
                                <td>
                                    <form action="{{ route('blog::categories.auth.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <input type="submit" value="Delete" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">No category found!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $categories->links() }}

            </div>
        </div>
    </div>
@endsection