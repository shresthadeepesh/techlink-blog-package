<div class="container">
    <div class="shadow-lg hover:shadow-xl duration-500 transition-shadow">
        <div class="p-5">
            <div class="my-5">
                <h4 class="text-3xl font-display">{{ $title }}</h4>
                <p class="text-lg font-body">{{ $description }}</p>
            </div>

            <div class="">
                <table class="table-fixed border border-collapse text-center">
                    <thead>
                    <tr>
                        <th class="w-auto border">#</th>
                        @foreach($fillables as $key => $value)
                            <th class="w-1/4 border">{{ Str::title($key) }}</th>
                        @endforeach
                        <th class="w-1/4 border">Edit</th>
                        <th class="w-1/4 border">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($models as $model)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
{{--                                looping for fillable table columns--}}
                                @foreach($fillables as $fillable)

                                    @switch($fillable)
                                        @case('users')
                                            <td class="border">{{ $model[$fillable]->name }}</td>
                                            @break
                                        @case('images')
                                            <td class="border"><img src="{{ asset($model[$fillable]->url ?? null) }}" alt="" style="height: 75px;" /></td>
                                            @break
                                        @case('description')
                                            <td class="border">{{ Str::words($model[$fillable], 50) }}</td>
                                            @break
                                        @case('meta')
                                            <td class="border">{{ $model[$fillable]->keywords }}</td>
                                            @break
                                        @case('created_at')
                                            <td class="border">{{ $model[$fillable]->diffForHumans() }}</td>
                                            @break
                                        @default
                                            <td class="border">{{ $model[$fillable] }}</td>
                                            @break
                                    @endswitch

                                @endforeach
{{--                                end the loop for fillables--}}
                                <td class="border"><a href="{{ route("blog::{$type}.auth.edit", $model->id) }}" class="btn btn-primary">Edit</a></td>
                                <td class="border">
                                    <form action="{{ route("blog::{$type}.auth.destroy", $model->id) }}" method="POST">
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

                <div class="pagination">
                    {{ $models->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
