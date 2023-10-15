@if($admins->isNotEmpty())
    <br>
<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th>Created at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($admins as $admin)
        <tr>
            <td>{{ $admin->id }}</td>
            <td>
                <a style="color: red" href="{{ route('admin.admins.edit', $admin->id) }}">
                    {{ $admin->name }}
                </a>
            </td>
            <td>{{ $admin->email }}</td>
            <td>

            </td>
            <td>{{ $admin->created_at->format('d/m/Y ,  h:i:s A')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $admins->withQueryString()->links() }}

@else
    <br>
    <h1>No results</h1>
@endif
