<div class="table-responsive-sm">
    <table class="table table-striped" id="branches-table">
        <thead>
            <tr>
        <th>Name</th>
        <th>Short Code</th>
        <th>Telephone</th>
        <th>Address</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($branches as $branch)
            <tr>
                <td>{{ $branch->hospital_id }}</td>
            <td>{{ $branch->name }}</td>
            <td>{{ $branch->short_code }}</td>
            <td>{{ join("/" , array($branch->telephone_1 , $branch->telephone_2 , $branch->telephone_3)) }}</td>
            <td>{{ $branch->address }}</td>
                <td>
                    <div class='btn-group'>
                        <a href="{{ route('branches.show', [$branch->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('branches.edit', [$branch->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>