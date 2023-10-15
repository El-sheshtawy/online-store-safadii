@if($roles->isNotEmpty())
    <br>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th>Created at</th>
            <th style="text-align: center;"  colspan="2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->created_at->format('l, jS \of F Y, h:i:s A')}}</td>
                @can('update',$role)
                    <td>
                        <a href="{{ route('admin.roles.edit',$role->id) }}" class="btn btn-primary">Edit</a>
                    </td>
                @endcan

                @can('delete',$role)
                    <td>
                        <form action="{{ route('admin.roles.destroy',$role->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                @endcan
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $roles->withQueryString()->links() }}

@else
    <br>
    <h1>No results</h1>
@endif
