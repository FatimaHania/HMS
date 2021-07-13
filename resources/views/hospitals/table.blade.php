<div class="table-responsive-sm">
    <table class="table table-striped" id="hospitals-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Short Code</th>
        <th>Logo</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($hospitals as $hospital)
            <tr>
                <td>{{ $hospital->name }}</td>
            <td>{{ $hospital->short_code }}</td>
            <td>{{ $hospital->logo }}</td>
                <td>
                    <div class='btn-group'>
                        <a href="{{ route('hospitals.show', [$hospital->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-file-text-o"></i></a>
                        <a href="{{ route('hospitals.edit', [$hospital->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        <a href="{{ route('branches.index', [$hospital->id]) }}" class='btn btn-xs btn-ghost-secondary'><i class="fa fa-random"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>