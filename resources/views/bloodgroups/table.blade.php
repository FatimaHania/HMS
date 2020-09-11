<div class="table-responsive-sm">
    <table class="table table-striped" id="bloodgroups-table">
        <thead>
            <tr>
                <th>Short Code</th>
        <th>Description</th>
                <th colspan="3" class="th_action">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($bloodgroups as $bloodgroup)
            <tr>
                <td>{{ $bloodgroup->short_code }}</td>
            <td>{{ $bloodgroup->description }}</td>
                <td>
                    {!! Form::open(['route' => ['bloodgroups.destroy', $bloodgroup->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('bloodgroups.show', [$bloodgroup->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('bloodgroups.edit', [$bloodgroup->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>